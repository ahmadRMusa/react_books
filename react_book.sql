#drop database if exists react_book;

create database react_book;

use react_book;

create table customers
(
customer_id int unsigned not null auto_increment primary key,
fullname char(60) not null,
address char(80) not null,
city char(30) not null,
state char(20),
zip char(10),
country char(20) not null
);

create table orders
(
order_id int unsigned not null auto_increment primary key,
customer_id int unsigned not null references customers(customer_id),
amouint float(6,2),
order_date date not null,
order_status char(10),
ship_name char(80) not null,
ship_address char(80) not null,
ship_city char(80) not null,
ship_state char(80),
ship_zip char(80),
ship_country char(80) not null
);

create table books
(
book_id int unsigned not null auto_increment primary key,
isbn char(80) unique not null,
author char(80),
title char(80),
catid int unsigned,
price float(4,2) not null,
description varchar(255)
);

create table categories
(
catid int unsigned not null auto_increment primary key,
catname char(80) not null
);

create table order_items
(
order_id int unsigned not null references orders(order_id),
isbn char(80) not null references books(isbn),
item_price float(4,2) not null,
quantity tinyint unsigned not null,
primary key (order_id, isbn)
);

create table admin
(
admin_id int unsigned not null auto_increment primary key,
username char(80) unique not null,
password char(80) not null
);

insert into categories (catname) values ('php');
insert into categories (catname) values ('java');
insert into categories (catname) values ('c++');

#select * from categories;

insert into books (isbn, author, title, catid, price, description) values ('12345','jie', 'program php', 1, 34.2, 'good book');
insert into books (isbn, author, title, catid, price, description) values ('11111','jie', 'program php ii', 1, 45.2, 'good book too');
insert into books (isbn, author, title, catid, price, description) values ('23456','lou', 'php patterns oo', 1, 44.2, 'good book');
insert into books (isbn, author, title, catid, price, description) values ('34567','sb', 'advanced php', 1, 45.2, 'good book');
insert into books (isbn, author, title, catid, price, description) values ('45678','vic', 'thinking in java', 2, 50.2, 'good book');
insert into books (isbn, author, title, catid, price, description) values ('56789','wemade', 'effective java', 2, 66.2, 'good book');
insert into books (isbn, author, title, catid, price, description) values ('67890','victory', 'c++ primer', 3, 10.2, 'good book');

select title, author,isbn from books where catid=3;

select * from books;







