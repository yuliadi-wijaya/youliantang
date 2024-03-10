CREATE OR REPLACE VIEW transaction_revenue_monthly_v
AS
SELECT CONCAT(year(treatment_date),'-', month(treatment_date)) AS treatment_date, COUNT(id) AS invoice_total
	,SUM(total_price) AS price_total
    ,SUM(discount) AS discount_total 
    ,SUM(tax_amount) AS tax_amount_total
    ,SUM(CASE 
    	WHEN invoice_type = 'NC' THEN grand_total
        ELSE 0
     END) AS revenue_nc
    ,SUM(CASE 
    	WHEN invoice_type = 'CK' THEN grand_total
        ELSE 0
     END) AS revenue_nc
    ,SUM(grand_total) as revenue_total
FROM invoices
WHERE old_data = 'N' AND status = 1 AND is_deleted = 0
GROUP BY concat(year(treatment_date),'-', month(treatment_date))
ORDER BY treatment_date ASC;