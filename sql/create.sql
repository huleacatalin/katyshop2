

# Copyleft https://sourceforge.net/projects/katyshop2
# License GNU General Public License version 3 http://www.gnu.org/licenses/


create table address (
	id int(11) not null primary key auto_increment,
	id_user int(11) not null,
	delivery int(1) not null,
	invoicing int(1) not null,
	primary_addr int(1) not null,
	county varchar(255) not null default '',
	city varchar(255) not null default '',
	address text not null
);

create table admin (
	id_admin int(11) not null primary key,
	is_admin int(1) not null
);

create table category (
	id int(11) not null primary key auto_increment,
	id_parent int(11) not null,
	pos int(11) not null,
	nest_level int(11) not null,
	title varchar(255) not null default '',
	description text not null,
	picture varchar(255) not null default '',
	date_created datetime not null,
	active int(1) not null,
	constraint unique(id_parent, title)
);

create table orders (
	id int(11) not null primary key auto_increment,
	code varchar(25) not null default '',
	id_user int(11) not null,
	status varchar(20) not null default '',
	date_ordered datetime not null,
	date_updated datetime not null,
	total decimal(20, 2) not null,
	id_delivery_address int(11) not null,
	id_invoice_address int(11) not null,
	delivery_address text not null,
	invoice_address text not null,
	title varchar(255) not null default '',
	username varchar(255) not null default '',
	user_details text not null,
	user_short_description text not null
);

create table order_product (
	id_order int(11) not null,
	line_number int(11) not null,
	id_product int(11) not null,
	product_name varchar(255) not null default '',
	product_description text not null,
	price decimal(20, 2) not null,
	quantity decimal(20, 2) not null,
	measuring_unit varchar(255) not null default '',
	total decimal(20, 2) not null,
	constraint primary key(id_order, line_number)
);

create table product (
	id int(11) not null primary key auto_increment,
	id_category int(11) not null,
	id_manufacturer int(11) not null,
	pos int(11) not null,
	title varchar(255) not null default '',
	price decimal(20, 2) not null,
	description text not null,
	content longtext not null,
	picture varchar(255) not null default '',
	date_created datetime not null,
	active int(1) not null,
	measuring_unit varchar(20) not null default '',
	technical_details text not null,
	constraint unique(id_category, title)
);

create table product_image (
	id int(11) not null primary key auto_increment,
	id_product int(11) not null,
	pos int(11) not null,
	filename varchar(255) not null default '',
	constraint foreign key(id_product) references product(id)
);

create table user (
	id int(11) not null primary key auto_increment,
	username varchar(20) not null default '',
	password varchar(255) not null default '',
	email varchar(255) not null default '',
	email2 text not null,
	acc_type varchar(20) not null default '',
	active int(1) not null default '1',
	activation_code varchar(10) not null default '',
	login_code varchar(255) not null default '',
	constraint unique(username),
	constraint unique(email)
);

create table user_company (
	id int(11) not null primary key,
	company_name varchar(255) not null default '',
	tax_code varchar(255) not null default '',
	bank varchar(255) not null default '',
	iban varchar(255) not null default '',
	comp_phone varchar(255) not null default '',
	comp_fax varchar(255) not null default '',
	comp_email varchar(255) not null default ''
);

create table user_person (
	id int(11) not null primary key,
	first_name varchar(255) not null default '',
	last_name varchar(255) not null default '',
	gender varchar(255) not null default '',
	birth_date varchar(255) not null default '',
	phone varchar(255) not null default ''
);

create table manufacturer (
	id int(11) not null primary key auto_increment,
	title varchar(255) not null default '',
	description text not null,
	picture varchar(255) not null default '',
	constraint unique(title)
);

create table contact_message (
	id int(11) not null primary key auto_increment,
	id_user int(11) not null,
	user_details text not null,
	sender_name varchar(255) not null default '',
	sender_email varchar(255) not null default '',
	subject varchar(255) not null default '',
	message longtext not null,
	date_sent datetime not null
);
