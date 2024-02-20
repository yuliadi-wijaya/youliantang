CREATE OR REPLACE VIEW transaction_revenue_monthly_v
AS
SELECT concat(year(treatment_date),'-', month(treatment_date)) as treatment_date, count(id) as invoice_total
	,sum(total_price) as price_total
    ,sum(discount) as discount_total 
    ,sum(tax_amount) as tax_amount_total
    ,sum(grand_total) as revenue_total
FROM invoices
WHERE old_data = 'N' AND status = 1 AND is_deleted = 0
GROUP BY concat(year(treatment_date),'-', month(treatment_date))
ORDER BY treatment_date ASC;