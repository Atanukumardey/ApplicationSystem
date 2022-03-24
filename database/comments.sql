CREATE TABLE `Comments`(
    `commentID` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `CommenterID` INT(11),
    `Comment` TEXT,
    `ProcessIDref` INT(11),
    FOREIGN KEY(`CommentorID`) REFERENCES `users`(`UserID`) ON DELETE CASCADE,
    FOREIGN KEY(`ProcessIDref`) REFERENCES `process`(`ProcessID`) ON DELETE CASCADE
);