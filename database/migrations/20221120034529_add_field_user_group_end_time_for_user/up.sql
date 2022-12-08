ALTER TABLE `{prefix}user`
    ADD `user_group_end_time` INT UNSIGNED DEFAULT 0 COMMENT '用户组到期时间' AFTER `user_group_id`