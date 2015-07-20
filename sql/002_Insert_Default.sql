
INSERT INTO `auth_rol` (`rol_desc`) VALUES ('Adminstrador');

INSERT INTO `auth_usuario` (`us_usuario`, `us_password`,us_email,fecha_creacion,us_nombre,rol_id) 
VALUES ('admin', md5('tarazona'),'jmike410@gmail.com',now(),'Joaquin',1);

insert into auth_recurso (rec_desc,rec_uri,rec_estado,rec_tipo,rec_rec_id) values 
('Home','home',1,1,NULL);

insert into auth_rol_recurso (rec_id,rol_id,rolrec_permiso)
select (select rec_id from auth_recurso where rec_uri = 'home' and rec_tipo = 1),1,'allow';
