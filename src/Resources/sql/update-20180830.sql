ALTER TABLE rtlq_photo ADD source_name VARCHAR(255) NOT NULL, ADD thumbnail_name VARCHAR(255) NOT NULL, DROP source_base64, DROP thumbnail_base64, CHANGE source_mime_type source_mime_type VARCHAR(20) NOT NULL, CHANGE source_file_size source_file_size VARCHAR(20) NOT NULL, CHANGE thumbnail_mime_type thumbnail_mime_type VARCHAR(20) NOT NULL, CHANGE thumbnail_file_size thumbnail_file_size VARCHAR(20) NOT NULL;