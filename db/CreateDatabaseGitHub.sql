drop table git_users;
drop table git_logbook;
drop table git_dispatch;
drop table git_session;

CREATE TABLE IF NOT EXISTS git_users (id INTEGER PRIMARY KEY AUTO_INCREMENT, username VARCHAR(20), userpassword VARCHAR(20), firstname VARCHAR(30), secondname VARCHAR(50), usertype VARCHAR(2), active BOOLEAN);
CREATE TABLE IF NOT EXISTS git_logbook (id INTEGER PRIMARY KEY AUTO_INCREMENT, userid INTEGER, logbookdate VARCHAR(20), arrivalHour VARCHAR(2), arrivalMinute VARCHAR(2), departureHour VARCHAR(2), departureMinute VARCHAR(2), activity VARCHAR(15));
CREATE TABLE IF NOT EXISTS git_dispatch (id INTEGER PRIMARY KEY AUTO_INCREMENT, dispatchid INTEGER, userid VARCHAR(20) );
CREATE TABLE IF NOT EXISTS git_session (id VARCHAR(33) PRIMARY KEY, dispatchid INTEGER, active BOOLEAN );
