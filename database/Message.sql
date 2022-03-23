 CREATE TABLE `Message`(
    `MessageID` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `MessageBody` TEXT,
    `SendDate` DATE,
    `ProcessIDref` INT(11) NOT NULL,
    `SenderID` INT(11) NOT NULL,
    `ReceiverID` INT(11) NOT NULL,
    `ReceiveStatus` INT(3) NOT NULL, 
    FOREIGN KEY(`ProcessIDref`) REFERENCES `process`(`ProcessID`) ON DELETE CASCADE,
    FOREIGN KEY (`ReceiverID`) REFERENCES `users`(`UserID`) ON DELETE CASCADE,
    FOREIGN KEY (`SenderID`) REFERENCES `users`(`UserID`) ON DELETE CASCADE
);