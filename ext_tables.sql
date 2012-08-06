#
# Table structure for table 'tx_sysjobs_jobs'
#
CREATE TABLE tx_sysjobs_jobs (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	title tinytext,
	company_name tinytext,
	company_info text,
	leadin text,
	description text,
	contact_name tinytext,
	contact_phone tinytext,
	contact_email tinytext,
	requirements text,
    must_requirements varchar(255) DEFAULT '' NOT NULL,

	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_sysjobs_requirements'
#
CREATE TABLE tx_sysjobs_requirements (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	title tinytext,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);
#
# Table structure for table 'tx_sysjobs_applicants'
#
CREATE TABLE tx_sysjobs_applicants (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	name tinytext,
	firstname tinytext,
	adress text,
	zip int(11) DEFAULT '0' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	contact_email tinytext,
	contact_phone_private tinytext,
	contact_phone_mobile tinytext,
	application text,
	job_uid int(11) DEFAULT '0' NOT NULL,
	requirements varchar(255) DEFAULT '' NOT NULL,
	comment text,

	PRIMARY KEY (uid),
	KEY parent (pid)
);
