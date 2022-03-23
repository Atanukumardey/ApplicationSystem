CREATE TABLE `ProcessState`(
    `StateID` INT(3) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `ProcessName` VARCHAR(20)
); INSERT INTO `ProcessState`(`ProcessName`)
VALUES('Assigned'),('InProgress'),('Problem'),('Approved'),('Rejected'),('NotAssigned');