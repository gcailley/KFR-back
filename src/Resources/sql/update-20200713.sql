CREATE TABLE rtlq_referents_taos (tao_id INT NOT NULL, adherent_id INT NOT NULL, INDEX IDX_2FBBCB117F664BFE (tao_id), INDEX IDX_2FBBCB1125F06C53 (adherent_id), PRIMARY 
KEY(tao_id, adherent_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

ALTER TABLE rtlq_referents_taos ADD CONSTRAINT FK_2FBBCB117F664BFE FOREIGN KEY (tao_id) REFERENCES rtlq_tao (id);
ALTER TABLE rtlq_referents_taos ADD CONSTRAINT FK_2FBBCB1125F06C53 FOREIGN KEY (adherent_id) REFERENCES rtlq_adherent (id);

ALTER TABLE rtlq_tao ADD reference_drive_id VARCHAR(255) DEFAULT NULL;

ALTER TABLE rtlq_association ADD message VARCHAR(1000) DEFAULT NULL, ADD closed TINYINT(1) NOT NULL DEFAULT 0;
     