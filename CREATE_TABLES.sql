CREATE TABLE IF NOT EXISTS covidciasie.users
(
    id int(11) NOT NULL AUTO_INCREMENT,
    lastname varchar(255) NOT NULL,
    firstname varchar(255) NOT NULL,
    contamined tinyint(1) NOT NULL DEFAULT '0',
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS covidciasie.locations
(
    id int(11) NOT NULL AUTO_INCREMENT,
    latitude float(9, 7) NOT NULL,
    longitude float(9, 7) NOT NULL,
    user_id int(11) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_location_id_user
        FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE IF NOT EXISTS covidciasie.`groups`
(
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS covidciasie.messages
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

CREATE TABLE IF NOT EXISTS covidciasie.groups_users
(
    group_id int(11) NOT NULL,
    user_id int(11) NOT NULL,
    PRIMARY KEY (group_id, user_id),
    CONSTRAINT fk_groups_users_id
        FOREIGN KEY (group_id) REFERENCES `groups` (id),
    CONSTRAINT fk_users_groups_id
        FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE IF NOT EXISTS covidciasie.contacts
(
    user1_id int(11) NOT NULL,
    user2_id int(11) NOT NULL,
    PRIMARY KEY (user1_id, user2_id),
    CONSTRAINT fk_users1_id_contacts
        FOREIGN KEY (user1_id) REFERENCES users (id),
    CONSTRAINT fk_users2_id_contacts
        FOREIGN KEY (user2_id) REFERENCES users (id)
);

CREATE TABLE IF NOT EXISTS covidciasie.files
(
    id int(11) NOT NULL,
    filename varchar(255) NOT NULL,
    group_id int(11) NOT NUlL,
    PRIMARY KEY (id),
    CONSTRAINT fk_file_id_group
        FOREIGN KEY (group_id) REFERENCES `groups` (id)
);

CREATE TABLE IF NOT EXISTS covidciasie.announcements
(
    id int(11) NOT NULL,
    group_id int(11) NOT NUlL,
    message varchar(255) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_announcement_id_group
        FOREIGN KEY (group_id) REFERENCES `groups` (id)
);

CREATE TABLE IF NOT EXISTS covidciasie.invitations
(
    id int(11) NOT NULL AUTO_INCREMENT,
    sender_id int(11) NOT NULL,
    receiver_id int(11) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_users1_id_invitations
        FOREIGN KEY (sender_id) REFERENCES users (id),
    CONSTRAINT fk_users2_id_invitations
        FOREIGN KEY (receiver_id) REFERENCES users (id)
);

COMMIT;