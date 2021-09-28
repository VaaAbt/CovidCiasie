DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users
(
    id int(11) NOT NULL AUTO_INCREMENT,
    lastname varchar(255) NOT NULL,
    firstname varchar(255) NOT NULL,
    age int(4),
    phone varchar(14),
    location varchar(255),
    contamined tinyint(1) NOT NULL DEFAULT '0',
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups`
(
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS messages;
CREATE TABLE IF NOT EXISTS messages
(
    id int(11) NOT NULL AUTO_INCREMENT,
    sender_id int(11) NOT NULL,
    receiver_id int(11),
    group_id int(11),
    message varchar(255) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_users1_id_messages
        FOREIGN KEY (sender_id) REFERENCES users (id),
    CONSTRAINT fk_users2_id_messages
        FOREIGN KEY (receiver_id) REFERENCES users (id),
    CONSTRAINT fk_groups_id_messages
        FOREIGN KEY (group_id) REFERENCES `groups` (id)
);


DROP TABLE IF EXISTS groups_users;
CREATE TABLE IF NOT EXISTS groups_users
(
    group_id int(11) NOT NULL,
    user_id int(11) NOT NULL,
    PRIMARY KEY (group_id, user_id),
    CONSTRAINT fk_groups_users_id
        FOREIGN KEY (group_id) REFERENCES `groups` (id),
    CONSTRAINT fk_users_groups_id
        FOREIGN KEY (user_id) REFERENCES users (id)
);


DROP TABLE IF EXISTS contacts;
CREATE TABLE IF NOT EXISTS contacts
(
    user1_id int(11) NOT NULL,
    user2_id int(11) NOT NULL,
    PRIMARY KEY (user1_id, user2_id),
    CONSTRAINT fk_users1_id_contacts
        FOREIGN KEY (user1_id) REFERENCES users (id),
    CONSTRAINT fk_users2_id_contacts
        FOREIGN KEY (user2_id) REFERENCES users (id)
);

COMMIT;