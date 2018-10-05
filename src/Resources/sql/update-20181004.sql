ALTER TABLE rtlq_tresorie_etat ADD next_etat_id INT NOT NULL;
ALTER TABLE rtlq_tresorie_etat ADD CONSTRAINT FK_87F4CBE1CFD0AC5D FOREIGN KEY (next_etat_id) REFERENCES rtlq_tresorie_etat (id);
CREATE INDEX IDX_87F4CBE1CFD0AC5D ON rtlq_tresorie_etat (next_etat_id);