create database Proyecto_Ejemplo;
use Proyecto_Ejemplo;

create table personas
(
id INT,
nombre VARCHAR(45),
apellido_paterno VARCHAR(45),
apellido_materno VARCHAR(45),
id_tipo_documento VARCHAR(45),
numero_documento VARCHAR(45),
PRIMARY KEY (id)
);

insert into  personas values (1,"juan","sa","si",2,1);
insert into  personas values (2,"yessi","jung","assas",2,5);
insert into  personas values (3,"jessi","Tini","Gat",4,5);
insert into  personas values (4,"Maki","Niki","Sino",4,5);

create table horarios_profesores
(
    id INT ,
    id_persona INT,
    dia_semana INT,
    disponible INT,
    fecha DATE,
    hora_inicio TIME,
    hora_fin TIME,
    fecha_activacion DATE,
    fecha_desactivacion DATE,
    PRIMARY KEY(id),
    FOREIGN KEY (id_persona) REFERENCES personas(id)
);

 insert into horarios_profesores values(1,1,1,1,"2021-06-23","12:30:00","16:00:00","2021-06-24","2021-06-25");
 insert into horarios_profesores values(2,1,1,1,"2021-07-23","21:20:00","18:00:45","2021-07-25","2021-07-06");
 insert into horarios_profesores values(3,2,1,1,"2021-08-23","16:15:00","06:45:52","2021-08-04","2021-08-06");
 insert into horarios_profesores values(4,2,1,1,"2021-09-23","17:30:45","04:00:25","2021-09-03","2021-09-07");


create table cursos
(
    id INT,
    nombre VARCHAR(45),
    PRIMARY KEY(id) 
);

insert into cursos  values (1,"Programacion");
insert into cursos  values (2,"Ingles");
insert into cursos  values (3,"Aleman");
insert into cursos  values (4,"Chino");
create table clases
(
    id INT,
    nombre VARCHAR(45),
    id_curso INT,
    PRIMARY KEY(id), 
    FOREIGN KEY (id_curso) REFERENCES cursos(id)
);


insert into clases values (1,'Diurno',1);
insert into clases values (2,'Vespertino',1);
insert into clases values (3,'Diurno',2);

create table alumnos_cursos
(
    id INT,
    id_persona INT,
    id_curso INT,
    PRIMARY KEY(id),
    FOREIGN KEY (id_persona) REFERENCES personas(id),
    FOREIGN KEY (id_curso) REFERENCES cursos(id)   
);
insert into alumnos_cursos values (1,1,1);
insert into alumnos_cursos values (2,3,1);
insert into alumnos_cursos values (3,4,1);
insert into alumnos_cursos values (4,2,2);
insert into alumnos_cursos values (5,3,2);
insert into alumnos_cursos values (6,4,2);
create table sedes
(
    id INT,
    nombre VARCHAR(45),
    direccion VARCHAR(45),
    PRIMARY key (id)
);

insert into sedes values (1,"Puente Alto","Puente Alto #4513");
insert into sedes values (2,"Las Condes","Las Condes #8571");

create table clases_sedes
(
    id INT,
    fecha DATE,
    hora_inicio TIME,
    hora_fin TIME,
    id_clase INT,
    id_sede INT,
    PRIMARY KEY (id),
    FOREIGN KEY (id_clase) REFERENCES clases(id), 
    FOREIGN KEY (id_sede) REFERENCES sedes(id)
);

insert into clases_sedes values (1,"2041-06-23","14::00:00","15:00:00",1,2);
insert into clases_sedes values (2,"2029-06-23","15::00:00","16:00:00",2,1);

create table alumnos_cursos_clases_sedes
(
    id INT,
    asisio INT,
    fecha DATE,
    hora_inicio TIME,
    hora_fin TIME,
    id_alumno_cursos INT,
    id_clase_sede INT,
    PRIMARY KEY (id),
    FOREIGN KEY (id_alumno_cursos) REFERENCES alumnos_cursos(id),
    FOREIGN KEY (id_clase_sede) REFERENCES clases_sedes(id)
);