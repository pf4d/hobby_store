SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `CSCI340-08` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `CSCI340-08` ;

-- -----------------------------------------------------
-- Table `CSCI340-08`.`CUSTOMER`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CSCI340-08`.`CUSTOMER` ;

CREATE  TABLE IF NOT EXISTS `CSCI340-08`.`CUSTOMER` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `lname` VARCHAR(45) NULL ,
  `fname` VARCHAR(45) NULL ,
  `st_address` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NULL ,
  `state` CHAR(2) NULL ,
  `zip` INT(5) NULL ,
  `phone` INT(10) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSCI340-08`.`ORDERS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CSCI340-08`.`ORDERS` ;

CREATE  TABLE IF NOT EXISTS `CSCI340-08`.`ORDERS` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `cust_id` INT NOT NULL ,
  `date` DATE NULL ,
  `cost` FLOAT NULL ,
  `shipping_cost` FLOAT NULL ,
  `num_shipments` TINYINT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_cust_num2` (`cust_id` ASC) ,
  UNIQUE INDEX `order_id_UNIQUE` (`id` ASC) ,
  CONSTRAINT `fk_cust_num2`
    FOREIGN KEY (`cust_id` )
    REFERENCES `CSCI340-08`.`CUSTOMER` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSCI340-08`.`PRODUCT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CSCI340-08`.`PRODUCT` ;

CREATE  TABLE IF NOT EXISTS `CSCI340-08`.`PRODUCT` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `brand` VARCHAR(45) NULL ,
  `description` VARCHAR(200) NULL ,
  `price` FLOAT NULL ,
  `weight` FLOAT NULL ,
  `stock_quantity` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSCI340-08`.`ADMIN`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CSCI340-08`.`ADMIN` ;

CREATE  TABLE IF NOT EXISTS `CSCI340-08`.`ADMIN` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `lname` VARCHAR(45) NULL ,
  `fname` VARCHAR(45) NULL ,
  `st_address` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NULL ,
  `state` CHAR(2) NULL ,
  `zip` INT(5) NULL ,
  `phone` INT(10) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `admin_id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSCI340-08`.`PAYCHECK`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CSCI340-08`.`PAYCHECK` ;

CREATE  TABLE IF NOT EXISTS `CSCI340-08`.`PAYCHECK` (
  `id` INT NOT NULL ,
  `admin_id` INT NOT NULL ,
  `date` DATE NULL ,
  `amount` FLOAT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `paycheck_id_UNIQUE` (`id` ASC) ,
  INDEX `fk_admin_id` (`admin_id` ASC) ,
  CONSTRAINT `fk_admin_id`
    FOREIGN KEY (`admin_id` )
    REFERENCES `CSCI340-08`.`ADMIN` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSCI340-08`.`CREDIT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CSCI340-08`.`CREDIT` ;

CREATE  TABLE IF NOT EXISTS `CSCI340-08`.`CREDIT` (
  `card_num` CHAR(16) NOT NULL ,
  `cust_id` INT NOT NULL ,
  `expiration` DATE NULL ,
  `lname` VARCHAR(45) NULL ,
  `fname` VARCHAR(45) NULL ,
  `st_address` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NULL ,
  `state` CHAR(2) NULL ,
  `zip` INT(5) NULL ,
  `phone` INT(10) NULL ,
  PRIMARY KEY (`card_num`) ,
  INDEX `fk_cust_num` (`cust_id` ASC) ,
  UNIQUE INDEX `card_num_UNIQUE` (`card_num` ASC) ,
  CONSTRAINT `fk_cust_num`
    FOREIGN KEY (`cust_id` )
    REFERENCES `CSCI340-08`.`CUSTOMER` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSCI340-08`.`SHIPMENT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CSCI340-08`.`SHIPMENT` ;

CREATE  TABLE IF NOT EXISTS `CSCI340-08`.`SHIPMENT` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `order_id` INT NOT NULL ,
  `tracking_num` VARCHAR(45) NULL ,
  `weight` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_order_num` (`order_id` ASC) ,
  CONSTRAINT `fk_order_num`
    FOREIGN KEY (`order_id` )
    REFERENCES `CSCI340-08`.`ORDERS` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSCI340-08`.`SHIP_PROD`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CSCI340-08`.`SHIP_PROD` ;

CREATE  TABLE IF NOT EXISTS `CSCI340-08`.`SHIP_PROD` (
  `ship_id` INT NOT NULL ,
  `product_id` INT NOT NULL ,
  `quantity` INT NOT NULL ,
  INDEX `fk_ship_num` (`ship_id` ASC) ,
  INDEX `fk_prod_num` (`product_id` ASC) ,
  PRIMARY KEY (`ship_id`, `product_id`) ,
  CONSTRAINT `fk_ship_num`
    FOREIGN KEY (`ship_id` )
    REFERENCES `CSCI340-08`.`SHIPMENT` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_prod_num`
    FOREIGN KEY (`product_id` )
    REFERENCES `CSCI340-08`.`PRODUCT` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSCI340-08`.`CART`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CSCI340-08`.`CART` ;

CREATE  TABLE IF NOT EXISTS `CSCI340-08`.`CART` (
  `cust_id` INT NOT NULL ,
  `cost` FLOAT NOT NULL ,
  INDEX `fk_cust_num3` (`cust_id` ASC) ,
  PRIMARY KEY (`cust_id`) ,
  CONSTRAINT `fk_cust_num3`
    FOREIGN KEY (`cust_id` )
    REFERENCES `CSCI340-08`.`CUSTOMER` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CSCI340-08`.`CART_PROD`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CSCI340-08`.`CART_PROD` ;

CREATE  TABLE IF NOT EXISTS `CSCI340-08`.`CART_PROD` (
  `cart_id` INT NOT NULL ,
  `product_id` INT NOT NULL ,
  `quantity` INT NOT NULL ,
  PRIMARY KEY (`cart_id`, `product_id`) ,
  INDEX `fk_prod_num2` (`product_id` ASC) ,
  INDEX `fk_cart_num` (`cart_id` ASC) ,
  CONSTRAINT `fk_prod_num2`
    FOREIGN KEY (`product_id` )
    REFERENCES `CSCI340-08`.`PRODUCT` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cart_num`
    FOREIGN KEY (`cart_id` )
    REFERENCES `CSCI340-08`.`CART` (`cust_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;



-- 3.) SQL statments used in project ------------------------------------------

--       INSERT Statements : --------------------------------------------------
INSERT 
  INTO CUSTOMER (user, password, lname, fname, st_address, city, state, zip, phone)
  VALUES ('engage', 'makeitso', 'Picard', 'Jean-Luc', '1 Universe Dr.', 
          'Chateau', 'LA', 89714, 1234567891);

INSERT 
  INTO CUSTOMER (user, password, lname, fname, st_address, city, state, zip, phone)
  VALUES ('yessir', 'aye', 'Riker', 'Will', '2 Galaxy Rd.', 'Boise', 
          'ID', 12487, 5554441234);

INSERT 
  INTO ADMIN (user, password, lname, fname, st_address, city, state, zip, phone)
  VALUES ('telepath', 'ifeelsomething', 'Troy', 'Diana', '3 Beta Ln.', 
          'Betazed', 'MA', 88888, 9998885555);

INSERT
  INTO PAYCHECK
  VALUES (111, 1, '2012-02-25', 20.00);

INSERT
  INTO CREDIT
  VALUES (1, '1111222233334444', '2013-12-12', 'Jean-Luc', 'Picard', 
          '1 Universe', 'Chateau', 'LA', 89714, 1234567891);

INSERT
  INTO CREDIT
  VALUES (2, '5555666677778888', '2014-01-01', 'Riker', 'Will', 
          '2 Galaxy', 'Boise', 'ID', 12487, 5554441234);

INSERT
  INTO ORDERS (cust_id, date, cost, shipping_cost, num_shipments)
  VALUES (1, '2009-05-02', 216.94, 12.99, 2);

INSERT
  INTO ORDERS (cust_id, date, cost, shipping_cost, num_shipments)
  VALUES (2, '2003-07-22', 151.95, 3.98, 1);

INSERT
  INTO PRODUCT
  VALUES (1, 'Supermarine Spitfire MK.IXc', 'Tamiya', 
'This is the 1/32 Scale Supermarine Spitfire MK.IXc Plastic Model Kit from Tamiya. Suitable for Ages 10 & Up.', 
        114.99, 2.0, 8);

INSERT
  INTO PRODUCT
  VALUES (2, '1/24 Nissan Skyline 2000 GT-R', 'Tamiya', 
'This is a 1/24 Plastic Nissan Skyline 2000 GT-R Hard Top from Tamiya.  For ages 10 and up.',
        25.99, 1.0, 2);

INSERT
  INTO PRODUCT
  VALUES (3, 'M4A3E8 Thunderbolt VII', 'Dragon',
'This is an M4A3E8 "Thunderbolt VII" Plastic Model Kit by Dragon® Suitable for Ages 10 & Older.', 
        39.99, 1.5, 4);

INSERT
  INTO PRODUCT
  VALUES (4, 'Flakpanzer IV Wirbelwind', 'Dragon', 
'This is the 1/35 Scale Flakpanzer IV Ausf. G "Wirbelwind" Early Production Plastic Model Kit from the \'39 - \'45 Series by Dragon.  Suitable for Ages 14 & Up.',
        45.99, 1.5, 1);

INSERT
  INTO PRODUCT
  VALUES (5, 'Star Trek U.S.S. Enterprise NCC-1701-A', 'Polar Lights', 
'This is the 1/350 Scale Star Trek® USS Enterprise NCC-1701-A Plastic Model Kit from Polar Lights®.  Suitable for Ages 10 & Older.',
        74.99, 4.0, 4);

INSERT
  INTO PRODUCT
  VALUES (6, '1/48 B-24D Liberator', 'Revell', 
'This is the 1/48 Scale B-24D Liberator Plastic Model Kit from Revell®. Suitable for Ages 10 & Older.',
        31.99, 2.0, 2);

INSERT
  INTO PRODUCT
  VALUES (7, '1/96 U.S.S. Constitution', 'Revell', 
'Assemble the U.S.S. Constitution "Old Ironsides" with this 1:96 Scale plastic model kit from Revell. Skill level 3 suitable for ages 12 and older.',
        75.99, 8.3, 1);

INSERT
  INTO PRODUCT
  VALUES (8, '1/35 Russian BMP-3 MICV', 'Trumpeter', 'This model\'s awesome', 
          35.99, 5.2, 7);
  
INSERT
  INTO PRODUCT
  VALUES (9, 'SLO-ZAP CA Glue', 'ZAP',
'This is a 1oz Bottle of Slo-Zap CA Glue from Pacer.  Not safe for foam. For foam applications use epoxy or foam-safe CA.',
        7.99, 0.2, 28);

INSERT
  INTO PRODUCT
  VALUES (10, 'X-Acto #1 Knife w/5 #11 Blades', 'X-Acto',
'This is the No.1 Precision Knife with 5 Replaceable #11 Blades from X-Acto.',
         5.99, 0.2, 87);

INSERT
  INTO PRODUCT
  VALUES (11, '4-Piece Tweezer Set w/Pouch', 'Excel', 
'This is a Four Piece Tweezer Set with Pouch from Excel.',
         16.99, 0.8, 200);

INSERT
  INTO SHIPMENT (order_id, tracking_num, weight)
  VALUES (1, '1111487AZT4484', 4.1);

INSERT
  INTO SHIPMENT (order_id, tracking_num, weight)
  VALUES (1, 'AKJIRU165487897', 2.0);

INSERT
  INTO SHIPMENT (order_id, tracking_num, weight)
  VALUES (2, 'SALKK5465654ASF654', 6.6);

INSERT
  INTO SHIP_PROD
  VALUES (1, 9, 3);

INSERT
  INTO SHIP_PROD
  VALUES (1, 1, 1);

INSERT
  INTO SHIP_PROD
  VALUES (1, 4, 1);

INSERT
  INTO SHIP_PROD
  VALUES (2, 6, 1);

INSERT
  INTO SHIP_PROD
  VALUES (3, 5, 1);

INSERT
  INTO SHIP_PROD
  VALUES (3, 2, 1);

INSERT
  INTO SHIP_PROD
  VALUES (3, 11, 2);

INSERT
  INTO CART
  VALUES (1, 20.98);

INSERT
  INTO CART_PROD
  VALUES (1, 1, 5);

INSERT
  INTO CART_PROD
  VALUES (1, 3, 2);

INSERT
  INTO CART_PROD
  VALUES (1, 8, 1);


