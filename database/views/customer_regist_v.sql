CREATE OR REPLACE VIEW customer_regist_v
AS
SELECT
    CONCAT(COALESCE(u.first_name,''), ' ', COALESCE(u.last_name,'')) AS customer_name,
    u.phone_number,
    u.email,
    u.created_at AS register_date,
    c.place_of_birth,
    c.birth_date,
    c.gender,
    c.address,
    c.emergency_name,
    c.emergency_contact,
    CASE WHEN COALESCE(cm.id,0) = 0 THEN 0 ELSE 1 END AS is_member,
    CASE 
        WHEN c.status = 0 THEN 'Non Active' 
        WHEN c.status = 1 THEN 'Active' 
        ELSE NULL
    END AS customer_status,
    m.name AS member_plan,
    CASE 
        WHEN cm.status = 0 THEN 'Non Active' 
        WHEN cm.status = 1 THEN 'Active' 
        ELSE NULL
    END AS member_status,
    cm.created_at AS start_member,
    cm.expired_date
FROM customers AS c 
JOIN users AS u ON u.id = c.user_id
LEFT JOIN customer_members AS cm ON cm.customer_id = u.id AND cm.is_deleted = 0
LEFT JOIN memberships AS m ON m.id = cm.membership_id
WHERE c.is_deleted = 0