-- invoice_details

ALTER TABLE invoice_details
ADD COLUMN product_id bigint unsigned DEFAULT NULL;

ALTER TABLE invoice_details
ADD CONSTRAINT invoice_details_product_id_foreign FOREIGN KEY (product_id) REFERENCES products (id);

ALTER TABLE invoice_details
MODIFY COLUMN title varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;


-- invoices
ALTER TABLE invoices
MODIFY COLUMN customer_name varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

ALTER TABLE invoices
MODIFY COLUMN therapist_name varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

ALTER TABLE invoices
ADD COLUMN customer_id bigint unsigned DEFAULT NULL;

ALTER TABLE invoices
ADD COLUMN therapist_id bigint unsigned DEFAULT NULL;

ALTER TABLE invoices
ADD COLUMN old_data CHAR(1) DEFAULT 'N' COMMENT 'Y=>Yes, N=>No';

-- sebelum buat invoice baru update status old_data jadi Yes
UPDATE invoices SET old_data = 'Y';

ALTER TABLE invoices
ADD CONSTRAINT invoices_customer_id_foreign FOREIGN KEY (customer_id) REFERENCES users (id);

ALTER TABLE invoices
ADD CONSTRAINT invoices_therapist_id_foreign FOREIGN KEY (therapist_id) REFERENCES users (id);
