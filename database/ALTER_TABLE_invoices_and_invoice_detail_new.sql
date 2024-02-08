-- ALTER invoices
ALTER TABLE invoices MODIFY COLUMN room varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE invoices MODIFY COLUMN treatment_date date NOT NULL;
ALTER TABLE invoices MODIFY COLUMN treatment_time_from time NULL;
ALTER TABLE invoices MODIFY COLUMN treatment_time_to time NULL;

ALTER TABLE invoices ADD COLUMN is_member tinyint NULL;
ALTER TABLE invoices ADD COLUMN use_member tinyint NULL;
ALTER TABLE invoices ADD COLUMN member_plan varchar(191) NULL;
ALTER TABLE invoices ADD COLUMN voucher_code varchar(191) NULL;
ALTER TABLE invoices ADD COLUMN total_price double NULL;
ALTER TABLE invoices ADD COLUMN discount double NULL;
ALTER TABLE invoices ADD COLUMN grand_total double NULL;

-- ALTER TABLE invoices DROP FOREIGN KEY invoices_therapist_id_foreign;
-- ALTER TABLE invoices DROP COLUMN therapist_id;

-- ALTER invoice_details
ALTER TABLE invoice_details ADD COLUMN treatment_time_from time NULL;
ALTER TABLE invoice_details ADD COLUMN treatment_time_to time NULL;
ALTER TABLE invoice_details ADD COLUMN room varchar(191) COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE invoice_details ADD COLUMN therapist_id bigint unsigned NULL;

ALTER TABLE invoice_details ADD CONSTRAINT invoice_details_therapist_id_foreign FOREIGN KEY (`therapist_id`) REFERENCES `users` (`id`);
