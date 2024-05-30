/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.4.24-MariaDB : Database - pruebatecnicadb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pruebatecnicadb` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `pruebatecnicadb`;

/*Table structure for table `empresas` */

DROP TABLE IF EXISTS `empresas`;

CREATE TABLE `empresas` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `nom_empresa` varchar(30) DEFAULT NULL,
  `nit_empresa` varchar(20) DEFAULT NULL,
  `dir_empresa` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `empresas` */

insert  into `empresas`(`id_empresa`,`nom_empresa`,`nit_empresa`,`dir_empresa`) values (1,'TechSolutions S.A.','123456789','Carrera Prueba');

/*Table structure for table `historias_usuario` */

DROP TABLE IF EXISTS `historias_usuario`;

CREATE TABLE `historias_usuario` (
  `id_historia` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyecto` int(11) NOT NULL,
  `nom_historia` varchar(255) NOT NULL,
  `desc_historia` text NOT NULL,
  PRIMARY KEY (`id_historia`),
  KEY `story_fk_project` (`id_proyecto`),
  CONSTRAINT `story_fk_project` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `historias_usuario` */

insert  into `historias_usuario`(`id_historia`,`id_proyecto`,`nom_historia`,`desc_historia`) values (1,1,' Poder tener un carrito de compras por usuario','Los usuarios deben poder agregar productos a un carrito de compras, ver los detalles del carrito y gestionar los productos dentro del mismo.'),(2,1,'Proceso de pago seguro','Los usuarios deben poder realizar pagos seguros a través de una pasarela de pago confiable, ver un resumen de su pedido antes de confirmar el pago y validar su información de pago.'),(3,1,'Gestión de usuarios y autenticación','La plataforma debe permitir a los usuarios registrarse, iniciar sesión y recuperar sus contraseñas en caso de olvidarlas.');

/*Table structure for table `proyectos` */

DROP TABLE IF EXISTS `proyectos`;

CREATE TABLE `proyectos` (
  `id_proyecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `project_name` varchar(50) DEFAULT NULL,
  `project_state` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_proyecto`),
  KEY `project_fk_user` (`id_usuario`),
  CONSTRAINT `project_fk_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `proyectos` */

insert  into `proyectos`(`id_proyecto`,`id_usuario`,`fecha_inicio`,`fecha_fin`,`descripcion`,`project_name`,`project_state`) values (1,1,'2024-05-28','2024-05-29','Desarrollo de una plataforma de comercio electrónico para la venta de productos tecnológicos. La plataforma permitirá a los usuarios navegar por diferentes categorías de productos, agregar productos a','Plataforma de E-commerce',2);

/*Table structure for table `tickets` */

DROP TABLE IF EXISTS `tickets`;

CREATE TABLE `tickets` (
  `id_ticket` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `titulo_ticket` varchar(100) DEFAULT NULL,
  `descr_ticket` text DEFAULT NULL,
  `estado_ticket` varchar(20) DEFAULT NULL,
  `comentarios_ticket` text DEFAULT NULL,
  `id_historia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ticket`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tickets` */

insert  into `tickets`(`id_ticket`,`titulo_ticket`,`descr_ticket`,`estado_ticket`,`comentarios_ticket`,`id_historia`) values (1,'Diseño del Carrito de Compras','Crear la interfaz de usuario para visualizar los detalles del carrito de compras.','Finalizado','\"Necesitamos asegurarnos de que la interfaz sea intuitiva y fácil de usar para los usuarios.\"\n\"Voy a comenzar diseñando los componentes básicos del carrito, como la lista de productos y los botones de acción.\"',1),(2,'Eliminar Productos del Carrito','Implementar la funcionalidad para que los usuarios puedan eliminar productos del carrito.','Finalizado','\"Necesitamos agregar un botón de eliminar en cada producto del carrito para permitir a los usuarios eliminar productos fácilmente.\"\n\"Voy a trabajar en la lógica para eliminar productos tanto en el frontend como en el backend.\"',1),(3,'Integración con Stripe','Integrar la pasarela de pago Stripe para procesar los pagos de los usuarios de forma segura.','Activo','\"Voy a seguir la documentación de Stripe para configurar la integración en nuestro sistema.\"\n\"Es importante manejar correctamente los errores de pago y las devoluciones de fondos.\"',2),(4,'Diseño del Resumen de Pedido','Diseñar la página donde los usuarios puedan revisar un resumen detallado de su pedido antes de proceder al pago.','Activo','\"La página debe mostrar claramente los productos seleccionados, el total de la orden y la información de envío.\"\n\"Voy a utilizar un diseño limpio y minimalista para evitar confusiones.\"',2),(5,'Validación de Información de Pago','Validar la información de pago proporcionada por el usuario antes de procesar la transacción.','Activo','\"Necesitamos verificar que los detalles de la tarjeta de crédito sean válidos y estén completos antes de enviar la solicitud de pago a Stripe.\"\n\"Voy a agregar mensajes de error claros para guiar a los usuarios en caso de problemas con su información de pago.\"',2),(6,'Registro de Nuevos Usuarios','Desarrollar la funcionalidad para que los usuarios puedan registrarse en la plataforma proporcionando su información básica.','Activo','\"Voy a incluir campos como nombre, correo electrónico y contraseña en el formulario de registro.\"\n\"Es importante validar la dirección de correo electrónico y verificar que no esté duplicada en nuestra base de datos.\"',3),(7,'Inicio de Sesión de Usuarios','Implementar la funcionalidad para que los usuarios puedan iniciar sesión en la plataforma con sus credenciales.','Activo','\"Voy a utilizar tokens de sesión para mantener a los usuarios autenticados durante su visita.\"\n\"Es importante manejar correctamente los casos de inicio de sesión fallidos y mostrar mensajes de error informativos.\"',3),(8,'Recuperación de Contraseña','Desarrollar la funcionalidad para que los usuarios puedan restablecer su contraseña en caso de olvidarla.','Activo','\"Voy a enviar un correo electrónico al usuario con un enlace seguro para restablecer su contraseña.\"\n\"Es fundamental garantizar la seguridad del proceso de restablecimiento de contraseña para proteger la privacidad de los usuarios.\"',3);

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) DEFAULT NULL,
  `nombre_us` varchar(30) DEFAULT NULL,
  `apellido_us` varchar(30) DEFAULT NULL,
  `correo_us` varchar(50) DEFAULT NULL,
  `pass` text DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `user_fk_empresa` (`id_empresa`),
  CONSTRAINT `user_fk_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `usuarios` */

insert  into `usuarios`(`id_usuario`,`id_empresa`,`nombre_us`,`apellido_us`,`correo_us`,`pass`) values (1,1,'Jose ','Herrera','jherrerab1123@gmail.com','$2y$10$5wYLAfURdC4EptnYhfgd/OdAUNxxL5kqPYZFBCG280KWQDrqcXduC');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
