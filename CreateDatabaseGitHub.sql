drop table users;
drop table logbook;
drop table dispatch;

CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTO_INCREMENT, username VARCHAR(), password VARCHAR(20), type VARCHAR(2));
CREATE TABLE IF NOT EXISTS logbook (id INTEGER PRIMARY KEY AUTO_INCREMENT, userid INTEGER, date VARCHAR(20), arrivalHour VARCHAR(2), arrivalMinute VARCHAR(2), departureHour VARCHAR(2), departureMinute VARCHAR(2), activity VARCHAR(15));
CREATE TABLE IF NOT EXISTS dispatch (id INTEGER PRIMARY KEY AUTO_INCREMENT, dispatchid INTEGER, userid VARCHAR(20) );
