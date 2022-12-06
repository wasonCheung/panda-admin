<?php

namespace util;

class PerformanceTestUtil
{
    /**
     * @param callable $call 测试内容
     * @param int $time 测试次数
     * @return array 返回测试数据
     * 获取测试数据
     */
    private static function test(callable $call, int $time = 10000): array
    {
        // 开始时间
        $beginTime = microtime(true);
        // 开始内存
        $beginMem = memory_get_usage();
        for ($i = 0; $i < $time; $i++) {
            $call();
        }
        $runtime = microtime(true) - $beginTime;
        $mem = (memory_get_usage() - $beginMem) / 1024;
        $reqs = $runtime > 0 ? 1 / $runtime : '∞';
        $allTime = $runtime * 1000;
        return [
            'time' => $time,
            'reqs' => $reqs,
            'all_mem' => $mem,
            'mem_av' => $mem / $time,
            'all_time' => $allTime,
            'time_av' => $allTime / $time,
        ];
    }

    /**
     * @param callable $call 测试内容
     * @param int $time 测试次数
     * @return array 返回测试数据和html内容
     * 获取测试数据和html内容
     */
    private static function html(callable $call, int $time = 10000): array
    {
        //测试结果
        $testResult = self::test($call, $time);
        $runtimeHtml = sprintf("<p>运行次数：%s</p>", $time);
        $reqsHtml = sprintf("<p>吞吐量：%sreq/s</p>", number_format($testResult['reqs'], 2));
        $memHtml = sprintf(
            "<p>内存消耗：总%skb，平均%skb</p>",
            number_format($testResult['all_mem'], 6),
            number_format($testResult['mem_av'], 6)
        );
        $timeHtml = sprintf(
            "<p>执行耗时：总%sms，平均%sms</p>",
            number_format($testResult['all_time'], 6),
            number_format($testResult['time_av'], 6)
        );
        $html = $runtimeHtml;
        $html .= $reqsHtml;
        $html .= $memHtml;
        $html .= $timeHtml;
        // 返回测试结果
        return [$testResult, $html];
    }

    /**
     * @param callable $call1 测试1内容
     * @param callable $call2 测试2内容
     * @param int $time 测试次数
     * @return void 返回测试对比数据和html内容
     * 测试对比
     */
    public static function compare(callable $call1, callable $call2, int $time = 10000): void
    {
        // 测试结果一
        [$call1Result, $call1Html] = self::html($call1, $time);
        // 测试结果2
        [$call2Result, $call2Html] = self::html($call2, $time);
        // 输出比较结果
        if ($call1Result['reqs'] > $call2Result['reqs']) {
            echo "<div style='background: rgba(108,237,108,0.68);padding: 20px'>";
            echo "<h5>方案一</h5>";
            echo $call1Html;
            echo "</div>";
            echo "<div style='background: rgba(239,110,110,0.54);padding: 20px'>";
            echo "<h5>方案二</h5>";
            echo $call2Html;
            echo "</div>";
            $reqs = number_format(($call1Result['reqs'] - $call2Result['reqs']) / $call2Result['reqs'] * 100, 2);
            echo sprintf('<h1 style="color: green">吞吐量reqs: 方案一 比 方案二 快了 %s%%</h1>', $reqs);
        } else {
            echo "<div style='background: rgba(239,110,110,0.54);padding: 20px'>";
            echo "<h5>方案一</h5>";
            echo $call1Html;
            echo "</div>";
            echo "<div style='background: rgba(108,237,108,0.68);padding: 20px'>";
            echo "<h5>方案二</h5>";
            echo $call2Html;
            echo "</div>";
            $reqs = number_format(($call2Result['reqs'] - $call1Result['reqs']) / $call1Result['reqs'] * 100, 2);
            echo sprintf('<h1 style="color: green">吞吐量比较: 方案二 比 方案一 快了 %s%%</h1>', $reqs);
        }
    }


    /**
     * @param callable $call 测试内容
     * @param int $time 测试次数——
     * 单测试
     */
    public static function single(callable $call, int $time = 10000): void
    {
        echo self::html($call, $time)[1];
    }
}