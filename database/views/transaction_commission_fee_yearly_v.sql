CREATE OR REPLACE VIEW transaction_commission_fee_yearly_v
AS
SELECT YEAR(created_at) as treatment_date, COUNT(DISTINCT invoice_id) AS invoice_total
	,COUNT(DISTINCT id) AS treatment_total
    ,COUNT(DISTINCT therapist_id) AS therapist_total
	,SUM(fee) AS commission_fee_total 
FROM invoice_details 
WHERE status = 1 AND is_deleted = 0
GROUP BY YEAR(created_at)
ORDER BY YEAR(created_at) ASC;