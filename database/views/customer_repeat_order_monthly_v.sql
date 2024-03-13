CREATE OR REPLACE VIEW customer_repeat_order_monthly_v
AS
SELECT CONCAT(MONTHNAME(inv.treatment_date), ' ', YEAR(inv.treatment_date)) as treatment_date,
    MONTH(inv.treatment_date) as month_num, 
    YEAR(inv.treatment_date) as year_name,
	COUNT(COALESCE(inv.id, 0)) as repeat_order_total
FROM invoices inv 
	LEFT JOIN users usr ON inv.customer_id = usr.id
WHERE inv.treatment_date > DATE(usr.created_at)
GROUP BY CONCAT(MONTHNAME(inv.treatment_date), ' ', YEAR(inv.treatment_date)), MONTH(inv.treatment_date), YEAR(inv.treatment_date)
ORDER BY inv.treatment_date ASC;