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
) ENGINE=InnoDB AUTO_INCREMENT=1;

-- users data with password = md5('admin')
INSERT INTO `auth_usuario` (`us_usuario`, `us_password`,us_email,fecha_creacion) VALUES
('admin', md5('tarazona'),'jmike410@gmail.com',now());
