CREATE TABLE rtlq_database_version (id INT AUTO_INCREMENT NOT NULL, resource_name VARCHAR(500) NOT NULL, etat TINYINT(1) NOT NULL, INDEX id (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

INSERT INTO `rtlq_database_version` VALUES(null, 'update-20180830.sql', 1);
INSERT INTO `rtlq_database_version` VALUES(null, 'update-20181004.sql', 1);
INSERT INTO `rtlq_database_version` VALUES(null, 'update-20190330.sql', 1);
INSERT INTO `rtlq_database_version` VALUES(null, 'update-20190607.sql', 1);
INSERT INTO `rtlq_database_version` VALUES(null, 'update-20190730.sql', 1);
INSERT INTO `rtlq_database_version` VALUES(null, 'update-20190731.sql', 1);
INSERT INTO `rtlq_database_version` VALUES(null, 'update-20190828.sql', 1);
INSERT INTO `rtlq_database_version` VALUES(null, 'update-20190909.sql', 1);
INSERT INTO `rtlq_database_version` VALUES(null, 'update-20191021.sql', 1);
INSERT INTO `rtlq_database_version` VALUES(null, 'update-20191026.sql', 1);
INSERT INTO `rtlq_database_version` VALUES(null, 'update-20191028.sql', 1);
INSERT INTO `rtlq_database_version` VALUES(null, 'update-20191202.sql', 1);
INSERT INTO `rtlq_database_version` VALUES(null, 'update-20200112.sql', 1);
INSERT INTO `rtlq_database_version` VALUES(null, 'update-20200127.sql', 1);
COMMIT;