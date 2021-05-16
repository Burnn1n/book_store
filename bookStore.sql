create schema bookStore;
create table book(
	book_id int primary key auto_increment,
    book_name varchar(255),
    book_online_price int(7),
    book_price int(7),
    book_author varchar(255),
    book_quantity int(3),
    book_about varchar(255),
    book_pages int(5),
    book_image mediumblob null,
    book_category int,
    book_home int null,
    created_at timestamp default current_timestamp,
    updated_at timestamp null,
    foreign key (book_category) references category(category_id),
    foreign key (book_home) references home(home_id)
);
ALTER TABLE book
ADD COLUMN book_rent_price int(7);
ALTER TABLE book
ADD COLUMN book_file_name varchar(255) null;
ALTER TABLE book
ADD COLUMN downloads int default 0;

ALTER TABLE book
ADD COLUMN book_rent_price int(7);
select * from book;
update book set book_rent_price = 5000 where book_id=6;

create table category(
	category_id int primary key auto_increment,
    category_name varchar(50)
);
create table home(
	home_id int primary key auto_increment,
    home_name varchar(50)
);
insert into category(category_name) values('Анагаах ухаан'),('Бизнес эдийн засаг'),('Шинжлэх ухаан'),('Уран зохиол'),('Гүн ухаан'),('Түүх'),
('Хууль'),('Танин мэдэхүй'),('Намтар'),('Хэл, Толь бичиг');
insert into category(category_name) values('Хүүхдийн');
select * from category;
insert into home(home_name) values('Шинэ'),('Bestseller');
insert into book(book_name,book_online_price,book_price,book_author,book_quantity,book_about,book_pages,book_category,book_home,updated_at)
values('Бид хэзээ амьдарч эхэлдэг вэ','25000','40000','Өрнөх','50','Барууны философичийн санаа оноог сонирхоно уу','654',5,1,null);
select * from book;
insert into book(book_name,book_online_price,book_price,book_author,book_quantity,book_about,book_pages,book_category,book_home,updated_at)
values('Хүний гарал үүсэл',null,'20000','Бат','20','Баримтат шинжлэх ухааны түүхэн ном','150',6,1,null);
insert into book(book_name,book_online_price,book_price,book_author,book_quantity,book_about,book_pages,book_category,book_home,updated_at)
values('Төмөр нүүрт хууль',null,'32000','Дорж','120','На','350',7,1,null);
insert into book(book_name,book_online_price,book_price,book_author,book_quantity,book_about,book_pages,book_category,book_home,updated_at)
values('Ангаахай',null,'12000','Бадмаанаа','30','На','50',11,1,null);
insert into book(book_name,book_online_price,book_price,book_author,book_quantity,book_about,book_pages,book_category,book_home,updated_at)
values('My love',null,'12000','James','30','На','50',11,1,null);
insert into book(book_name,book_online_price,book_price,book_author,book_quantity,book_about,book_pages,book_category,book_home,updated_at)
values('Хүххд',null,'12000','James','30','На','50',11,1,null);
insert into book(book_name,book_online_price,book_price,book_author,book_quantity,book_about,book_pages,book_category,book_home,updated_at)
values('Чоно туулай',null,'12000','James','30','На','50',11,1,null);
insert into book(book_name,book_online_price,book_price,book_author,book_quantity,book_about,book_pages,book_category,book_home,updated_at)
values('Хулгана',null,'12000','James','30','На','50',11,1,null);
update book
set book_about = 'ene bol geralt domogt mangasiin anguuchiin shidten yennefertei tsug adal ywdal ba elder blood ciri - g wild hunt-s awrah uil ywdal'
where book_id=4;
create table orders(
	order_id int primary key auto_increment,
    order_book_id int,
    order_user_id int,
    order_tuluw_id int,
    order_tulbur tinyint(1),
    created_at timestamp default current_timestamp,
    updated_at timestamp null,
    foreign key (order_book_id) references book(book_id),
    foreign key (order_user_id) references users(id),
    foreign key (order_tuluw_id) references tuluw(id)
);
ALTER TABLE orders
ALTER order_tulbur SET DEFAULT 0;
insert into orders(order_book_id,order_user_id,order_tuluw_id,order_tulbur)values(6,5,1,0);
insert into orders(order_book_id,order_user_id,order_tuluw_id,order_tulbur)values(1,5,4,0);
insert into orders(order_book_id,order_user_id,order_tuluw_id,order_tulbur)values(2,5,2,1);
select * from orders;
create table rent(
	rent_id int primary key auto_increment,
    rent_book_id int,
    rent_user_id int,
    rent_tuluw_id int,
    rent_tulbur tinyint(1),
    created_at timestamp default current_timestamp,
    started_at timestamp null,
    deadline_at timestamp null,
    foreign key (rent_book_id) references book(book_id),
    foreign key (rent_user_id) references users(id),
    foreign key (rent_tuluw_id) references tuluw(id)
);
select * from rent;
update rent set deadline_at = '2021-05-04T22:01';
select started_at from rent where rent_id=1;
create table rent_tuluw(
	id int primary key auto_increment,
    tuluw_name varchar(50)
);

insert into rent_tuluw(rent_tuluw) values('Захиалагдсан');
select * from orders;
select * from tuluw;
create table tuluw(
	id int primary key auto_increment,
    tuluw_name varchar(50)
);
insert into tuluw(tuluw_name) values('Захиалагдсан'),('Хэрэглэгч хүлээн авсан');
insert into tuluw(tuluw_name) values('Захиалга баталгаажсан');
insert into tuluw(tuluw_name) values('Цуцлагдсан');
insert into tuluw(tuluw_name) values('Түрээсийн цаг хэтэрсэн'),('Түрээсийн цаг сунгагдсан'),('Хаагдсан');
select * from tuluw;
create table users(
	id int primary key auto_increment,
    user_name varchar(255),
    user_email varchar(255),
    user_phone varchar(8),
    user_password varchar(255),
    user_address varchar(255),
    user_type_id int,
    user_wallet int(10),
    foreign key(user_type_id) references user_type(id)
);
insert into users(user_name,user_email,user_phone,user_password,user_address,user_type_id,user_wallet)
values('Bat','bat@gmail.com','99999999','12345678','Ub,BZD,25,74b-33',3,1000000),
	  ('Dorj','dorj@gmail.com','88888888','qwertyui','Hentii,BU,2,51-16',3,200000),
      ('Khan','khan@gmail.com','77777777','12345678','UB',1,0),
      ('Tsetseg','tsetseg@gmail.com','21534','12345678','UB',2,0);
select * from users;
ALTER TABLE users
ADD COLUMN created_at timestamp default current_timestamp;
create table user_type(
	id int auto_increment primary key,
    user_type_name varchar(50)
);
insert into user_type(user_type_name) values('Админ'),('Худалдагч'),('Үйлчлүүлэгч');
create table file_management(
	id int primary key auto_increment,
	file_name VARCHAR(255) ,
	size INT,
	downloads int
);
select * from file_management;
SELECT * FROM orders;

UPDATE rent SET rent_tuluw_id = if(deadline_at < now() ,5, rent_tuluw_id);
SET @deadlinedUser := SELECT rent_user_id from rent where rent_tuluw_id = 5;
select * from users;
UPDATE users SET user_wallet=user_wallet - 5000 where id=1;

SELECT * FROM rent;
create table qa(
	qa_id int primary key auto_increment,
    qa_text varchar(255),
    qa_user int,
    foreign key(qa_user) references users(id)
);
select * from qa;