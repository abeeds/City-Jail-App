DELIMITER $$

--Search for criminal info by city
CREATE OR REPLACE PROCEDURE searchByCity(city VARCHAR(64))
BEGIN
	SELECT c_last, c_first, c_city, c_state, start_date, end_date
    FROM criminal, sentence
    WHERE criminal.c_id = sentence.c_id
    AND c_city = city;
END$$


--Search for criminal info by zipcode
CREATE OR REPLACE PROCEDURE searchByZipCode(zipcode VARCHAR(64))
BEGIN
	SELECT c_last, c_first, c_city, c_state, start_date, end_date
    FROM criminal, sentence
    WHERE criminal.c_id = sentence.c_id
    AND c_zip = zipcode;
END$$

--Count number of active officers
CREATE OR REPLACE FUNCTION count_officers() RETURNS INT
BEGIN
  RETURN (SELECT COUNT (badge_number)
          FROM officer
          WHERE o_status = 'a');
END$$

--Make a payment
CREATE OR REPLACE PROCEDURE make_payment(crimeid INT, chargeid INT, payment DECIMAL, paydate DATE)
BEGIN
  UPDATE charge
  SET amount_paid = amount_paid + payment, payment_date = paydate
  WHERE case_id = crimeid
  AND charge_id = chargeid;
END$$
