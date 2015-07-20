CREATE TABLE sessions (
    id char(32) NOT NULL DEFAULT '',
    name varchar(255) NOT NULL,
    modified int(11) DEFAULT NULL,
    lifetime int(11) DEFAULT NULL,
    data text,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
CREATE TABLE `auth_rol` (
  `rol_id` INT NOT NULL AUTO_INCREMENT,
  `rol_dec` VARCHAR(128) NULL,
  `rol_estado` INT NULL DEFAULT 1 COMMENT '0: Inactivo\n1:activo',
  `rol_rol_id` INT NULL,
  PRIMARY KEY (`rol_id`),
  INDEX `fk_auth_rol_auth_rol_idx` (`rol_rol_id` ASC),
  CONSTRAINT `fk_auth_rol_auth_rol`
    FOREIGN KEY (`rol_rol_id`)
    REFERENCES `auth_rol` (`rol_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE `auth_usuario` (
  `us_id` INT NOT NULL AUTO_INCREMENT,
  `us_usuario` VARCHAR(32) NULL,
  `us_password` VARCHAR(256) NULL,
  `us_email` VARCHAR(256) NULL,
  `us_nombre` VARCHAR(64) NULL,
  `us_estado` INT NULL DEFAULT 1,
  `fecha_creacion` DATETIME NULL,
  `rol_id` INT NOT NULL,
  PRIMARY KEY (`us_id`),
  INDEX `fk_auth_usuario_auth_rol1_idx` (`rol_id` ASC),
  CONSTRAINT `fk_auth_usuario_auth_rol1`
    FOREIGN KEY (`rol_id`)
    REFERENCES `auth_rol` (`rol_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE `auth_recurso` (
  `rec_id` INT NOT NULL AUTO_INCREMENT,
  `rec_desc` VARCHAR(256) NULL,
  `rec_uri` VARCHAR(256) NULL,
  `rec_tipo` INT NULL COMMENT '1: Menu\n2: Recurso',
  `rec_estado` INT(11) NULL,
  `rec_css` VARCHAR(32) NULL,
  `rec_orden` INT NULL,
  `rec_rec_id` INT NULL,
  PRIMARY KEY (`rec_id`),
  INDEX `fk_auth_recurso_auth_recurso1_idx` (`rec_rec_id` ASC),
  CONSTRAINT `fk_auth_recurso_auth_recurso1`
    FOREIGN KEY (`rec_rec_id`)
    REFERENCES `auth_recurso` (`rec_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE `auth_rol_recurso` (
  `rol_id` INT NOT NULL,
  `rec_id` INT NOT NULL,
  `rolrec_permiso` VARCHAR(16) NULL COMMENT 'Si: allow\nNo: Deny',
  `rolrec_estado` INT NULL,
  PRIMARY KEY (`rol_id`, `rec_id`),
  INDEX `fk_auth_rol_has_auth_recurso_auth_recurso1_idx` (`rec_id` ASC),
  INDEX `fk_auth_rol_has_auth_recurso_auth_rol1_idx` (`rol_id` ASC),
  CONSTRAINT `fk_auth_rol_has_auth_recurso_auth_rol1`
    FOREIGN KEY (`rol_id`)
    REFERENCES `auth_rol` (`rol_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_auth_rol_has_auth_recurso_auth_recurso1`
    FOREIGN KEY (`rec_id`)
    REFERENCES `auth_recurso` (`rec_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
