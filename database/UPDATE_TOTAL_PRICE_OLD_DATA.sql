UPDATE invoices SET old_data = 'Y' WHERE coalesce(old_data,'') = '';

UPDATE invoices AS i
SET total_price = (
        SELECT SUM(amount)
        FROM invoice_details AS id
        WHERE id.invoice_id = i.id
    ),
    discount = 0,
    grand_total = (
        SELECT SUM(amount)
        FROM invoice_details AS id
        WHERE id.invoice_id = i.id
    )
WHERE old_data = 'Y';
