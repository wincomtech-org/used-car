alter table `cmf_usual_coordinate` add `sc_id` smallint(6) unsigned not null default '0' comment '业务模型ID' after `company_id`;
update `cmf_usual_coordinate` set `sc_id`=2;