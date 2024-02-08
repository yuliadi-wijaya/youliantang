CREATE OR REPLACE VIEW therapist_total_v
AS
SELECT
CONCAT(COALESCE(u.first_name,''), ' ', COALESCE(u.last_name,'')) AS therapist_name,
u.phone_number,
u.email,
t.ktp,
t.gender,
t.place_of_birth,
t.birth_date,
t.address,
t.rekening_number,
t.emergency_name,
t.emergency_contact,
t.status,
u.created_at AS register_date
FROM therapists AS t
JOIN users AS u ON u.id = t.user_id
WHERE u.is_deleted = 0
