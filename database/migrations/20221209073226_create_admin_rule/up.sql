CREATE TABLE `{prefix}admin_rule`
(
    `id`          int(10) unsigned                        NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `pid`         int(10) unsigned                        NOT NULL DEFAULT '1' COMMENT '权限归属',
    `status`      tinyint(3) unsigned                     NOT NULL DEFAULT '1' COMMENT '状态:0=禁用,1=启用',
    `type`        tinyint(3) unsigned                     NOT NULL DEFAULT '1' COMMENT '类型:1=menu_dir=菜单目录,2=menu=菜单项,3=button=页面按钮',
    `title`       varchar(50) COLLATE utf8mb4_unicode_ci  NOT NULL DEFAULT '' COMMENT '规则标题',
    `name`        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '规则名称',
    `icon`        varchar(50) COLLATE utf8mb4_unicode_ci  NOT NULL DEFAULT '' COMMENT '图标',
    `menu_type`   tinyint(3) unsigned                              DEFAULT NULL COMMENT '菜单类型:tab=选项卡,link=链接,iframe=Iframe',
    `url`         varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Url',
    `component`   varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'vue组件路径',
    `keepalive`   tinyint(3) unsigned                              DEFAULT '0' COMMENT '缓存:0=关闭,1=开启',
    `ps`          varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT '' COMMENT '备注',
    `sort`        int(10) unsigned                                 DEFAULT '1' COMMENT '排序',
    `create_time` int(10) unsigned                        NOT NULL DEFAULT '0' COMMENT '创建时间',
    `update_time` int(10) unsigned                        NOT NULL DEFAULT '0' COMMENT '更新时间',
    PRIMARY KEY (`id`),
    KEY `pid` (`pid`, `sort`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci COMMENT ='后台权限规则表';