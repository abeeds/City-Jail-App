DELIMITER $$



-- Search for criminal info by city
CREATE OR REPLACE PROCEDURE searchByCity(city VARCHAR(64))
BEGIN
	SELECT c_last, c_first, c_city, c_state, start_date, end_date
    FROM criminal, sentence
    WHERE criminal.c_id = sentence.c_id
    AND c_city = city;
END$$



-- CALL searchByCity('New York');


-- Search for criminal info by zipcode
CREATE OR REPLACE PROCEDURE searchByZipCode(zipcode VARCHAR(64))
BEGIN
	SELECT c_last, c_first, c_city, c_state, start_date, end_date
    FROM criminal, sentence
    WHERE criminal.c_id = sentence.c_id
    AND c_zip = zipcode;
END$$

-- CALL searchByZipCode('43210')

-- General search function
CREATE OR REPLACE FUNCTION searchCriminal(crim_name VARCHAR(41), crim_city VARCHAR(64), crim_state VARCHAR(2), )
BEGIN
    RETURN (SELECT * FROM criminal c,
            WHERE CONCAT(c.c_first, ' ', c.c_last) LIKE CONCAT('%', crim_name, '%')
            AND c.c_city LIKE CONCAT('%', crim_city, '%')
            AND c.state LIKE CONCAT('%', crim_state, '%'));
END$$

-- Count number of active officers
CREATE OR REPLACE FUNCTION count_officers() RETURNS INT
BEGIN
  RETURN (SELECT COUNT(badge_number)
          FROM officer
          WHERE o_status = 'a');
END$$

-- SET @officer_count = count_officers();
-- SELECT @officer_count;


--  Make a payment
CREATE OR REPLACE PROCEDURE make_payment(chargeid INT, crimeid INT, payment DECIMAL, paydate DATE)
BEGIN
  UPDATE charge
  SET amount_paid = amount_paid + payment, payment_date = paydate
  WHERE charge_id = chargeid
  AND case_id = crimeid;
END$$

--  CALL make_payment(2142, 1, 999, '2023-10-15');


--  Trigger ensures alias_ids continue incrementing properly
CREATE OR REPLACE TRIGGER properAliasID
BEFORE INSERT ON alias
FOR EACH ROW
BEGIN
    DECLARE max_alias_id INT;
    SELECT MAX(alias_id) INTO max_alias_id FROM alias;
    
    --  if table is empty, alias id = 1
    IF max_alias_id IS NULL THEN
        SET NEW.alias_id = 1;
    --  otherwise, increment by 1 from the highest alias id
    ELSE    
        SET NEW.alias_id = max_alias_id + 1;
    END IF;
END $$
