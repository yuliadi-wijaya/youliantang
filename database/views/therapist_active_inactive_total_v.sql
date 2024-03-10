CREATE OR REPLACE VIEW therapist_active_inactive_total_v
AS
SELECT SUM(CASE 
                WHEN t.status = 1 THEN 1
                ELSE 0
           END) AS active_status 
       ,SUM(CASE
            	WHEN t.status = 0 THEN 1
            	ELSE 0
           END) AS inactive_status
FROM therapists t 
	JOIN users u ON t.user_id = u.id;
