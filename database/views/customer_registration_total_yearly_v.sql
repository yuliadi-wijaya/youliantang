CREATE OR REPLACE VIEW customer_registration_total_yearly_v
AS
SELECT YEAR(created_at) AS regist_date
	,COUNT(id) AS customer_regist_total
FROM customers 
GROUP BY YEAR(created_at)
ORDER BY created_at ASC;