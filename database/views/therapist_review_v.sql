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
GROUP BY ids.therapist_id
ORDER BY COUNT(ids.id) DESC;