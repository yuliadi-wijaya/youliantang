CREATE OR REPLACE VIEW customer_registration_total_monthly_v
AS
SELECT CONCAT(MONTHNAME(created_at), ' ', YEAR(created_at)) AS regist_date
	,MONTH(created_at) AS month_num
	,YEAR(created_at) AS year_num
	,COUNT(id) AS customer_regist_total
FROM customers 
GROUP BY CONCAT(MONTHNAME(created_at), ' ', YEAR(created_at)), MONTH(created_at), YEAR(created_at)
ORDER BY created_at ASC;