CREATE DATABASE deezer_catalog;
USE deezer_catalog;

CREATE USER 'deezer'@'localhost' IDENTIFIED BY 'deezer';

GRANT ALL PRIVILEGES ON * . * TO 'deezer'@'localhost';


 drop table deal_date;
 drop table deal_usage;
 drop table deal;
 drop table soundtrack;
 drop table album;



CREATE TABLE IF NOT EXISTS album
(
    icpn BIGINT NOT NULL,
    grid VARCHAR(20) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    artist VARCHAR(100) NOT NULL,
    title VARCHAR(400) NOT NULL,
    label VARCHAR(400) NOT NULL,
    date_insert DATE NOT NULL,
    date_update DATE ,
    PRIMARY KEY (icpn)
 );


CREATE TABLE IF NOT EXISTS soundtrack
(
    iscr VARCHAR(20) NOT NULL,
    icpn_album BIGINT NOT NULL,
    artist VARCHAR(100) NOT NULL,
    title VARCHAR(400) NOT NULL,
    duration VARCHAR(12) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    label VARCHAR(100) NOT NULL,
    date_insert DATE NOT NULL,
    date_update DATE ,
    PRIMARY KEY (iscr),
    CONSTRAINT fk_soundtrack_album FOREIGN KEY (icpn_album) REFERENCES album (icpn)
);

CREATE TABLE IF NOT EXISTS deal
(
    id BIGINT NOT NULL auto_increment,
    model VARCHAR(100) NOT NULL,
    icpn_album BIGINT,
    iscr_soundtrack VARCHAR(20),
    country VARCHAR(2) NOT NULL,
    enabled BOOLEAN NOT NULL DEFAULT '1',
    date_insert DATE NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_deal_album FOREIGN KEY (icpn_album) REFERENCES album(icpn),
    CONSTRAINT fk_deal_soundtrack FOREIGN KEY (iscr_soundtrack) REFERENCES soundtrack(iscr)
);



CREATE TABLE IF NOT EXISTS deal_usage
(
    id BIGINT NOT NULL auto_increment,
    deal_id BIGINT NOT NULL ,
    usage_deal VARCHAR(100) NOT NULL,
    date_insert DATE NOT NULL,
    PRIMARY KEY (id) ,
    CONSTRAINT fk_deal_usage_deal FOREIGN KEY (deal_id) REFERENCES deal(id)
);


CREATE TABLE IF NOT EXISTS deal_date
(
    id BIGINT NOT NULL auto_increment,
    deal_id BIGINT NOT NULL,
    type_date VARCHAR(100) NOT NULL,
    date_value DATE NOT NULL,
    date_insert DATE NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_deal_date_deal FOREIGN KEY (deal_id) REFERENCES deal(id)
);