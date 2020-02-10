CREATE TABLE rtlq_adherents_events (event_id INT NOT NULL, adherent_id INT NOT NULL, INDEX IDX_406FD7F771F7E88B (event_id), INDEX IDX_406FD7F725F06C53 (adherent_id), PRIMARY KEY(event_id, adherent_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
     ALTER TABLE rtlq_adherents_events ADD CONSTRAINT FK_406FD7F771F7E88B FOREIGN KEY (event_id) REFERENCES rtlq_event (id);
     ALTER TABLE rtlq_adherents_events ADD CONSTRAINT FK_406FD7F725F06C53 FOREIGN KEY (adherent_id) REFERENCES rtlq_adherent (id);
     ALTER TABLE rtlq_event ADD nb_accompagnants INT NOT NULL, ADD nb_people INT NOT NULL, CHANGE commentaire commentaire VARCHAR(100) DEFAULT NULL;
     