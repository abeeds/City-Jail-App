DELIMITER $$



CREATE OR REPLACE TRIGGER C_ID_CHECK
BEFORE INSERT ON criminal
FOR EACH ROW
BEGIN
    DECLARE temp_id INT;
    SELECT c_id INTO temp_id FROM criminal
    WHERE c_id = NEW.c_id;
    
    IF temp_id IS NOT NULL THEN 
		SELECT MAX(c_id) INTO temp_id FROM criminal;
        SET NEW.c_id = temp_id + 1;
    END IF;
END $$



CREATE OR REPLACE TRIGGER ALIAS_ID_CHECK
BEFORE INSERT ON alias
FOR EACH ROW
BEGIN
    DECLARE temp_id INT;
    SELECT alias_id INTO temp_id FROM alias
    WHERE alias_id = NEW.alias_id;
    
    IF temp_id IS NOT NULL THEN 
		SELECT MAX(alias_id) INTO temp_id FROM alias;
        SET NEW.alias_id = temp_id + 1;
    END IF;
END $$


CREATE OR REPLACE TRIGGER CASE_ID_CHECK
BEFORE INSERT ON crime
FOR EACH ROW
BEGIN
    DECLARE temp_id INT;
    SELECT case_id INTO temp_id FROM crime
    WHERE case_id = NEW.case_id;
    
    IF temp_id IS NOT NULL THEN 
		SELECT MAX(case_id) INTO temp_id FROM crime;
        SET NEW.case_id = temp_id + 1;
    END IF;
END $$


CREATE OR REPLACE TRIGGER P_ID_CHECK
BEFORE INSERT ON prob_officer
FOR EACH ROW
BEGIN
    DECLARE temp_id INT;
    SELECT p_id INTO temp_id FROM prob_officer
    WHERE p_id = NEW.p_id;
    
    IF temp_id IS NOT NULL THEN 
		SELECT MAX(p_id) INTO temp_id FROM prob_officer;
        SET NEW.p_id = temp_id + 1;
    END IF;
END $$


CREATE OR REPLACE TRIGGER SENTENCE_ID_CHECK
BEFORE INSERT ON sentence
FOR EACH ROW
BEGIN
    DECLARE temp_id INT;
    SELECT sentence_id INTO temp_id FROM sentence
    WHERE sentence_id = NEW.sentence_id;
    
    IF temp_id IS NOT NULL THEN 
		SELECT MAX(sentence_id) INTO temp_id FROM sentence;
        SET NEW.sentence_id = temp_id + 1;
    END IF;
END $$


CREATE OR REPLACE TRIGGER CODE_NUM_CHECK
BEFORE INSERT ON crime_code
FOR EACH ROW
BEGIN
    DECLARE temp_id INT;
    SELECT code_num INTO temp_id FROM crime_code
    WHERE code_num = NEW.code_num;
    
    IF temp_id IS NOT NULL THEN 
		SELECT MAX(code_num) INTO temp_id FROM crime_code;
        SET NEW.code_num = temp_id + 1;
    END IF;
END $$


CREATE OR REPLACE TRIGGER CHARGE_ID_CHECK
BEFORE INSERT ON charge
FOR EACH ROW
BEGIN
    DECLARE temp_id INT;
    SELECT charge_id INTO temp_id FROM charge
    WHERE charge_id = NEW.charge_id;
    
    IF temp_id IS NOT NULL THEN 
		SELECT MAX(charge_id) INTO temp_id FROM charge;
        SET NEW.charge_id = temp_id + 1;
    END IF;
END $$

--Search for criminal info by city
CREATE OR REPLACE PROCEDURE searchByCity(city VARCHAR(64))
BEGIN
	SELECT c_last, c_first, c_city, c_state, start_date, end_date
    FROM criminal, sentence
    WHERE criminal.c_id = sentence.c_id
    AND c_city = city;
END$$

--CALL searchByCity('New York');


--Search for criminal info by zipcode
CREATE OR REPLACE PROCEDURE searchByZipCode(zipcode VARCHAR(64))
BEGIN
	SELECT c_last, c_first, c_city, c_state, start_date, end_date
    FROM criminal, sentence
    WHERE criminal.c_id = sentence.c_id
    AND c_zip = zipcode;
END$$

--CALL searchByZipCode('43210')


--Count number of active officers
CREATE OR REPLACE FUNCTION count_officers() RETURNS INT
BEGIN
  RETURN (SELECT COUNT(badge_number)
          FROM officer
          WHERE o_status = 'a');
END$$

--SET @officer_count = count_officers();
--SELECT @officer_count;


--Make a payment
CREATE OR REPLACE PROCEDURE make_payment(chargeid INT, crimeid INT, payment DECIMAL, paydate DATE)
BEGIN
  UPDATE charge
  SET amount_paid = amount_paid + payment, payment_date = paydate
  WHERE charge_id = chargeid
  AND case_id = crimeid;
END$$

--CALL make_payment(2142, 1, 999, '2023-10-15');



DELIMITER ;