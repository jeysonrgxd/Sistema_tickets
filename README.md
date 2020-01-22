# Sistema de Ticket para Evento Glomour

Este sistema fue desarrollado con las tecnologías de PHP, MySQL, HTML5, CSS3, JavaScript se usara AJAX para poder intercambiar datos con un servidor y actualizar partes de páginas web sin necesidad de recargar la página completamente. Se usaran procedimientos almacenados para la seguridad del acceso a datos y por la velocidad que este proporciona.

## Glosario
- **PK**-Primary Key
- **FK**-Foreign Key
- **UQ**-Unique
- **CAT**-Catalog
- **1-1**-One to One
- **M-M**-Many to Many

## Reglas de Negocio:
- Registrar participantes para el evento Entrena tu Glamour.
- El evento tendrá 4 disciplinas:
   - kickBoxing
   - Pilates
   - Yoga
   - Zumba
- Cada disciplina tendrá 3 bloques de horarios:
   - Bloque 1 de 9:00 a 12:00
   - Bloque 2 de 14:00 a 17:00
   - Bloque 3 de 18:00 a 21:00
- Cada bloque tendrá un máximo de 10 participates, excepto los de Yoga que tendrán 20.
- Cada participante sólo se pódra registrar a una sóla actividad.

## Modelo relacional de tablas para la base de datos del sistema

### Entidades

- **Actividades (CAT)**
   - actividad_id (***PK***)
   - bloque
   - disciplina
   - horario
   - cupo

- **Participantes**
   - email (***PK***) y (***UQ***)
   - nombre
   - apellidos
   - nacimiento

- **Registro**
   - registro_id (***PK***)
   - email (***FK***)
   - actividad (***FK***)
   - fecha
<<<<<<< HEAD

## Relacion del modelo
   1. Los **Participantes** crean un **Registro** (*1-1*).
   1. Las **Actividades** se asignan a un **Registro** (*1-1*).

## Diagrama relacional

![MDRT](diagramaSisTickets.jpg,"modelo relacional")
=======
>>>>>>> 7414ad903136d16023bb1340019b4bc3e0449d11
