ALTER TABLE reviews ADD COLUMN therapist_id bigint unsigned DEFAULT NULL;
ALTER TABLE reviews ADD CONSTRAINT reviews_therapist_id_foreign FOREIGN KEY (therapist_id) REFERENCES users (id);

ALTER TABLE reviews ADD COLUMN invoice_detail_id bigint unsigned DEFAULT NULL;
ALTER TABLE reviews ADD CONSTRAINT reviews_invoice_detail_id_foreign FOREIGN KEY (invoice_detail_id) REFERENCES invoice_details (id);
