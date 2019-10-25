DROP TABLE rtlq_adherents_taos;

     CREATE TABLE rtlq_adherents_taos (id INT AUTO_INCREMENT NOT NULL, adherent_id INT DEFAULT NULL, tao_id INT NOT NULL, nb_revision INT NOT NULL, niveau INT NOT NULL, INDEX IDX_1CFD83D25F06C53 (adherent_id), INDEX IDX_1CFD83D7F664BFE (tao_id), INDEX id (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
     ALTER TABLE rtlq_adherents_taos ADD CONSTRAINT FK_1CFD83D25F06C53 FOREIGN KEY (adherent_id) REFERENCES rtlq_adherent (id);
     ALTER TABLE rtlq_adherents_taos ADD CONSTRAINT FK_1CFD83D7F664BFE FOREIGN KEY (tao_id) REFERENCES rtlq_tao (id);