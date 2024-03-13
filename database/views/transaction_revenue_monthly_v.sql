CREATE OR REPLACE VIEW transaction_revenue_monthly_v
AS
SELECT CONCAT(MONTHNAME(treatment_date), ' ', YEAR(treatment_date)) AS treatment_date, MONTH(treatment_date) as month_num, YEAR(treatment_date) as year_num, COUNT(id) AS invoice_total
	,SUM(total_price) AS price_total
    ,SUM(discount) AS discount_total 
    ,SUM(tax_amount) AS tax_amount_total
    ,SUM(additional_price) AS additional_price
    ,SUM(CASE 
    	WHEN invoice_type = 'NC' THEN grand_total
        ELSE 0
     END) AS revenue_nc
    ,SUM(CASE 
    	WHEN invoice_type = 'CK' THEN grand_total
        ELSE 0
     END) AS revenue_ck
    ,SUM(grand_total) as revenue_total
FROM invoices
WHERE old_data = 'N' AND status = 1 AND is_deleted = 0
GROUP BY CONCAT(MONTHNAME(treatment_date), ' ', YEAR(treatment_date)), MONTH(treatment_date), YEAR(treatment_date)
ORDER BY MONTH(treatment_date) ASC;