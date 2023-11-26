UPDATE invoices AS i
SET total_price = (
        SELECT SUM(price)
        FROM invoice_details AS id
        WHERE id.invoice_id = i.id
    ),
    discount = 0,
    grand_total = (
        SELECT SUM(price)
        FROM invoice_details AS id
        WHERE id.invoice_id = i.id
    )
WHERE old_data = 'Y';
