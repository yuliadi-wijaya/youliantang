CREATE OR REPLACE VIEW transaction_commission_fee_monthly_v
AS
SELECT CONCAT(MONTHNAME(created_at), ' ', YEAR(created_at)) as treatment_date, MONTH(created_at) as month_num, YEAR(created_at) as year_num, COUNT(DISTINCT invoice_id) AS invoice_total
	,COUNT(DISTINCT id) AS treatment_total
    ,COUNT(DISTINCT therapist_id) AS therapist_total
	,SUM(fee) AS commission_fee_total 
FROM invoice_details 
WHERE status = 1 AND is_deleted = 0
GROUP BY CONCAT(MONTHNAME(created_at), ' ', YEAR(created_at)), MONTH(created_at), YEAR(created_at)
ORDER BY MONTH(created_at) ASC;