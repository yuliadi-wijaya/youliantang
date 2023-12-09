CREATE OR REPLACE VIEW trans_history_v
AS
SELECT
    x.customer_id,
    x.customer_name,
    x.customer_phone,
    x.email,
    x.invoice_id,
    x.invoice_code,
    x.invoice_date,
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
    x.therapist_id,
    x.therapist_name,
    x.therapist_phone,
    x.room,
    x.time_from,
    x.time_to,
    x.invoice_type,
    x.old_data
FROM (
    SELECT
        c.id AS customer_id,
        CONCAT(COALESCE(c.first_name,''), ' ', COALESCE(c.last_name,'')) AS customer_name,
        c.phone_number AS customer_phone,
        c.email,
        i.id AS invoice_id,
        i.invoice_code,
        i.created_at AS invoice_date,
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
        NULL AS therapist_id,
        NULL AS therapist_name,
        NULL AS therapist_phone,
        NULL AS room,
        NULL AS time_from,
        NULL AS time_to,
        i.invoice_type,
        i.old_data
    FROM invoices AS i
    JOIN users AS c ON c.id = i.customer_id
    WHERE i.old_data = 'N'
    AND i.is_deleted = 0
    AND i.status = 1

    UNION

    SELECT
        c.id AS customer_id,
        CONCAT(COALESCE(c.first_name,''), ' ', COALESCE(c.last_name,'')) AS customer_name,
        c.phone_number AS customer_phone,
        c.email,
        i.id AS invoice_id,
        i.invoice_code,
        i.created_at AS invoice_date,
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
        t.id AS therapist_id,
        CONCAT(COALESCE(t.first_name,''), ' ', COALESCE(t.last_name,'')) AS therapist_name,
        t.phone_number AS therapist_phone,
        i.room,
        i.treatment_time_from AS time_from,
        i.treatment_time_to AS time_to,
        i.invoice_type,
        i.old_data
    FROM invoices AS i
    JOIN invoice_details id ON id.invoice_id = i.id AND id.is_deleted = 0 AND id.status = 1
    JOIN users AS c ON LOWER(CONCAT(COALESCE(c.first_name,''), ' ', COALESCE(c.last_name,''))) = LOWER(i.customer_name)
    JOIN users AS t ON LOWER(CONCAT(COALESCE(t.first_name,''), ' ', COALESCE(t.last_name,''))) = LOWER(i.therapist_name)
    WHERE i.old_data = 'Y'
    AND i.is_deleted = 0
    AND i.status = 1
) x
ORDER BY x.invoice_date
