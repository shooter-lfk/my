-- 应用表
create table if not exists jms_cms_app(
	id			tinyint unsigned not null auto_increment,
	name		varchar(32) not null,
	title		varchar(16) character set utf8 not null,
	info		varchar(255) character set utf8 not null,
	
	primary key(id),
	unique key(name)
)engine=MyISAM;

-- 字段配置表
create table if not exists jms_cms_fieldc(
	id		smallint unsigned not null auto_increment,
	name		varchar(255) character set utf8 not null,
	dtable		varchar(100) not null default '',
	info		varchar(255) character set utf8 not null default '',
	primary key (id)
)engine=MyISAM;

-- 字段表
create table if not exists jms_cms_fields(
	id			int unsigned not null auto_increment,
	fieldc		smallint unsigned not null,
	
	field		varchar(32) not null,
	sort		tinyint not null default 0,
	title		varchar(8) character set utf8 not null,

	dataType	enum('string', 'int', 'float', 'date', 'time', 'datetime', 'timestamp') not null default 'string',
	inputType	enum('text', 'textarea', 'ckeditor', 'radio', 'checkbox', 'select', 'resource', 'date', 'color', 'datalink', 'password')  not null default 'text',
	
	info		varchar(255) character set utf8 not null default '',
	
	primary key(id),
	unique  key(fieldc, field)
)engine=MyISAM;

--结点表
create table if not exists jms_cms_node(
	id		smallint unsigned not null auto_increment,
	parent		smallint unsigned,
	fieldc		smallint unsigned,
	appId		tinyint unsigned,

	name		varchar(32),
	title		varchar(32) character set utf8 not null default '',
	sort		tinyint not null default 0,
	
	publishType		tinyint(1) not null default 0,
	listCache		smallint unsigned not null default 0,
	contentCache	smallint unsigned not null default 0,
	baseUrl			varchar(64) not null default '',
	listTpl			varchar(255) not null default '',
	contentTpl		varchar(255) not null default '',

	primary key(id),
	unique key(appId, name)
)engine=MyISAM;

-- 用户表
create table jms_members(
	uid			int unsigned not null auto_increment,
	parentId	int comment '会员从属关系',
	username	varchar(16) not null,
	password	char(32) not null,
	
	sex			enum('男', '女', '保密') character set utf8 not null default '保密',
	nickname	varchar(16) character set utf8 not null,
	name		varchar(16) character set utf8 not null default '' comment '用户真实姓名',
	
	regIP		int not null,
	regTime		int not null,
	updateTime	timestamp not null default '0000-00-00 00:00:00' on update current_timestamp,
	
	province	varchar(16) character set utf8 not null default '',
	city		varchar(16) character set utf8 not null default '',
	address		varchar(64) character set utf8 not null default '',
	
	qq			varchar(32) not null default '',
	msn			varchar(32) not null default '',
	mobile		varchar(32) not null default '',
	email		varchar(32) not null default '',
	idCard		varchar(18) not null default '' comment '身份证号码',
	
	coin		float not null default 0 comment '个人财产',
	safepwd		char(32) not null default '' comment '交易密码，请区别于登录密码',
	
	index(parentId),
	index(name),
	primary key(uid)
)engine=MyISAM;


-- 彩票
create table ssc_played(
	id			int not null auto_increment,
	name		varchar(16) character set utf8 not null comment '玩法名称',
	type		tinyint not null comment '彩票种类，参见ssc_type.type',
	selectNum	tinyint not null comment '每注选几个号码',
	
	groupId		smallint not null comment '玩法组',
	info		varchar(255) character set utf8 not null default '' comment '玩法说明',
	example		varchar(255) character set utf8 not null default '' comment '中奖举例',
	
	ruleFun		varchar(32) not null default '' comment '中奖规则函数',
	bonusProp	float not null default 1 comment '奖金比例，如果是1:5.5，则这个值为5.5',
	
	primary key(id)
	
)engine=MyISAM comment '玩法表';

create table ssc_played_group(
	id			smallint not null auto_increment,
	type		tinyint not null comment 'ssc_type.type',
	groupName	varchar(32) character set utf8 not null,
	
	primary key(id)
)engine=MyISAM comment '玩法组表';

create table ssc_played_fandian(
	id			int not null auto_increment,
	type		tinyint not null,
	playedId	int not null,
	value		float not null,
	
	primary key(id),
	unique key(type, playedId)
)engine=MyISAM comment '返点设置表';

create table ssc_bets(
	id			int not null auto_increment,
	
	orderId		int not null comment '定单号，由前台生成',
	serializeId	char(13) not null comment '投注号，由后台生成',
	
	uid			int not null comment '投注用户ID',
	type		tinyint not null comment '投注种类，对应ssc_type.id',
	playedGroup	smallint not null comment '玩法组ID',
	playedId	int not null comment '玩法ID',
	
	actionNo	varchar(32) not null comment '投注期号',
	actionTime	int not null comment '投注时间',
	actionIP	int not null comment '投注IP',
	actionNum	smallint unsigned not null comment '投注注数',
	actionData	varchar(32) not null comment '投注号码',
	
	rebate		float not null comment '返点',
	mode		int not null comment '模式，可以是2，20，200，分别代表元角分基数',
	beiShu		int not null comment '倍数',
	
	qzEnable	tinyint(1) not null default 1 comment '庄内庄，是否可以抢庄',
	zhuiHao		tinyint(1) not null default 0 comment '是否为追号',
	
	
	bonusProp	float not null comment '奖金比例，中奖以这个为据',
	
	isLottery	tinyint(1) not null default 0 comment '是否已经开奖',
	isDelete	tinyint(1) not null default 0 comment '是否已经取消购买，一般在开奖之前都可以取消购买',
	
	bonus		float not null default 0 comment '中奖金额',
	lotteryTime	int not null default 0 comment '官方开奖时间',
	bonusTime	int not null default 0 comment '奖金到帐号时间',
	
	primary key(id),
	index(isLottery),
	index(uid),
	index(type),
	index(orderId),
	index(actionTime)
)engine=MyISAM comment '投注表';

create table ssc_pl(
	id			int not null auto_increment,
	type		tinyint not null comment '投注种类，对应ssc_type.id',
	playedId	int not null comment '玩法ID',
	
	value		float not null comment '赔率值',
	
	primary key(id)
)engine=MyISAM comment '赔率表';

create table ssc_params(
	id			int not null auto_increment,
	name		varchar(255) not null,
	title		varchar(255) character set utf8 not null default '',
	value		varchar(255) character set utf8 not null default '',
	
	primary key(id),
	index(name)
)engine=MyISAM comment '系统配置表';

create table ssc_data_time(
	id			int not null auto_increment,
	type		tinyint not null comment '投注种类，对应ssc_type.id',
	actionNo	tinyint unsigned not null comment '开奖期号(当天)',
	actionTime	time not null comment '开奖时间',
	
	primary key(id),
	index(type)
)engine=MyISAM comment '开奖时间对照表';

create table ssc_log(
	id			int not null auto_increment,
	
	uid			int not null comment '用户ID',
	type		tinyint not null default 0 comment '彩种类，对应ssc_type.id，如果与彩票无关，这采用默认值(比如充值)',
	
	coin		float not null comment '流动前帐户可用资金(不包括冻结资金)',
	liquidity	float not null comment '流动资金，消费的用负值，充值的用正',
	liqType		tinyint unsigned not null comment '1充值，2返点，3提现失败从冻结资金返回，... ，101提现，102投注...',
	
	actionTime	int not null,
	actionIP	int not null default 0 comment '由系统生成或管理员操作的采用默认值',
	
	primary key(id),
	index(uid),
	index(type),
	index(liqType)
)engine=MyISAM comment '用户资金流动日志表';

create table ssc_admin_log(
	id			int not null auto_increment,
	uid			int not null,
	username	varchar(32) not null,
	
	actionTime	int not null,
	action		varchar(21000) character set utf8 not null default '' comment '操作描述',
	
	primary key(id),
	index(actionTime)
)engine=MyISAM comment '管理员操作日志'