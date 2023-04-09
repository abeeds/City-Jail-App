CREATE TABLE criminal(
    c_id INT,
    c_last VARCHAR(20),
    c_first VARCHAR(20),
    c_address VARCHAR(255),
    c_phone_num INT,
    V_status CHAR(1),
    P_status CHAR(1),
    PRIMARY KEY(c_id));

CREATE TABLE alias(
    alias_id INT,
    c_id INT,
    alias VARCHAR(20),
    PRIMARY KEY (alias_id),
    FOREIGN KEY (c_id) REFERENCES criminal(c_id));

CREATE TABLE crime(
    case_id INT,
    c_id INT,
    classification CHAR(1),
    date_charged DATE,
    appeal_status CHAR(2),
    hearing_date DATE,
    appeal_cutoff_date DATE,
    PRIMARY KEY (case_id),
    FOREIGN KEY (c_id) REFERENCES criminal(c_id));

CREATE TABLE prob_officer(
    p_id INT,
    p_last VARCHAR(20),
    p_first VARCHAR(20),
    p_phone_number INT,
    p_email VARCHAR(30),
    p_status CHAR(1),
    PRIMARY KEY (p_id));

CREATE TABLE sentence(
    sentence_id INT,
    c_id INT,
    p_id INT,
    start_date DATE,
    end_date DATE,
    num_violations INT,
    type CHAR(1),
    PRIMARY KEY (sentence_id),
    FOREIGN KEY (c_id) REFERENCES criminal(c_id),
    FOREIGN KEY (p_id) REFERENCES prob_officer(p_id));

CREATE TABLE officer(
  	badge_number INT,
  	o_last VARCHAR(20),
    o_first VARCHAR(20),
  	o_precinct INT,
    o_phone_number INT,
    o_status CHAR(1),
    PRIMARY KEY (badge_number));

CREATE TABLE crime_officer(
    case_id INT,
    badge_number INT,
    FOREIGN KEY (case_id) REFERENCES crime(case_id),
    FOREIGN KEY (badge_number) REFERENCES officer(badge_number));

CREATE TABLE crime_code(
    code_num INT,
    code_desc VARCHAR(50),
    PRIMARY KEY (code_num));

CREATE TABLE charge(
    charge_id INT,
    case_id INT,
    code_num INT,
    charge_status CHAR(2),
    fine_amount INT,
    court_fee INT,
    amount_paid INT,
    payment_date DATE,
    PRIMARY KEY (charge_id),
    FOREIGN KEY (case_id) REFERENCES crime(case_id),
    FOREIGN KEY (code_num) REFERENCES crime_code(code_num));

CREATE TABLE appeal(
    case_id INT,
    attempt_num INT,
    filing_date DATE,
    appeal_hearing_date DATE,
    result_status CHAR(1),
    PRIMARY KEY (case_id, attempt_num),
    FOREIGN KEY (case_id) REFERENCES crime(case_id));

