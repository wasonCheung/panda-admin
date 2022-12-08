CREATE TABLE `{prefix}user_group`
(
    `id`                 int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '用户组id',
    `status`             tinyint unsigned      DEFAULT 1 COMMENT '状态:0=禁用,1=启用',
    `name`               varchar(50)  NOT NULL DEFAULT '' COMMENT '用户组名',
    `rules`              text         NOT NULL COMMENT '权限规则ID',
    `coins_for_day`      smallint              DEFAULT 0 COMMENT '包日硬币数量',
    `coins_for_month`    smallint              DEFAULT 0 COMMENT '包月硬币数量',
    `coins_for_year`     smallint              DEFAULT 0 COMMENT '包年硬币数量',
    `coins_for_infinite` smallint              DEFAULT 0 COMMENT '无限日期硬币数量',
    `create_time`        int unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
    `update_time`        int unsigned NOT NULL DEFAULT 0 COMMENT '更新时间'
) ENGINE = InnoDB
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci COMMENT ='会员组表';