DROP TABLE IF EXISTS
  users,
  customers,
  products,
  invoices,
  sales;  
  
CREATE TABLE users(
  userid INT,
  username VARCHAR(15) NOT NULL,
  name VARCHAR(30) NOT NULL,
  surname VARCHAR(60) NOT NULL,
  email VARCHAR(60) NOT NULL,
  useractive BOOLEAN NOT NULL,
  userpass VARCHAR(20) NOT NULL,
  CONSTRAINT users_pk PRIMARY KEY AUTO_INCREMENT(userid)
);
CREATE TABLE customers(
  customerid INT,
  customername VARCHAR(20),
  customerCIF VARCHAR(20) UNIQUE,
  customeraddress VARCHAR(100),
  CONSTRAINT customer_pk PRIMARY KEY AUTO_INCREMENT(customerid)
);
CREATE TABLE products(
  productid INT,
  productname VARCHAR(50) NOT NULL,
  productdescp VARCHAR(300),
  productqtty INT NOT NULL DEFAULT 0,
  productcost FLOAT NOT NULL,
  CONSTRAINT products_pk PRIMARY KEY AUTO_INCREMENT(productid),
  CONSTRAINT check_qtty
CHECK
  (productqtty >= 0)
);
CREATE TABLE invoices(
  invoiceid INT,
  customerid INT NOT NULL,
  invocicedate DATE,
  total FLOAT,
  globaldiscount FLOAT,
  tax ENUM('0.0', '21.0'),
  CONSTRAINT invoices_pk PRIMARY KEY AUTO_INCREMENT(invoiceid),
  CONSTRAINT customer_fk FOREIGN KEY(customerid) REFERENCES customers(customerid) ON UPDATE CASCADE ON DELETE RESTRICT
);
CREATE TABLE sales(
  saleid INT NOT NULL,
  productid INT,
  invoiceid INT,
  saleprice FLOAT NOT NULL,
  salediscount FLOAT NOT NULL,
  qtty INT NOT NULL,    
  CONSTRAINT check_qtty CHECK  (qtty > 0),
  CONSTRAINT check_discount CHECK  (salesdiscount BETWEEN 0 AND 100),
  CONSTRAINT invoice_fk FOREIGN KEY(invoiceid) REFERENCES invoices(invoiceid) ON 	DELETE RESTRICT ON UPDATE CASCADE,  
  CONSTRAINT products_fk FOREIGN KEY(productid) REFERENCES products(productid) ON 	UPDATE CASCADE ON DELETE RESTRICT,
CONSTRAINT saleid_pk PRIMARY KEY AUTO_INCREMENT (saleid));

DROP USER IF EXISTS  'user1';
DROP ROLE IF EXISTS 'dbwriter';

CREATE USER 'user1' IDENTIFIED BY '123';
CREATE ROLE 'dbwriter';

GRANT INSERT ON  proyecto1.* TO 'dbwriter';
GRANT UPDATE ON  proyecto1.* TO 'dbwriter';
GRANT DELETE ON  proyecto1.* TO 'dbwriter';
GRANT 'dbwriter' TO 'user1';

ALTER TABLE `customers` ADD `email` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;