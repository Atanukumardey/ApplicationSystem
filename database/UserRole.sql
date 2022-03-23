CREATE TABLE `UserRole` (
    `RoleID` int(11) NOT NULL,
    `RoleName` varchar(255) NOT NULL);

INSERT INTO `UserRole`(`RoleId`,`RoleName`) VALUES (1,'user'),(2,'Accounts Controller'),(3,'College Inspector'),(4,'Librarian'),
(5,'Exam Controller'),(6,'Chief Engineer'),(7,'Chief Medical Officer'),(8,'Director, Department of Planning and Development'),
(9,'Deputy Registrar (Teacher Cell), Registrar\'s Office'),(10,'Deputy Registrar (Academic Cell), Registrar\'s Office'),
(11,'Deputy Registrar (Home Loan Branch), Registrar\'s Office'),(12,'Deputy Registrar (Confidential Branch) Registrar\'s Office'),
(13,'Verifier'),(14,'Admin'), (15,'DepartmentChairman'),(16, 'Registrar'),(17,'Deputy Registrar (Higher Study Branch) Registrar\'s Office');

ALTER TABLE `UserRole`
  ADD PRIMARY KEY (`RoleId`);
  
ALTER TABLE `UserRole`
  MODIFY `RoleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
