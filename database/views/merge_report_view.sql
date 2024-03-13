CREATE OR REPLACE VIEW customer_registration_total_daily_v
AS
SELECT DATE(created_at) AS regist_date
	,COUNT(id) AS customer_regist_total
FROM customers 
GROUP BY DATE(created_at)
ORDER BY created_at ASC;
CREATE OR REPLACE VIEW customer_registration_total_monthly_v
AS
SELECT CONCAT(MONTHNAME(created_at), ' ', YEAR(created_at)) AS regist_date
	,MONTH(created_at) AS month_num
	,YEAR(created_at) AS year_num
	,COUNT(id) AS customer_regist_total
FROM customers 
GROUP BY CONCAT(MONTHNAME(created_at), ' ', YEAR(created_at)), MONTH(created_at), YEAR(created_at)
ORDER BY created_at ASC;
CREATE OR REPLACE VIEW customer_registration_total_yearly_v
AS
SELECT YEAR(created_at) AS regist_date
	,COUNT(id) AS customer_regist_total
FROM customers 
GROUP BY YEAR(created_at)
ORDER BY created_at ASC;
CREATE OR REPLACE VIEW customer_repeat_order_daily_v
AS
SELECT inv.treatment_date,
	COUNT(COALESCE(inv.id, 0)) as repeat_order_total
FROM invoices inv 
	LEFT JOIN users usr ON inv.customer_id = usr.id
WHERE inv.treatment_date > DATE(usr.created_at)
GROUP BY inv.treatment_date
ORDER BY inv.treatment_date ASC;
CREATE OR REPLACE VIEW customer_repeat_order_monthly_v
AS
SELECT CONCAT(MONTHNAME(inv.treatment_date), ' ', YEAR(inv.treatment_date)) as treatment_date,
    MONTH(inv.treatment_date) as month_num, 
    YEAR(inv.treatment_date) as year_name,
	COUNT(COALESCE(inv.id, 0)) as repeat_order_total
FROM invoices inv 
	LEFT JOIN users usr ON inv.customer_id = usr.id
WHERE inv.treatment_date > DATE(usr.created_at)
GROUP BY CONCAT(MONTHNAME(inv.treatment_date), ' ', YEAR(inv.treatment_date)), MONTH(inv.treatment_date), YEAR(inv.treatment_date)
ORDER BY inv.treatment_date ASC;
CREATE OR REPLACE VIEW customer_repeat_order_yearly_v
AS
SELECT YEAR(inv.treatment_date) as treatment_date,
	COUNT(COALESCE(inv.id, 0)) as repeat_order_total
FROM invoices inv 
	LEFT JOIN users usr ON inv.customer_id = usr.id
WHERE inv.treatment_date > DATE(usr.created_at)
GROUP BY YEAR(inv.treatment_date)
ORDER BY inv.treatment_date ASC;
CREATE OR REPLACE VIEW therapist_commission_fee_daily_v
AS
SELECT date(invds.created_at) AS treatment_date, CONCAT(usrs.first_name, ' ', COALESCE(usrs.last_name,'')) AS therapist_name 
	,COUNT(DISTINCT invds.invoice_id) AS invoice_total
	,COUNT(DISTINCT invds.id) AS treatment_total
	,SUM(invds.fee) AS commission_fee_total 
FROM invoice_details invds
	JOIN users usrs ON invds.therapist_id = usrs.id
WHERE invds.status = 1 AND invds.is_deleted = 0
GROUP BY date(invds.created_at), CONCAT(usrs.first_name, ' ', COALESCE(usrs.last_name,''))
ORDER BY date(invds.created_at) ASC, CONCAT(usrs.first_name, ' ', COALESCE(usrs.last_name,'')) ASC;
CREATE OR REPLACE VIEW therapist_commission_fee_monthly_v
AS
SELECT CONCAT(MONTHNAME(invds.created_at), ' ', YEAR(invds.created_at)) AS treatment_date, MONTH(invds.created_at) AS month_num, YEAR(invds.created_at) AS year_num, CONCAT(usrs.first_name, ' ', COALESCE(usrs.last_name,'')) AS therapist_name 
	,COUNT(DISTINCT invds.invoice_id) AS invoice_total
	,COUNT(DISTINCT invds.id) AS treatment_total
	,SUM(invds.fee) AS commission_fee_total 
FROM invoice_details invds
	JOIN users usrs ON invds.therapist_id = usrs.id
WHERE invds.status = 1 AND invds.is_deleted = 0
GROUP BY CONCAT(MONTHNAME(invds.created_at), ' ', YEAR(invds.created_at)), MONTH(invds.created_at), YEAR(invds.created_at), CONCAT(usrs.first_name, ' ', COALESCE(usrs.last_name,''))
ORDER BY MONTH(invds.created_at) ASC, CONCAT(usrs.first_name, ' ', COALESCE(usrs.last_name,'')) ASC;
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
CREATE OR REPLACE VIEW therapist_review_v
AS
SELECT CONCAT(usr.first_name, ' ', COALESCE(usr.last_name, '')) AS therapist_name 
	,COUNT(ids.id) AS treatment_total
    ,COUNT(rws.id) AS reviewer_total
    ,SUM(COALESCE(rws.rating, 0)) AS rating_total
    ,COALESCE(ROUND(SUM(COALESCE(rws.rating, 0))/COUNT(rws.id), 2), 0) AS rating_average
FROM invoice_details ids 
    JOIN users usr on ids.therapist_id = usr.id 
    LEFT JOIN reviews rws on ids.id = rws.invoice_detail_id
GROUP BY CONCAT(usr.first_name, ' ', COALESCE(usr.last_name, ''));
CREATE OR REPLACE VIEW transaction_commission_fee_daily_v
AS
SELECT date(created_at) as treatment_date, COUNT(DISTINCT invoice_id) AS invoice_total
	,COUNT(DISTINCT id) AS treatment_total
    ,COUNT(DISTINCT therapist_id) AS therapist_total
	,SUM(fee) AS commission_fee_total 
FROM invoice_details 
WHERE status = 1 AND is_deleted = 0
GROUP BY date(created_at)
ORDER BY date(created_at) ASC;
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
CREATE OR REPLACE VIEW transaction_revenue_daily_v
AS
SELECT treatment_date AS treatment_date, COUNT(id) AS invoice_total
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
GROUP BY treatment_date
ORDER BY treatment_date ASC;
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
CREATE OR REPLACE VIEW transaction_revenue_yearly_v
AS
SELECT YEAR(treatment_date) AS treatment_date, COUNT(id) AS invoice_total
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
GROUP BY YEAR(treatment_date)
ORDER BY treatment_date ASC;



