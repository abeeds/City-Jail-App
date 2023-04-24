-- Guest user for users who are not logged into the website
CREATE USER 'guest'@'localhost' IDENTIFIED BY 'guest';
GRANT SELECT ON cityjail.criminal TO 'guest'@'localhost';
GRANT SELECT ON cityjail.charge TO 'guest'@'localhost';
GRANT SELECT ON cityjail.sentence TO 'guest'@'localhost';
GRANT SELECT ON cityjail.appeal TO 'guest'@'localhost';
GRANT SELECT ON cityjail.crime TO 'guest'@'localhost';


