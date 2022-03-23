CREATE TABLE `LogInfo`(`LogID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                       `UserIDref` int(11) NOT NULL,
                       `IpAddress` varchar(20) NOT NULL,
                       `OS` varchar(50) NOT NULL,
                       `WebBrowser` varchar(50) NOT NULL,
                       `Date` DATE,
                       `Time` TIME,
                      FOREIGN KEY (`UserIDref`) REFERENCES `users`(`UserID`) ON DELETE CASCADE ON UPDATE RESTRICT);