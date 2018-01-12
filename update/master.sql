
alter table `cmf_service_category` add `is_rec` tinyint(1) unsigned not null default '0' comment '推荐：0否 1是';
alter table `cmf_service_category` add `notice` varchar(100) not null default '' comment '温馨提示';
alter table `cmf_usual_coordinate` add `sc_id` smallint(6) unsigned not null default '0' comment '业务模型ID' after `company_id`;
update `cmf_usual_coordinate` set `sc_id`=2;


