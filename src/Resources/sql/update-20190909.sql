     ALTER TABLE rtlq_cours ADD nb_cours_essais INT DEFAULT NULL, CHANGE description description VARCHAR(1000) DEFAULT NULL;



CREATE TABLE `rtlq_categorie_votee` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `saison_id` int(11) DEFAULT NULL,
  `montant` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `rtlq_categorie_votee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;



ALTER TABLE rtlq_categorie_votee ADD CONSTRAINT FK_42182070BCF5E72D FOREIGN KEY (categorie_id) REFERENCES rtlq_tresorie_categorie (id);     
ALTER TABLE rtlq_categorie_votee ADD CONSTRAINT FK_42182070F965414C FOREIGN KEY (saison_id) REFERENCES rtlq_saison (id);


