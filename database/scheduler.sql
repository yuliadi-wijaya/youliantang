  CREATE EVENT update_expired_status_daily
  ON SCHEDULE
      EVERY 1 DAY
      STARTS TIMESTAMP(CURDATE(), '00:01:00')
  DO
  BEGIN
    UPDATE customer_members
    SET status = 0
    WHERE expired_date <= NOW() AND status = 1;
  END;

  SET GLOBAL event_scheduler = 1;
