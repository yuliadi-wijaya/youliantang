CREATE OR REPLACE VIEW customer_repeat_order_daily_v
AS
SELECT inv.treatment_date,
	COUNT(COALESCE(inv.id, 0)) as repeat_order_total
FROM invoices inv 
	LEFT JOIN users usr ON inv.customer_id = usr.id
WHERE inv.treatment_date > DATE(usr.created_at)
GROUP BY inv.treatment_date
ORDER BY inv.treatment_date ASC;