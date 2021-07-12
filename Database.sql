CREATE USER 'myuser'@'localhost' IDENTIFIED VIA mysql_native_password USING PASSWORD('mypass');

GRANT 
	ALL PRIVILEGES 
ON *.* TO 
	'myuser'@'localhost' REQUIRE 
NONE WITH GRANT OPTION 
	MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0; 

create database twitter_clone;

use twitter_clone;

create table usuarios(
	id int not null primary key AUTO_INCREMENT,
	nome varchar(100) not null,
	email varchar(150) not null,
	senha varchar(32) not null
);

create table tweets(
	id int not null PRIMARY KEY AUTO_INCREMENT,
	id_usuario int not null,
	tweet varchar(140) not null,
	data datetime default current_timestamp
);