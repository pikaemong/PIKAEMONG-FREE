create table board_free (

b_no int unsigned not null primary key auto_increment,

b_title varchar(100) not null,

b_content text not null,

b_date datetime not null,

b_hit int unsigned not null default 0,

b_id varchar(20) not null,

b_password varchar(100) not null

);