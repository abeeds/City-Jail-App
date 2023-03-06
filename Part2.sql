CREATE TABLE officer (
	badge_number INT,
	o_name VARCHAR(40),
	o_precinct INT,
    o_phone_number INT, 
    o_status VARCHAR(8),
PRIMARY KEY (badge_number) );

CREATE TABLE crime(
    case_id INT, 
    classification VARCHAR(40), 
    date_charged DATE, 
    appeal_status VARCHAR(10), 
    hearing_date DATE, 
    appeal_cutoff_date DATE, 
    court_fee INT, 
    charge_status VARCHAR(9),
PRIMARY KEY (case_id) );


CREATE TABLE involved_with (
    badge_number INT, 
    case_id INT,
PRIMARY KEY (badge_number, case_id),
FOREIGN KEY (badge_number) REFERENCES officer(badge_number),
FOREIGN KEY (case_id) REFERENCES crime(case_id)) ;

CREATE TABLE criminal( 
    c_id INT,
    c_name VARCHAR(40),
    c_address VARCHAR(255), 
    c_phone_num INT, 
    c_off_status VARCHAR(3),
    c_prob_status VARCHAR(3),
PRIMARY KEY(c_id) );

CREATE TABLE alias(
    c_id INT, 
    an_alias VARCHAR(40),
PRIMARY KEY(c_id, an_alias),
FOREIGN KEY(c_id) REFERENCES criminal(c_id) );

CREATE TABLE charged_with(
 	c_id INT,
	case_id INT,
   	crime_id INT,
    crime_code VARCHAR(40), 
    charge_count INT,
PRIMARY KEY(c_id, case_id, crime_code),
FOREIGN KEY(c_id) REFERENCES criminal(c_id),
FOREIGN KEY(case_id) REFERENCES crime(case_id) );

CREATE TABLE sentence(
    sentence_id INT, 
    start_date DATE, 
    end_date DATE, 
    num_violations INT, 
    type VARCHAR(40),
PRIMARY KEY (sentence_id) );

CREATE TABLE sentenced(
    c_id INT, 
    sentence_id INT,
PRIMARY KEY(c_id, sentence_id),
FOREIGN KEY(c_id) REFERENCES criminal(c_id),
FOREIGN KEY(sentence_id) REFERENCES sentence(sentence_id) );
     
CREATE TABLE payment_history(
    case_id INT,
    payment_date DATE,
    payment_time TIME, 
    fine_amount INT, 
    amount_paid INT, 
   
PRIMARY KEY (case_id, payment_date, payment_time),
FOREIGN KEY (case_id) REFERENCES crime(case_id) );

CREATE TABLE appeal(
    case_id INT, 
    attempt_num INT, 
    filing_date DATE, 
    appeal_hearing_date DATE, 
    result_status VARCHAR(11),
PRIMARY KEY (case_id, attempt_num),
FOREIGN KEY (case_id) REFERENCES crime(case_id) );

