ALTER TABLE rtlq_materiel CHANGE date_achat date_achat DATE NOT NULL;
ALTER TABLE rtlq_photo_directories 
    ADD actif TINYINT(1) NOT NULL, 
    CHANGE name name VARCHAR(1000) DEFAULT NULL;
