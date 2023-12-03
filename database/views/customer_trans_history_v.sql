CREATE OR REPLACE VIEW customer_trans_history_v
AS
SELECT
    x.customer_id,
    x.customer_name,
    x.phone_number,
    x.email,
	x.invoice_code,
    x.treatment_date,
    x.payment_mode,
    x.payment_status,
    x.note,
    x.is_member,
    x.use_member,
    x.member_plan,
    x.voucher_code,
    x.total_price,
    x.discount,
    x.grand_total,
    x.amount,
    x.product_name,
    x.therapist_name,
    x.room,
    x.time_from,
    x.time_to,
    x.invoice_type
FROM (
    SELECT
        c.id AS customer_id,
        CONCAT(COALESCE(c.first_name,''), ' ', COALESCE(c.last_name,'')) AS customer_name,
        c.phone_number,
        c.email,
        i.invoice_code,
        i.treatment_date,
        i.payment_mode,
        i.payment_status,
        i.note,
        CASE WHEN COALESCE(i.is_member,0) = 0 THEN 'No' ELSE 'Yes' END AS is_member,
        CASE WHEN COALESCE(i.use_member,0) = 0 THEN 'No' ELSE 'Yes' END AS use_member,
        i.member_plan,
        i.voucher_code,
        i.total_price,
        i.discount,
        i.grand_total,
        id.invoice_id,
        id.amount,
        p.name AS product_name,
        CONCAT(COALESCE(t.first_name,''), ' ', COALESCE(t.last_name,'')) AS therapist_name,
        id.room,
        id.treatment_time_from AS time_from,
        id.treatment_time_to AS time_to,
        i.invoice_type
    FROM invoices AS i
    JOIN invoice_details id ON id.invoice_id = i.id AND id.is_deleted = 0 AND id.status = 1
    JOIN users AS c ON c.id = i.customer_id
    JOIN users AS t ON t.id = id.therapist_id
    JOIN products AS p ON p.id = id.product_id
    WHERE i.old_data = 'N'
    AND i.is_deleted = 0
    AND i.status = 1

    UNION
    
    SELECT
        c.id AS customer_id,
        CONCAT(COALESCE(c.first_name,''), ' ', COALESCE(c.last_name,'')) AS customer_name,
        c.phone_number,
        c.email,
        i.invoice_code,
        i.treatment_date,
        i.payment_mode,
        i.payment_status,
        i.note,
        CASE WHEN COALESCE(i.is_member,0) = 0 THEN 'No' ELSE 'Yes' END AS is_member,
        CASE WHEN COALESCE(i.use_member,0) = 0 THEN 'No' ELSE 'Yes' END AS use_member,
        i.member_plan,
        i.voucher_code,
        i.total_price,
        i.discount,
        i.grand_total,
        id.invoice_id,
        id.amount,
        id.title AS product_name,
        CONCAT(COALESCE(t.first_name,''), ' ', COALESCE(t.last_name,'')) AS therapist_name,
        i.room,
        i.treatment_time_from AS time_from,
        i.treatment_time_to AS time_to,
        i.invoice_type
    FROM invoices AS i
    JOIN invoice_details id ON id.invoice_id = i.id AND id.is_deleted = 0 AND id.status = 1
    JOIN users AS c ON LOWER(CONCAT(COALESCE(c.first_name,''), ' ', COALESCE(c.last_name,''))) = LOWER(i.customer_name)
    JOIN users AS t ON LOWER(CONCAT(COALESCE(t.first_name,''), ' ', COALESCE(t.last_name,''))) = LOWER(i.therapist_name)
    JOIN products AS p ON LOWER(p.name) = LOWER(id.title)
    WHERE i.old_data = 'Y'
    AND i.is_deleted = 0
    AND i.status = 1
) x
ORDER BY x.customer_name, x.invoice_id