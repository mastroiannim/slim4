CREATE USER 'user'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON *.* TO 'user'@'%';
CREATE DATABASE `database` COLLATE 'utf8_unicode_ci';