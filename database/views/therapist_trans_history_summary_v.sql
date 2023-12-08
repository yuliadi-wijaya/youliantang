CREATE OR REPLACE VIEW therapist_trans_history_summary_v
AS
SELECT
    x.therapist_id,
    x.therapist_name,
    x.phone_number,
    x.email,
    x.treatment_month_year,
    x.invoice_type,
    SUM(x.total_price) AS total_price,
    SUM(x.discount) AS discount,
    SUM(x.grand_total) AS grand_total,
    SUM(x.amount) AS amount,
    SUM(x.duration) AS duration,
    ROUND(AVG(x.rating), 1) AS rating
FROM (
    SELECT
        t.id AS therapist_id,
        CONCAT(COALESCE(t.first_name,''), ' ', COALESCE(t.last_name,'')) AS therapist_name,
        t.phone_number,
        t.email,
        DATE_FORMAT(i.treatment_date, '%Y-%m') AS treatment_month_year,
        CASE WHEN i.id = LAG(i.id) OVER (ORDER BY i.id) THEN 0 ELSE i.total_price END AS total_price,
        CASE WHEN i.id = LAG(i.id) OVER (ORDER BY i.id) THEN 0 ELSE i.discount END AS discount,
        CASE WHEN i.id = LAG(i.id) OVER (ORDER BY i.id) THEN 0 ELSE i.grand_total END AS grand_total,
        id.amount,
        p.duration,
        p.commission_fee,
        i.invoice_type,
        COALESCE(r.rating, 0) AS rating
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
        DATE_FORMAT(i.treatment_date, '%Y-%m') AS treatment_month_year,
        CASE WHEN i.id = LAG(i.id) OVER (ORDER BY i.id) THEN 0 ELSE i.total_price END AS total_price,
        CASE WHEN i.id = LAG(i.id) OVER (ORDER BY i.id) THEN 0 ELSE i.discount END AS discount,
        CASE WHEN i.id = LAG(i.id) OVER (ORDER BY i.id) THEN 0 ELSE i.grand_total END AS grand_total,
        id.amount,
        p.duration,
        p.commission_fee,
        i.invoice_type,
        0 AS rating
    FROM invoices AS i
    JOIN invoice_details id ON id.invoice_id = i.id
        AND id.is_deleted = 0
        AND id.status = 1
    JOIN users AS c ON LOWER(CONCAT(COALESCE(c.first_name,''), ' ', COALESCE(c.last_name,''))) = LOWER(i.customer_name)
    JOIN users AS t ON LOWER(CONCAT(COALESCE(t.first_name,''), ' ', COALESCE(t.last_name,''))) = LOWER(i.therapist_name)
    JOIN products AS p ON LOWER(p.name) = LOWER(id.title)
    WHERE i.old_data = 'Y'
        AND i.is_deleted = 0
        AND i.status = 1
) x
GROUP BY x.therapist_id, x.therapist_name, x.phone_number, x.email, x.treatment_month_year, x.invoice_type
ORDER BY x.therapist_id, x.therapist_name, x.phone_number, x.email, x.treatment_month_year, x.invoice_type;
