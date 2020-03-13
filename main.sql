CREATE DATABASE chatroom;

CREATE TABLE conversation(chat_id SERIAL PRIMARY KEY, sender VARCHAR(30) NOT NULL, receiver VARCHAR(30) NOT NULL, date DATE NOT NULL, time TIME WITH TIME ZONE NOT NULL, STATUS BOOLEAN NOT NULL, ip VARCHAR(30) NOT NULL);

CREATE TABLE reply(reply_id SERIAL PRIMARY KEY, chat_id SMALLINT, message TEXT NOT NULL, FOREIGN KEY(chat_id) REFERENCES conversation(chat_id));

ALTER SEQUENCE conversation_chat_id_seq RESTART WITH 10001;
ALTER SEQUENCE reply_reply_id_seq RESTART WITH 20001;
                                                                                                                                      
CREATE TABLE block(user1 VARCHAR(30), user2 VARCHAR(30));
CREATE TABLE chatroom_credentials(id1 tinyint(1), ID smallint(6) PRIMARY KEY, first_name VARCHAR(265) NOT NULL, last_name VARCHAR(256), email VARCHAR(256) NOT NULL, status tinyint(1), password VARCHAR(256), uname VARCHAR(30)); 
                                                                                                                          
