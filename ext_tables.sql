#
# Table structure for table 'tx_feuploadexample_domain_model_project'
#
CREATE TABLE tx_feuploadexample_domain_model_project (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	fe_user_id int(11) unsigned NOT NULL default '0',
	files int(11) unsigned NOT NULL default '0',
);