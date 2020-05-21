
CREATE TABLE rtlq_bureau (id INT AUTO_INCREMENT NOT NULL, president_id INT NOT NULL, secretaire_id INT NOT NULL, tresorier_id INT NOT NULL, date_creation DATE NOT NULL, date_fin DATE NOT NULL,INDEX IDX_9AF67ABBB40A33C7 (president_id), INDEX IDX_9AF67ABBA90F02B2 (secretaire_id), INDEX IDX_9AF67ABB5014067D (tresorier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
ALTER TABLE rtlq_bureau ADD CONSTRAINT FK_9AF67ABBB40A33C7 FOREIGN KEY (president_id) REFERENCES rtlq_adherent (id);
ALTER TABLE rtlq_bureau ADD CONSTRAINT FK_9AF67ABBA90F02B2 FOREIGN KEY (secretaire_id) REFERENCES rtlq_adherent (id);
ALTER TABLE rtlq_bureau ADD CONSTRAINT FK_9AF67ABB5014067D FOREIGN KEY (tresorier_id) REFERENCES rtlq_adherent (id);

CREATE TABLE rtlq_bureaux_saisons (bureau_id INT NOT NULL, saison_id INT NOT NULL, INDEX IDX_EFFF9B6232516FE2 (bureau_id), INDEX IDX_EFFF9B62F965414C (saison_id), PRIMARY KEY(bureau_id, saison_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
ALTER TABLE rtlq_bureaux_saisons ADD CONSTRAINT FK_EFFF9B6232516FE2 FOREIGN KEY (bureau_id) REFERENCES rtlq_bureau (id);
ALTER TABLE rtlq_bureaux_saisons ADD CONSTRAINT FK_EFFF9B62F965414C FOREIGN KEY (saison_id) REFERENCES rtlq_saison (id);