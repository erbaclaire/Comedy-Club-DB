USE comedy;

SET foreign_key_checks = 0;

-- These DROP statements DROP all of the tables in the database
DROP TABLE IF EXISTS Booking;
DROP TABLE IF EXISTS Performer;
DROP TABLE IF EXISTS Venue;
DROP TABLE IF EXISTS BookingType;
DROP TABLE IF EXISTS Ethnicity;


-- These CREATE statements CREATE all of the tables in the database
CREATE TABLE Performer(
performerid INT PRIMARY KEY AUTO_INCREMENT,
username VARCHAR(100) UNIQUE,
firstname VARCHAR(50),
middlename VARCHAR(50),
lastname VARCHAR(50),
dob DATE,
genderidentity CHAR(1),
ethnicitycode CHAR(2),
bio VARCHAR(2000),
websiteurl VARCHAR(300),
photolink VARCHAR(300),
performerwithdisability BOOLEAN,
createddate DATETIME,
createdby VARCHAR(50),
lastmodifieddate DATETIME,
lastmodifiedby VARCHAR(50),
FOREIGN KEY (ethnicitycode) REFERENCES Ethnicity(ethnicitycode) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE Venue(
venueid INT PRIMARY KEY AUTO_INCREMENT,
venuename VARCHAR(150),
venuedescription VARCHAR(2000),
capacity INT,
foundingyear INT,
websiteurl VARCHAR(100),
photolink VARCHAR(300),
phonenumber VARCHAR(15),
address VARCHAR(150),
city VARCHAR(100),
state CHAR(2),
zip CHAR(5),
twodrinkminimum BOOLEAN,
twoitemminimum BOOLEAN,
handicapaccessible BOOLEAN,
createddate DATETIME,
createdby VARCHAR(50),
lastmodifieddate DATETIME,
lastmodifiedby VARCHAR(50)
);

CREATE TABLE Booking(
bookingid INT PRIMARY KEY AUTO_INCREMENT,
venueid INT,
performerid INT,
performancedate DATE,
starttime TIME,
bookingtypecode CHAR(4),
ticketpricemin DECIMAL(6,2),
ticketpricemax DECIMAL(6,2),
wascancelled BOOLEAN,
createddate DATETIME,
createdby VARCHAR(50),
lastmodifieddate DATETIME,
lastmodifiedby VARCHAR(50),
FOREIGN KEY (venueid) REFERENCES Venue(venueid) ON UPDATE CASCADE ON DELETE SET NULL,
FOREIGN KEY (performerid) REFERENCES Performer(performerid) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN KEY (bookingtypecode) REFERENCES BookingType(bookingtypecode) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE BookingType(
bookingtypecode CHAR(4) PRIMARY KEY,
bookingtypedescription VARCHAR(50)
);

CREATE TABLE Ethnicity(
ethnicitycode CHAR(2) PRIMARY KEY,
ethnicitydescription varchar(50)
);

-- These INSERT statements INSERT data into all of the code tables in the database
INSERT INTO BookingType
VALUES
('OPEN',	'Opener'),
('MIDD',	'Middle'),
('HEAD',	'Headliner');

INSERT INTO Ethnicity
VALUES
('AI',	'American Indian or Alaska Native'),
('AS',	'Asian'),
('BL',	'Black or African American'),
('HL',	'Hispanic/Latino'),
('NH',	'Native Hawaiian or Other Pacific Islander'),
('WH',	'White');

SET foreign_key_checks = 0;


CREATE TABLE Users(
username VARCHAR(50) PRIMARY KEY,
password CHAR(60)
);
