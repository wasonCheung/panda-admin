ALTER TABLE `{prefix}admin_group`
    ADD `pid` TINYINT unsigned default 0 COMMENT '上级分组' AFTER id