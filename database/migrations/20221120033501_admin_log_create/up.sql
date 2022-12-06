CREATE TABLE `{prefix}admin_log`
(
    `id`          int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `admin_id`    int unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
    `admin_name`    varchar(30)  NOT NULL DEFAULT '' COMMENT '管理员用户名',
    `url`         varchar(500)          DEFAULT '' COMMENT '操作Url',
    `title`       varchar(100)          DEFAULT '' COMMENT '日志标题',
    `data`        text COMMENT '请求数据',
    `ip`          varchar(50)           DEFAULT '' COMMENT 'IP',
    `user_agent`  varchar(1500)         DEFAULT '' COMMENT '客户端信息',
    `ps`          varchar(500)          DEFAULT '' COMMENT '备注信息',
    `create_time` int unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
    `update_time` int unsigned NOT NULL DEFAULT 0 COMMENT '更新时间',
    PRIMARY KEY (`id`),
    KEY `admin_name` (`admin_name`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci COMMENT ='管理员日志表';