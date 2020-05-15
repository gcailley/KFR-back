DROP TABLE rtlq_adherents_saisons;
CREATE TABLE rtlq_adherents_cotisations (cotisation_id INT NOT NULL, adherent_id INT NOT NULL, INDEX IDX_60B8F083EAA84B1 (cotisation_id), INDEX IDX_60B8F0825F06C53 (adherent_id), PRIMARY KEY(cotisation_id, adherent_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
ALTER TABLE rtlq_adherents_cotisations ADD CONSTRAINT FK_60B8F083EAA84B1 FOREIGN KEY (cotisation_id) REFERENCES rtlq_cotisation (id);
ALTER TABLE rtlq_adherents_cotisations ADD CONSTRAINT FK_60B8F0825F06C53 FOREIGN KEY (adherent_id) REFERENCES rtlq_adherent (id);
ALTER TABLE rtlq_adherent DROP FOREIGN KEY FK_E9CF7E313EAA84B1;
DROP INDEX IDX_E9CF7E313EAA84B1 ON rtlq_adherent;
ALTER TABLE rtlq_adherent DROP cotisation_id;
