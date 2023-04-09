INSERT INTO criminal 
    (c_id, c_last, c_first, c_street, c_city, c_state, c_zip, c_phone_num, V_status, P_status)
VALUES 
    (1, 'Smith', 'John', '123 Main St', 'New York', 'NY', 12345, 123456789, 'y', 'n'),
    (2, 'Johnson', 'Edward', '456 Oak St', 'Flushing', 'NY', 15485, 234567890, 'n', 'y'),
    (3, 'Leonard', 'Mike', '789 Maple Ave', 'Jamaica', 'NY', 12923, 345678901, 'y', 'y'),
    (4, 'Gibson', 'Carlos', '321 Elm St', 'Astoria', 'NY', 98765, 456789012, 'n', 'n'),
    (5, 'Kim', 'Jeremy', '654 Pine St', 'Newark', 'NJ', 43210, 567890123, 'y', 'y'),
    (6, 'Joseph', 'David', '987 Cedar Blvd', 'Trenton', 'NJ', 56789, 678901234, 'n', 'y'),
    (7, 'Wilson', 'Gary', '246 Walnut Ave', 'Philadelphia', 'PA', 75421, 789012345, 'y', 'n'),
    (8, 'Doe', 'Anthony', '135 Oak St', 'Pittsburgh', 'PA', 23532, 890123456, 'n', 'n'),
    (9, 'Nelson', 'Mike', '864 Elm St', 'Orlando', 'FL', 91293, 901234567, 'y', 'y'),
    (10, 'Martin', 'Andy', '123 Pine St', 'Miami', 'FL', 33542, 789012345, 'n', 'y');

INSERT INTO alias
    (alias_id, c_id, alias)
VALUES 
    (1, 1, "Clown"),
    (2, 1, "Joker"), 
    (3, 2, "Donkey"),
    (4, 3, "Shrek"),
    (5, 4, "Gold"),
    (6, 5, "Silver"),
    (7, 7, "Big Guy"),
    (8, 8, "Chicken Little"),
    (9, 8, "Elmo"),
    (10, 10, "Cookie Monster");


-- appeal status:
-- ia: in appeal
-- ca: can appeal
--  c: closed
INSERT INTO crime 
    (case_id, c_id, classification, date_charged, 
    appeal_status, hearing_date, appeal_cutoff_date)
VALUES 
    (1, 1, 'o', '1990-06-15', 'ia', '1990-09-01', '1990-09-15'),
    (2, 2, 'f', '1992-11-21', 'ca', '1993-02-01', '1993-02-15'),
    (3, 3, 'm', '1995-04-02', 'c', '1995-05-15', '1995-05-31'),
    (4, 4, 'o', '1997-09-12', 'ia', '1997-12-01', '1997-12-15'),
    (5, 5, 'm', '2000-02-24', 'c', '2000-04-01', '2000-04-15'),
    (6, 6, 'f', '2003-07-05', 'ca', '2003-09-01', '2003-09-15'),
    (7, 7, 'o', '2006-12-09', 'ia', '2007-03-01', '2007-03-15'),
    (8, 8, 'f', '2009-05-22', 'c', '2009-07-01', '2009-07-15'),
    (9, 9, 'm', '2012-10-04', 'ca', '2013-01-01', '2013-01-15'),
    (10, 10, 'o', '2015-03-18', 'ia', '2015-06-01', '2015-06-15');


-- p_status:
-- i: inactive
-- a: active
INSERT INTO prob_officer
    (p_id, p_last, p_first, p_phone_number, p_street, p_city, p_state, p_zip, p_email, p_status)
VALUES 
    (1, 'Johnson', 'David', 541789623, '123 Main St', 'New York', 'NY', 10001, 'david.johnson@gmail.com', 'a'),
    (2, 'Lee', 'Karen', 789123456, '456 Elm St', 'Philadelphia', 'PA', 19102, 'karen.lee@gmail.com', 'i'),
    (3, 'Garcia', 'Luis', 302456789, '789 Oak Ave', 'Miami', 'FL', 33131, 'luis.garcia@gmail.com', 'a'),
    (4, 'Nguyen', 'Anna', 654321987, '567 Pine St', 'New York', 'NY', 10005, 'anna.nguyen@gmail.com', 'i'),
    (5, 'Wang', 'Kevin', 987654321, '890 Maple Ave', 'Philadelphia', 'PA', 19103, 'kevin.wang@gmail.com', 'a'),
    (6, 'Gonzalez', 'Maria', 123456789, '123 Elm St', 'Miami', 'FL', 33133, 'maria.gonzalez@gmail.com', 'i'),
    (7, 'Adams', 'John', 987654321, '456 Oak St', 'New York', 'NY', 10010, 'john.smith@gmail.com', 'a'),
    (8, 'Jones', 'Emma', 123456789, '789 Pine St', 'Philadelphia', 'PA', 19104, 'emma.jones@gmail.com', 'i'),
    (9, 'Washington', 'George', 456789123, '234 Maple Ave', 'Miami', 'FL', 33134, 'michael.brown@gmail.com', 'a'),
    (10, 'Davis', 'Sarah', 789123456, '567 Elm St', 'New York', 'NY', 10020, 'sarah.davis@gmail.com', 'i');

