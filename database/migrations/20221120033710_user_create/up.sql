CREATE TABLE `{prefix}user`
(
    `id`              int unsigned     NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `user_group_id`   int unsigned     NOT NULL DEFAULT 1 COMMENT '用户组id',
    `status`          tinyint unsigned NOT NULL DEFAULT 0 COMMENT '用户状态：0=未审核,1=正常,2=被禁用',
    `username`        varchar(30)      NOT NULL DEFAULT '' COMMENT '用户名',
    `password`        varchar(50)      NOT NULL DEFAULT '' COMMENT '密码',
    `nickname`        varchar(50)               DEFAULT '' COMMENT '昵称',
    `email`           varchar(50)      NOT NULL DEFAULT '' COMMENT '邮箱地址',
    `avatar`          varchar(150)              DEFAULT '' COMMENT '头像',
    `question`        varchar(255)              DEFAULT '' COMMENT '安全问题',
    `answer`          varchar(255)              DEFAULT '' COMMENT '安全答案',
    `about_me`        varchar(255)              DEFAULT '' COMMENT '关于我',
    `gender`          tinyint unsigned          DEFAULT 0 COMMENT '性别:1=男,2=女,0=人妖',
    `birthday`        int unsigned              DEFAULT 0 COMMENT '生日',
    `coins`           int unsigned              DEFAULT 0 COMMENT '金币',
    `login_num`       int unsigned              DEFAULT 0 COMMENT '登录次数',
    `last_login_time` int unsigned              DEFAULT 0 COMMENT '上次登录时间',
    `last_login_ip`   varchar(50)               DEFAULT '' COMMENT '上次登录IP',
    `login_failure`   tinyint unsigned          DEFAULT 0 COMMENT '登录失败次数',
    `create_time`     int unsigned     NOT NULL DEFAULT 0 COMMENT '创建时间',
    `update_time`     int unsigned     NOT NULL DEFAULT 0 COMMENT '更新时间',
    PRIMARY KEY (`id`),
    KEY `normal` (`username`, `email`, `status`, `user_group_id`, `gender`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci COMMENT ='用户表';