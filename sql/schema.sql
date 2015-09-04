SET NAMES 'utf8';
SET CHARACTER SET 'utf8';
SET SESSION collation_connection = 'utf8_general_ci';

CREATE TABLE `article` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255),
    `overview` TEXT,
    `image` VARCHAR(255),
    `text` TEXT,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
