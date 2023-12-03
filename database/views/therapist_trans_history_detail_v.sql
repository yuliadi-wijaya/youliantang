CREATE OR REPLACE VIEW therapist_trans_history_detail_v
AS
SELECT
    x.therapist_id,
    x.therapist_name,
    x.phone_number,
    x.email,
    x.invoice_code,
    x.treatment_date,
    x.payment_mode,
    x.payment_status,
    x.note,
    x.voucher_code,
    x.total_price,
    x.discount,
    x.grand_total,
    x.invoice_id,
    x.amount,
    x.product_name,
    x.duration,
    x.commission_fee,
    x.customer_id,
    x.customer_name,
    x.room,
    x.time_from,
    x.time_to,
    x.invoice_type,
    x.rating,
    x.comment
FROM (
    SELECT
        t.id AS therapist_id,
        CONCAT(COALESCE(t.first_name,''), ' ', COALESCE(t.last_name,'')) AS therapist_name,
        t.phone_number,
        t.email,
        i.invoice_code,
        i.treatment_date,
        i.payment_mode,
        i.payment_status,
        i.note,
        i.voucher_code,
        i.total_price,
        i.discount,
        i.grand_total,
        id.invoice_id,
        id.amount,
        p.name AS product_name,
        p.duration,
        p.commission_fee,
        c.id AS customer_id,
        CONCAT(COALESCE(c.first_name,''), ' ', COALESCE(c.last_name,'')) AS customer_name,
        id.room,
        id.treatment_time_from AS time_from,
        id.treatment_time_to AS time_to,
        i.invoice_type,
        r.rating,
        r.comment
    FROM invoices AS i
    JOIN invoice_details id ON id.invoice_id = i.id
        AND id.is_deleted = 0
        AND id.status = 1
    JOIN users AS c ON c.id = i.customer_id
    JOIN users AS t ON t.id = id.therapist_id
    JOIN products AS p ON p.id = id.product_id
    LEFT JOIN reviews AS r ON r.invoice_id = i.id
        AND r.invoice_detail_id = id.id
        AND r.therapist_id = id.therapist_id
    WHERE i.old_data = 'N'
    AND i.is_deleted = 0
    AND i.status = 1

    UNION

    SELECT
        t.id AS therapist_id,
        CONCAT(COALESCE(t.first_name,''), ' ', COALESCE(t.last_name,'')) AS therapist_name,
        t.phone_number,
        t.email,
        i.invoice_code,
        i.treatment_date,
        i.payment_mode,
        i.payment_status,
        i.note,
        i.voucher_code,
        i.total_price,
        i.discount,
        i.grand_total,
        id.invoice_id,
        id.amount,
        p.name AS product_name,
        p.duration,
        p.commission_fee,
        c.id AS customer_id,
        CONCAT(COALESCE(c.first_name,''), ' ', COALESCE(c.last_name,'')) AS customer_name,
        i.room,
        i.treatment_time_from AS time_from,
        i.treatment_time_to AS time_to,
        i.invoice_type,
        NULL AS rating,
        NULL AS comment
    FROM invoices AS i
    JOIN invoice_details id ON id.invoice_id = i.id AND id.is_deleted = 0 AND id.status = 1
    JOIN users AS c ON LOWER(CONCAT(COALESCE(c.first_name,''), ' ', COALESCE(c.last_name,''))) = LOWER(i.customer_name)
    JOIN users AS t ON LOWER(CONCAT(COALESCE(t.first_name,''), ' ', COALESCE(t.last_name,''))) = LOWER(i.therapist_name)
    JOIN products AS p ON LOWER(p.name) = LOWER(id.title)
    WHERE i.old_data = 'Y'
    AND i.is_deleted = 0
    AND i.status = 1
) x
ORDER BY x.therapist_name, x.invoice_id
