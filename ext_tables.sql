#
# Table structure for table 'tx_feuploadexample_domain_model_project'
#
create table tx_feuploadexample_domain_model_project (
	uid int(11) not null auto_increment,
	pid int(11) default '0' not null,
	name varchar(255) default '' not null,
	fe_user_id int(11) unsigned not null default '0',
	files int(11) unsigned not null default '0',

	tstamp int(11) unsigned default '0' not null,
	crdate int(11) unsigned default '0' not null,
	cruser_id int(11) unsigned default '0' not null,
	deleted tinyint(4) unsigned default '0' not null,
	hidden tinyint(4) unsigned default '0' not null,
	starttime int(11) unsigned default '0' not null,
	endtime int(11) unsigned default '0' not null,

	t3ver_oid int(11) default '0' not null,
	t3ver_id int(11) default '0' not null,
	t3ver_wsid int(11) default '0' not null,
	t3ver_label varchar(255) default '' not null,
	t3ver_state tinyint(4) default '0' not null,
	t3ver_stage int(11) default '0' not null,
	t3ver_count int(11) default '0' not null,
	t3ver_tstamp int(11) default '0' not null,
	t3ver_move_id int(11) default '0' not null,
	t3_origuid int(11) default '0' not null,

	sys_language_uid int(11) default '0' not null,
	l10n_parent int(11) default '0' not null,
	l10n_diffsource mediumblob,

	primary key (uid),
	key parent(pid),
	key t3ver_oid(t3ver_oid, t3ver_wsid),
	key language(l10n_parent, sys_language_uid)
);