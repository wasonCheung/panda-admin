CREATE TABLE `{prefix}admin_group`
(
    `id`          int unsigned     NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '主键',
    `pid`         tinyint unsigned NOT NULL DEFAULT 0 COMMENT '上级分组',
    `name`        varchar(30)      NOT NULL DEFAULT '' COMMENT '组名',
    `status`      tinyint unsigned NOT NULL DEFAULT 1 COMMENT '状态:0=禁用,1=启用',
    `rules`       text             NOT NULL COMMENT '权限规则ID',
    `create_time` int unsigned     NOT NULL DEFAULT 0 COMMENT '创建时间',
    `update_time` int unsigned     NOT NULL DEFAULT 0 COMMENT '更新时间'
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci COMMENT ='管理分组表';