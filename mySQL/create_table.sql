DROP TABLE IF EXISTS billing;
CREATE TABLE IF NOT EXISTS billing
(
    id                     TINYINT      UNSIGNED NOT NULL AUTO_INCREMENT,
    first_name             CHAR(50)              NOT NULL,
    last_name              CHAR(50)              NOT NULL,
    country                CHAR(50)              NOT NULL,
    street_add             CHAR(100)             NOT NULL,
    unit                   CHAR(50)              NOT NULL,
    postal                 CHAR(20)              NOT NULL,
    city                   CHAR(20)              NOT NULL,
    email_add              CHAR(50)              NOT NULL,
    Discount               CHAR(50)              NOT NULL, 
    PRIMARY KEY (id)
);


DROP TABLE IF EXISTS paymentMethod;
CREATE TABLE IF NOT EXISTS paymentMethod
(
    id                     TINYINT      UNSIGNED NOT NULL AUTO_INCREMENT,
    user                   CHAR(50)              NOT NULL,
    commentbox             CHAR(255)             NOT NULL,
    mobileNum              CHAR(8)               NOT NULL,
    cardNum                CHAR(50)              NOT NULL,
    exp                    CHAR(20)              NOT NULL,
    ccv                    CHAR(3)               NOT NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS order_table;
CREATE TABLE IF NOT EXISTS order_table
(
    id                     TINYINT          UNSIGNED NOT NULL AUTO_INCREMENT,
    colour                 CHAR(50)                  NOT NULL,
    size                   CHAR(50)                  NOT NULL, 
    quantity               SMALLINT(5)      UNSIGNED NOT NULL,
    cream_subtotal         DECIMAL(9,2)     UNSIGNED NOT NULL,
    pink_subtotal          DECIMAL(9,2)     UNSIGNED NOT NULL,
    purple_subtotal        DECIMAL(9,2)     UNSIGNED NOT NULL,
    total_cost             DECIMAL(9,2)     UNSIGNED NOT NULL,
    PRIMARY KEY (id)
);