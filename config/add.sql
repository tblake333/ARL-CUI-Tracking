CREATE TABLE `test`.`cui_items` ( 
    `id` INT NOT NULL AUTO_INCREMENT , 
    `barcode` VARCHAR(10) NOT NULL , 
    `title` VARCHAR(30) NOT NULL , 
    `type` VARCHAR(30) NOT NULL , 
    `source` VARCHAR(30) NULL DEFAULT NULL , 
    `source_date` DATE NULL DEFAULT NULL , 
    `entry_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `location` VARCHAR(30) NOT NULL , 
    `description` VARCHAR(250) NULL DEFAULT NULL , 
    `checked_out` BOOLEAN NOT NULL DEFAULT FALSE , 
    PRIMARY KEY (`id`), 
    UNIQUE `idx_barcode` (`barcode`) 
    USING HASH) ENGINE = InnoDB; 