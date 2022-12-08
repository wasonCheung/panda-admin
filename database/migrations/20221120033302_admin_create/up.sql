CREATE TABLE `{prefix}admin`
(
    `id`              int unsigned     NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '主键',
    `admin_group_id`  int unsigned     NOT NULL DEFAULT 0 COMMENT '管理组id',
    `status`          tinyint unsigned NOT NULL DEFAULT 1 COMMENT '状态:0=禁用,1=启用',
    `username`        varchar(30)      NOT NULL DEFAULT '' COMMENT '用户名',
    `password`        varchar(50)      NOT NULL DEFAULT '' COMMENT '密码',
    `nickname`        varchar(30)               DEFAULT '' COMMENT '昵称',
    `avatar`          varchar(150)              DEFAULT '' COMMENT '头像',
    `email`           varchar(50)      NOT NULL DEFAULT '' COMMENT '邮箱',
    `login_failure`   tinyint unsigned          DEFAULT 0 COMMENT '登录失败次数',
    `last_login_time` int unsigned              DEFAULT 0 COMMENT '最后登录时间',
    `last_login_ip`   varchar(50)               DEFAULT '' COMMENT '最后登录ip',
    `create_time`     int unsigned     NOT NULL DEFAULT 0 COMMENT '创建时间',
    `update_time`     int unsigned     NOT NULL DEFAULT 0 COMMENT '更新时间',
    UNIQUE KEY `uni_columns` (`username`, `email`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci COMMENT ='管理员表';