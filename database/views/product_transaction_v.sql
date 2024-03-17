
CREATE OR REPLACE VIEW product_transaction_v
AS
SELECT prd.name AS treatment_name,
	SUM(prd.duration) AS duration_total,
    COUNT(DISTINCT invd.therapist_id) AS therapist_total,
	COUNT(DISTINCT invd.invoice_id) AS invoice_total,
    COUNT(DISTINCT invd.id) AS treatment_total,
    SUM(invd.amount) AS treatment_price_total,
    SUM(invd.fee) AS therapist_fee_total 
FROM invoice_details invd
	JOIN invoices inv ON invd.invoice_id = inv.id 
	JOIN products prd ON invd.product_id = prd.id 
WHERE inv.status = 1 AND inv.is_deleted = 0 AND old_data = 'N'
GROUP BY prd.name 
ORDER BY COUNT(DISTINCT invd.therapist_id) DESC