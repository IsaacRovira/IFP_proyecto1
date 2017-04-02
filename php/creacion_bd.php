<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <!--
            Creación base de datos
        //-->
        <title>Creación de la base de datos</title>
    </head>
    <body>
        <?php
            $host = 'localhost:3360';
            $user = 'root';
            $pass = 'RooT';

            // Utilizamos la función new mysqli(host, usuario, pass) para la conexión.
            $connect = mysqli_connect($host, $user, $pass);
            if($connect->connect_error){
             die("Imposible conectar: " . $connect->connect_error);
            }
            print ()"<p>¡Conexión realizada!</p>\n");
        ?>
        
        <?php
            // Creación de la base de datos
            $sql["Create"] = "CREATE DATABASE IF NOT EXISTS proyecto1";

            $sql["Drop"] = "DROP TABLE IF EXISTS users, sales, products, invoices, customers";

            $sql["Users"] = "CREATE TABLE users(userid INT, username VARCHAR(15) NOT NULL,  name VARCHAR(30) NOT NULL, surname VARCHAR(60) NOT NULL,  email VARCHAR(60) NOT NULL, useractive BOOLEAN NOT NULL, userpass VARCHAR(20) NOT NULL, userlevel INT,  CONSTRAINT users_pk PRIMARY KEY AUTO_INCREMENT(userid), CONSTRAINT check_level CHECK (userlevel between 0 and 4))";

            $sql["clientes"] = "CREATE TABLE customers( customerid INT, customername VARCHAR(20), customerCIF VARCHAR(20) UNIQUE, customeraddress VARCHAR(100), email varchar(60), phone varchar(16), CONSTRAINT customer_pk PRIMARY KEY AUTO_INCREMENT(customerid))";

            $sql["Productos"] = "CREATE TABLE products( productid INT, productname VARCHAR(50) NOT NULL, productdescp VARCHAR(300), productqtty INT UNSIGNED NOT NULL, productcost FLOAT NOT NULL, CONSTRAINT products_pk PRIMARY KEY AUTO_INCREMENT(productid))";

            $sql["facturas"] = "CREATE TABLE invoices(invoiceid INT, customerid INT NOT NULL, invocicedate DATE, globaldiscount FLOAT DEFAULT 0.0, tax ENUM('0.0', '21.0'), CONSTRAINT invoices_pk PRIMARY KEY AUTO_INCREMENT(invoiceid), CONSTRAINT customer_fk FOREIGN KEY(customerid) REFERENCES customers(customerid) ON UPDATE CASCADE ON DELETE RESTRICT, CONSTRAINT GD_check CHECK (globaldiscount between 0 and 100))";

            $sql["Ventas"] ="CREATE TABLE sales(saleid INT NOT NULL, productid INT NOT NULL, invoiceid INT NOT NULL, saleprice FLOAT NOT NULL, salediscount FLOAT NOT NULL DEFAULT 0.0, qtty INT NOT NULL, CONSTRAINT check_qtty CHECK  (qtty > 0),  CONSTRAINT check_discount CHECK  (salesdiscount BETWEEN 0 AND 100), CONSTRAINT invoice_fk FOREIGN KEY(invoiceid) REFERENCES invoices(invoiceid) ON DELETE RESTRICT ON UPDATE CASCADE, CONSTRAINT products_fk FOREIGN KEY(productid) REFERENCES products(productid) ON 	UPDATE CASCADE ON DELETE RESTRICT, CONSTRAINT saleid_pk PRIMARY KEY AUTO_INCREMENT (saleid))";

            $sql["roles"] = "DROP ROLE IF EXISTS 'dbwriter';
            CREATE ROLE 'dbwriter';
            GRANT INSERT ON  proyecto1.* TO 'dbwriter';
            GRANT UPDATE ON  proyecto1.* TO 'dbwriter';
            GRANT DELETE ON  proyecto1.* TO 'dbwriter';
            DROP USER IF EXISTS 'user1';
            CREATE USER 'user1' IDENTIFIED BY '123';
            GRANT 'dbwriter' TO 'user1';";

            $sqlALL = "
            /*
                Creación base de datos proyecto1
                Autor:			Isaac Rovira
                Modificación:	01/04/2017
                MariaDB(MySQL)
            */

            CREATE DATABASE IF NOT EXISTS proyecto1;

            DROP TABLE IF EXISTS
              users,  
              sales,
              products,
              invoices,
              customers;

            /*
            Tabla para el registro de usuarios que tendrán acceso a los datos.
            Nombre de usuario, Nombre, Apellidos, correo, cuenta activa, password,
            userlevel:
            -0 root (crear usuarios)
            -1 leer, actualizar, crear y borrar
            -2 leer, actualizar y crear
            -3 leer y actualizar
            -4 leer
            */  
            CREATE TABLE users(
              userid INT,
              username VARCHAR(15) NOT NULL,
              name VARCHAR(30) NOT NULL,
              surname VARCHAR(60) NOT NULL,
              email VARCHAR(60) NOT NULL,
              useractive BOOLEAN NOT NULL,
              userpass VARCHAR(20) NOT NULL,
              userlevel INT,
              CONSTRAINT users_pk PRIMARY KEY AUTO_INCREMENT(userid),
              CONSTRAINT check_level CHECK (userlevel between 0 and 4)
            );

            /*
            Tabla para el registro de los clientes.
            Nombre del cliente, CIF, Dirección Postal, email, teléfono.
            */
            CREATE TABLE customers(
              customerid INT,
              customername VARCHAR(20),
              customerCIF VARCHAR(20) UNIQUE,  
              customeraddress VARCHAR(100),
              email varchar(60),
              phone varchar(16),
              CONSTRAINT customer_pk PRIMARY KEY AUTO_INCREMENT(customerid)
            );

            /*
            Tabla para el registro de los productos.
            Nombre del producto, descripción, cantidad en stock, coste por unidad.
            */
            CREATE TABLE products(
              productid INT,
              productname VARCHAR(50) NOT NULL,
              productdescp VARCHAR(300),
              productqtty INT UNSIGNED NOT NULL,
              productcost FLOAT NOT NULL,
              CONSTRAINT products_pk PRIMARY KEY AUTO_INCREMENT(productid)
            );

            /*
            Tabla facturas.
            Id del cliente, fecha factura, descuento global aplicado, iva aplicado.
            Se relaciona con la tabla customers y sales.
            */
            CREATE TABLE invoices(
              invoiceid INT,
              customerid INT NOT NULL,
              invocicedate DATE,  
              globaldiscount FLOAT DEFAULT 0.0,
              tax ENUM('0.0', '21.0'),
              CONSTRAINT invoices_pk PRIMARY KEY AUTO_INCREMENT(invoiceid),
              CONSTRAINT customer_fk FOREIGN KEY(customerid) REFERENCES customers(customerid) ON UPDATE CASCADE ON DELETE RESTRICT,
              CONSTRAINT GD_check CHECK (globaldiscount between 0 and 100)  
            );

            /*
            Tabla ventas.
            Id del producto, id de la factura, precio de venta unidad, descuento sobre el precio de venta, cantidad vendida.
            */
            CREATE TABLE sales(
              saleid INT NOT NULL,
              productid INT NOT NULL,
              invoiceid INT NOT NULL,
              saleprice FLOAT NOT NULL,
              salediscount FLOAT NOT NULL DEFAULT 0.0,
              qtty INT NOT NULL,    
              CONSTRAINT check_qtty CHECK  (qtty > 0),
              CONSTRAINT check_discount CHECK  (salesdiscount BETWEEN 0 AND 100),
              CONSTRAINT invoice_fk FOREIGN KEY(invoiceid) REFERENCES invoices(invoiceid) ON 	DELETE RESTRICT ON UPDATE CASCADE,  
              CONSTRAINT products_fk FOREIGN KEY(productid) REFERENCES products(productid) ON 	UPDATE CASCADE ON DELETE RESTRICT,
            CONSTRAINT saleid_pk PRIMARY KEY AUTO_INCREMENT (saleid));

            /*
            Creación de usuarios y roles
            */

            DROP ROLE IF EXISTS 'dbwriter';
            CREATE ROLE 'dbwriter';
            GRANT INSERT ON  proyecto1.* TO 'dbwriter';
            GRANT UPDATE ON  proyecto1.* TO 'dbwriter';
            GRANT DELETE ON  proyecto1.* TO 'dbwriter';

            DROP USER IF EXISTS  'user1';
            CREATE USER 'user1' IDENTIFIED BY '123';
            GRANT 'dbwriter' TO 'user1';";

            if(mysqli_query($connect, $sqlALL)){
                print "Base de datos Proyecto1 creada";            
            }else{

                print "Error creando la base de datos: " . mysqli_error($connect);
            }
        ?>
    </body>
</html>