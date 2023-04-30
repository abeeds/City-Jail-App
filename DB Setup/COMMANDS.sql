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