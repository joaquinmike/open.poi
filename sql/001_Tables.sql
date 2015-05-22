CREATE TABLE sessions (
    id char(32) NOT NULL DEFAULT '',
    name varchar(255) NOT NULL,
    modified int(11) DEFAULT NULL,
    lifetime int(11) DEFAULT NULL,
    data text,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  

CREATE TABLE `auth_usuario` (
  `us_id` int(11) NOT NULL AUTO_INCREMENT,
  `us_usuario` varchar(32) NOT NULL,
  `us_password` varchar(32) NOT NULL,
   us_email varchar(128) NULL,
   fecha_creacion DATETIME NULL,
   us_estado int(11) NULL DEFAULT 1,
  PRIMARY KEY (`us_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- users data with password = md5('admin')
INSERT INTO `auth_usuario` (`us_usuario`, `us_password`,us_email,fecha_creacion) VALUES
('admin', md5('tarazona'),'jmike410@gmail.com',now());

CREATE TABLE `auth_rol` (
  `rol_id` INT NOT NULL AUTO_INCREMENT,
  `rol_dec` VARCHAR(128) NULL,
  `rol_estado` INT(11) NULL,
  `rol_rol_id` INT NOT NULL,
  PRIMARY KEY (`rol_id`),
  INDEX `fk_auth_rol_auth_rol_idx` (`rol_rol_id` ASC),
  CONSTRAINT `fk_auth_rol_auth_rol`
    FOREIGN KEY (`rol_rol_id`)
    REFERENCES `auth_rol` (`rol_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `auth_recurso` (
  `rec_id` INT NOT NULL AUTO_INCREMENT,
  `rec_desc` VARCHAR(256) NULL,
  `rec_uri` VARCHAR(256) NULL,
  `rec_estado` INT(11) NULL,
  PRIMARY KEY (`rec_id`))
ENGINE = InnoDB;

CREATE TABLE `auth_rol_recurso` (
  `auth_rol_rol_id` INT NOT NULL,
  `auth_recurso_rec_id` INT NOT NULL,
  `rolrec_desc` VARCHAR(45) NULL COMMENT 'Si: allow\nNo: Deny',
  `rolrec_estado` VARCHAR(45) NULL,
  PRIMARY KEY (`auth_rol_rol_id`, `auth_recurso_rec_id`),
  INDEX `fk_auth_rol_has_auth_recurso_auth_recurso1_idx` (`auth_recurso_rec_id` ASC),
  INDEX `fk_auth_rol_has_auth_recurso_auth_rol1_idx` (`auth_rol_rol_id` ASC),
  CONSTRAINT `fk_auth_rol_has_auth_recurso_auth_rol1`
    FOREIGN KEY (`auth_rol_rol_id`)
    REFERENCES `auth_rol` (`rol_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_auth_rol_has_auth_recurso_auth_recurso1`
    FOREIGN KEY (`auth_recurso_rec_id`)
    REFERENCES `auth_recurso` (`rec_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
