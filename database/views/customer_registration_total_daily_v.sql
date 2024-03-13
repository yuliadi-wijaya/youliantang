CREATE OR REPLACE VIEW customer_registration_total_daily_v
AS
SELECT DATE(created_at) AS regist_date
	,COUNT(id) AS customer_regist_total
FROM customers 
GROUP BY DATE(created_at)
ORDER BY created_at ASC;