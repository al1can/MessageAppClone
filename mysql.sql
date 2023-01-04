create table users (
    id int(6) not null primary key auto_increment,
    username varchar(30) not null unique,
    password varchar(255) not null,
    email varchar(255) not null,
    create_date datetime default current_timestamp);
    
create table posts (
    pid int(6) not null primary key auto_increment,
    uid int(6) not null unique,
    post varchar(255) not null,
    create_date datetime default current_timestamp);
