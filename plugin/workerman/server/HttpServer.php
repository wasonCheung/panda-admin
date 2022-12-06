<?php

namespace plugin\workerman\server;

use plugin\workerman\WorkerApplication;
use think\exception\Handle;
use Throwable;
use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request as WorkerRequest;
use Workerman\Protocols\Http\Response as WorkerResponse;
use Workerman\Worker;

/**
 * @Data: 2022/11/26
 * @Author: WasonCheung
 * @Description worker for http
 */
class HttpServer extends BaseServer
{
    public WorkerApplication $application;
    public string $rootPath;
    public string $moduleName;
    public string $publicPath;
    public bool $debug = false;

    public function __construct(string $rootPath, string $moduleName, array $config)
    {
        $this->rootPath = $rootPath;
        $this->moduleName = $moduleName;
        $this->publicPath = $this->rootPath . 'public' . DIRECTORY_SEPARATOR;
        // 实例化worker
        parent::__construct(
            new Worker(
                "http://{$config['host']}:{$config['port']}",
                $config['options']['context'] ?? []
            ),
            $config['options']
        );
    }

    /**
     * @Data: 2022/11/29
     * @Author: WasonCheung
     * @Description: 启动事件
     */
    public function onWorkerStart(Worker $worker): void
    {
        $this->application = (new WorkerApplication($this->rootPath))->initialize();

        $this->application->instance(WorkerApplication::class, $this->application);
        $this->application->instance(Worker::class, $worker);

        $this->debug = $this->application->isDebug();
        // 初始化应用
        // 设置应用名
        if ($this->moduleName !== 'auto') {
            $this->application->http->name($this->moduleName);
        }
    }

    /**
     * @param TcpConnection $connection
     * @param mixed $data
     * @Data: 2022/11/29
     * @Author: WasonCheung
     * @Description: 请求接收
     */
    public function onMessage(TcpConnection $connection, mixed $data): void
    {
        /*** @var WorkerRequest $data */
        $workerRequest = $data;
        if ($this->resourcesHandle($connection, $workerRequest)) {
            return;
        }

        // 重置app状态信息
        $this->application->workerApplicationInit();

        // 保存workerman相关对象到容器中
        $workerResponse = new WorkerResponse();
        $this->application->instance(WorkerResponse::class, $workerResponse);
        $this->application->instance(TcpConnection::class, $connection);
        $this->application->instance(WorkerRequest::class, $workerRequest);

        // 设置sessionId
        $this->application->session->setId($workerRequest->sessionId());

        try {
            // 请求处理
            while (ob_get_level() > 1) {
                ob_end_clean();
            }
            ob_start();

            // app 运行
            $thinkResponse = $this->application->http->run();
            // 渲染数据
            $thinkResponse->send();
            // 运行结束
            $this->application->http->end($thinkResponse);

            $content = ob_get_clean();

            // workerman 响应对象
            $workerResponse
                ->withStatus($thinkResponse->getCode())
                ->withHeaders($thinkResponse->getHeader())
                ->withBody($content);
        } catch (Throwable $e) {
            $handler = $this->application->make(Handle::class);
            $handler->report($e);
            $thinkResponse = $handler->render($this->application->request, $e);

            // workerman 响应对象
            $workerResponse
                ->withStatus($thinkResponse->getCode())
                ->withBody($thinkResponse->getContent());
        }
        // 响应内容
        $connection->send($workerResponse);
    }

    /**
     * @param TcpConnection $connection
     * @param WorkerRequest $workerRequest
     * @return bool
     * @Data: 2022/11/29
     * @Author: WasonCheung
     * @Description: 资源请求处理
     */
    protected function resourcesHandle(TcpConnection $connection, WorkerRequest $workerRequest): bool
    {
        // 资源请求处理
        $file = $this->publicPath . $workerRequest->path();
        if (!is_file($file)) {
            return false;
        }

        // 检查if-modified-since头判断文件是否修改过
        if (!empty($if_modified_since = $workerRequest->header('if-modified-since'))) {
            $modified_time = date('D, d M Y H:i:s', filemtime($file)) . ' ' . \date_default_timezone_get();
            // 文件未修改则返回304
            if ($modified_time === $if_modified_since) {
                $connection->send(new WorkerResponse(304));
                return true;
            }
        }

        // 文件修改过或者没有if-modified-since头则发送文件
        $connection->send((new WorkerResponse())->withFile($file));
        return true;
    }
}
