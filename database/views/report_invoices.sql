CREATE OR REPLACE VIEW report_invoices AS
SELECT
    i.invoice_type,
    i.invoice_code,
    i.created_at AS invoice_date,
    CASE WHEN i.old_data = 'Y' THEN i.customer_name ELSE CONCAT(COALESCE(c.first_name,''), ' ', COALESCE(c.last_name,'')) END AS customer_name,
    c.phone_number AS customer_phone_number,
    i.payment_mode,
    i.payment_status,
    i.note,
    i.total_price,
    i.discount,
    i.grand_total,
    CASE WHEN i.old_data = 'Y' THEN ind.title ELSE p.name END AS product_name,
    ind.amount,
    p.duration,
    i.treatment_date,
    CASE WHEN i.old_data = 'Y' THEN i.treatment_time_from ELSE ind.treatment_time_from END AS treatment_time_from,
    CASE WHEN i.old_data = 'Y' THEN i.treatment_time_to ELSE ind.treatment_time_to END as treatment_time_to,
    CASE WHEN i.old_data = 'Y' THEN i.room ELSE ind.room END AS room,
    CASE WHEN i.old_data = 'Y' THEN i.therapist_name ELSE CONCAT(COALESCE(t.first_name,''), ' ', COALESCE(t.last_name,'')) END AS therapist_name,
    t.phone_number AS therapist_phone_number,
    p.commission_fee
FROM invoices AS i
INNER JOIN invoice_details AS ind ON ind.invoice_id = i.id
LEFT JOIN users AS c ON
    (i.old_data = 'Y' AND LOWER(CONCAT(COALESCE(c.first_name,''), ' ', COALESCE(c.last_name,''))) = LOWER(i.customer_name)) OR
    (i.old_data <> 'Y' AND c.id = i.customer_id)
LEFT JOIN users AS t ON
    (i.old_data = 'Y' AND LOWER(CONCAT(COALESCE(t.first_name,''), ' ', COALESCE(t.last_name,''))) = LOWER(i.customer_name)) OR
    (i.old_data <> 'Y' AND t.id = i.customer_id)
LEFT JOIN products AS p ON
    (i.old_data = 'Y' AND LOWER(p.name) = LOWER(ind.title) AND ind.is_deleted = 0 AND ind.status = 1) OR
    (i.old_data <> 'Y' AND p.id = ind.product_id AND ind.is_deleted = 0 AND ind.status = 1)
WHERE i.status = 1
    AND i.is_deleted = 0;
