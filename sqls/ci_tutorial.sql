CREATE TABLE user_ci_tutorial (
    user_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    type enum('user','admin') NOT NULL DEFAULT 'user',
    email varchar(50) NOT NULL,
    password varchar(40) NOT NULL,
    date_added datetime NOT NULL,
    PRIMARY KEY (user_id),
    UNIQUE email (email)
);
INSERT INTO user_ci_tutorial (user_id, type, email, password, date_added) VALUES
(1, 'admin', 'admin@admin.com', 'f93b66c65ce6e535030991739c91675e5e8c0d3c', '0000-00-00 00:00:00'),
(2, 'user', 'test@test.com', '14ef34f2a60b3a0d42831029f5f4e2fa58b9a5d6', '0000-00-00 00:00:00'),
(3, 'user', 'j@j.com', '99033f52aaff9d8241a71c3a0ae37868bb6d8b24', '0000-00-00 00:00:00'),
(4, 'user', '1@1.com', '73f91f3c5c3536dfa4b8ed040f9f33678f4d9eb4', '0000-00-00 00:00:00');
