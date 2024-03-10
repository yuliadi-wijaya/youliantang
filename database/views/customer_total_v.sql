CREATE OR REPLACE VIEW customer_total_v
AS
SELECT CONCAT(YEAR(created_at),'-', MONTH(created_at)) AS regist_date
	,COUNT(id) AS customer_regist_total
FROM customers 
GROUP BY CONCAT(YEAR(created_at),'-', MONTH(created_at))
ORDER BY created_at ASC;