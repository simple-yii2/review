create table if not exists `Feedback`
(
	`id` int(10) not null auto_increment,
	`user_id` int(10) default null,
	`active` tinyint(1) default 1,
	`date` datetime default null,
	`name` varchar(50) default null,
	`content` text,
	primary key (`id`),
	key `date` (`active`,`date`)
) engine InnoDB;
