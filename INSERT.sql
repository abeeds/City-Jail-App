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