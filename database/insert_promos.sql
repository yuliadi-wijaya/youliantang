INSERT INTO promos (
    name,
    description,
    discount_type,
    discount_value,
    discount_max_value,
    active_period_start,
    active_period_end,
    is_reuse_voucher,
    status,
    created_at
) VALUES (
    'Percobaan 5%',
    'Percobaan 5%',
    1,
    5,
    5000,
    NOW(),
    DATE_ADD(NOW(), INTERVAL 3 MONTH),
    0,
    1,
    NOW()
);

INSERT INTO promo_vouchers (promo_id, voucher_code)
VALUES
    (2, CONCAT('CB', DATE_FORMAT(NOW(), '%Y%m%d'), LPAD(FLOOR(RAND() * 100000), 5, '0'))),
    (2, CONCAT('CB', DATE_FORMAT(NOW(), '%Y%m%d'), LPAD(FLOOR(RAND() * 100000), 5, '0'))),
    (2, CONCAT('CB', DATE_FORMAT(NOW(), '%Y%m%d'), LPAD(FLOOR(RAND() * 100000), 5, '0')));
