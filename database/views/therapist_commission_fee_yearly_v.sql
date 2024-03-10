CREATE OR REPLACE VIEW therapist_commission_fee_yearly_v
AS
SELECT YEAR(invds.created_at) AS treatment_date, CONCAT(usrs.first_name, ' ', COALESCE(usrs.last_name,'')) AS therapist_name 
	,COUNT(DISTINCT invds.invoice_id) AS invoice_total
	,COUNT(DISTINCT invds.id) AS treatment_total
	,SUM(invds.fee) AS commission_fee_total 
FROM invoice_details invds
	JOIN users usrs ON invds.therapist_id = usrs.id
WHERE invds.status = 1 AND invds.is_deleted = 0
GROUP BY YEAR(invds.created_at), CONCAT(usrs.first_name, ' ', COALESCE(usrs.last_name,''))
ORDER BY YEAR(invds.created_at) ASC, CONCAT(usrs.first_name, ' ', COALESCE(usrs.last_name,'')) ASC;