-- Get all ethnicities
DROP PROCEDURE IF EXISTS GetEthnicities;
DELIMITER |
CREATE PROCEDURE GetEthnicities ()
	
BEGIN

	SELECT ethnicitycode, ethnicitydescription
    FROM Ethnicity
    ORDER BY ethnicitydescription;

END |
DELIMITER ;

-- Get all performers
DROP PROCEDURE IF EXISTS GetPerformers;
DELIMITER |
CREATE PROCEDURE GetPerformers ()
    
BEGIN

    SELECT performerid, firstname, lastname
    FROM Performer
    ORDER BY lastname, firstname;

END |
DELIMITER ;

-- Get all venues
DROP PROCEDURE IF EXISTS GetVenues;
DELIMITER |
CREATE PROCEDURE GetVenues ()
    
BEGIN

    SELECT venueid, venuename
    FROM Venue
    ORDER BY venuename;

END |
DELIMITER ;

-- Get ethnicity information based on an inputted ethnicity code
DROP PROCEDURE IF EXISTS GetEthnicityByCode;
DELIMITER $$
CREATE PROCEDURE GetEthnicityByCode (
	IN SelectedEthnicityCode		CHAR(2))
    
BEGIN

	SELECT ethnicitycode, ethnicityDescription
    FROM Ethnicity
    WHERE ethnicitycode = SelectedEthnicityCode;

END$$
DELIMITER ;

-- Get all information on a performer from a perforerid
DROP PROCEDURE IF EXISTS GetPerformerInfoBasic;
DELIMITER $$
CREATE PROCEDURE GetPerformerInfoBasic (
	IN SelectedPerformerID		INT)
    
BEGIN

    SELECT p.username, p.firstname, p.middlename, p.lastname, p.dob, p.genderidentity, p.bio, p.websiteurl, p.photolink, p.performerwithdisability, 
           e.ethnicitydescription
	FROM Performer p
	LEFT JOIN Ethnicity e ON p.ethnicitycode = e.ethnicitycode
	WHERE p.performerid = SelectedPerformerID;

END$$


-- Get all information on a performer's bookings from their performerid
DROP PROCEDURE IF EXISTS GetPerformerBookingInfo;
DELIMITER $$
CREATE PROCEDURE GetPerformerBookingInfo (
	IN SelectedPerformerID		INT)
    
BEGIN

    SELECT b.performancedate, TIME_FORMAT(b.starttime, '%l:%i %p') AS starttime, b.ticketpricemin, b.ticketpricemax, b.wascancelled,
           v.venuename, v.address, v.city, v.state, v.venueid, 
           bt.bookingtypedescription 
	FROM Booking b 
    LEFT JOIN Venue v ON b.venueid = v.venueid
    LEFT JOIN BookingType bt ON b.bookingtypecode = bt.bookingtypecode
	WHERE b.performerid = SelectedPerformerID
	AND b.wascancelled = 0
	ORDER BY 
		CASE WHEN b.performancedate >= DATE(CONVERT_TZ(NOW(),'UTC','EST')) THEN b.performancedate ELSE '9999-12-31' END ASC, 
		CASE WHEN b.performancedate <  DATE(CONVERT_TZ(NOW(),'UTC','EST')) THEN b.performancedate ELSE NULL         END DESC, 
		b.starttime;

END$$

-- Get all information on a performer and their bookings from a performerid - no longer in use
-- replaced by GetPerformerInfoBasic (for Performer info) and GetPerformerBookingInfo (for booking info)
DROP PROCEDURE IF EXISTS GetPerformerInfo;
DELIMITER $$
CREATE PROCEDURE GetPerformerInfo (
	IN SelectedPerformerID		INT)
    
BEGIN

    SELECT p.username, p.firstname, p.middlename, p.lastname, p.dob, p.genderidentity, p.bio, p.websiteurl, p.photolink, p.performerwithdisability, 
           b.performancedate, TIME_FORMAT(b.starttime, '%l:%i %p') AS starttime, b.ticketpricemin, b.ticketpricemax, b.wascancelled,
           v.venuename, v.address, v.city, v.state, v.venueid,
           e.ethnicitydescription, 
           bt.bookingtypedescription 
	FROM Performer p
    LEFT JOIN Booking b ON p.performerid = b.performerid
    LEFT JOIN Venue v ON b.venueid = v.venueid
	LEFT JOIN Ethnicity e ON p.ethnicitycode = e.ethnicitycode
    LEFT JOIN BookingType bt ON b.bookingtypecode = bt.bookingtypecode
	WHERE p.performerid = SelectedPerformerID
	AND b.wascancelled = 0
	ORDER BY 
		CASE WHEN b.performancedate >= DATE(CONVERT_TZ(NOW(),'UTC','EST')) THEN b.performancedate ELSE '9999-12-31' END ASC, 
		CASE WHEN b.performancedate <  DATE(CONVERT_TZ(NOW(),'UTC','EST')) THEN b.performancedate ELSE NULL         END DESC, 
		b.starttime;

END$$


-- Get all information on a venue from its venueid
DROP PROCEDURE IF EXISTS GetVenueInfo;
DELIMITER $$
CREATE PROCEDURE GetVenueInfoBasic (
    IN SelectedVenueID      INT)
    
BEGIN

	SELECT v.venuename, v.venuedescription, v.capacity, v.foundingyear, v.websiteurl, v.photolink, v.phonenumber, v.address, v.city, v.state, v.zip, v.twodrinkminimum, v.twoitemminimum
    FROM Venue v 
    WHERE v.venueid = SelectedVenueID

END$$

--get all booking counts by gender using a venueid
DELIMITER $$
CREATE DEFINER=`bamfoo`@`%` PROCEDURE `GetVenueGenderInfo`(
    IN SelectedVenueID      INT)
BEGIN

	DECLARE TotalCount INT;
	DECLARE FemaleCount INT;
    DECLARE MaleCount INT;
    DECLARE NonBinaryCount INT;
    
    SELECT COUNT(*) AS TotalBookings
    INTO TotalCount
	FROM Booking b
	INNER JOIN Performer p ON b.performerid = p.performerid
	WHERE b.wascancelled != 1
	AND b.venueid = SelectedVenueID;
    
    SELECT COUNT(*) AS TotalBookings
    INTO FemaleCount
	FROM Booking b
	INNER JOIN Performer p ON b.performerid = p.performerid
	WHERE b.wascancelled != 1
	AND b.venueid = SelectedVenueID
	AND p.genderidentity = 'F';
    
	SELECT COUNT(*) AS TotalBookings
    INTO MaleCount
	FROM Booking b
	INNER JOIN Performer p ON b.performerid = p.performerid
	WHERE b.wascancelled != 1
	AND b.venueid = SelectedVenueID
	AND p.genderidentity = 'M';
    
    SELECT COUNT(*) AS TotalBookings
    INTO NonBinaryCount
	FROM Booking b
	INNER JOIN Performer p ON b.performerid = p.performerid
	WHERE b.wascancelled != 1
	AND b.venueid = SelectedVenueID
	AND p.genderidentity = 'N';
    
    SELECT TotalCount, MaleCount, FemaleCount, NonBinaryCount;

END$$
DELIMITER ;

-- Get all bookings for a venue from a venue id
DROP PROCEDURE IF EXISTS GetVenueBookingInfo;
DELIMITER $$
CREATE PROCEDURE GetVenueBookingInfo (
    IN SelectedVenueID      INT)
    
BEGIN

    SELECT b.performancedate, TIME_FORMAT(b.starttime, '%l:%i %p') AS starttime, b.ticketpricemin, b.ticketpricemax, b.wascancelled,
           p.firstname, p.middlename, p.lastname, 
           bt.bookingtypedescription, p.performerid
    FROM Booking b 
    LEFT JOIN Performer p ON b.performerid = p.performerid
    LEFT JOIN BookingType bt ON b.bookingtypecode = bt.bookingtypecode
    WHERE b.venueid = SelectedVenueID
	AND b.wascancelled = 0
    ORDER BY 
		CASE WHEN b.performancedate >= DATE(CONVERT_TZ(NOW(),'UTC','EST')) THEN b.performancedate ELSE '9999-12-31' END ASC, 
		CASE WHEN b.performancedate <  DATE(CONVERT_TZ(NOW(),'UTC','EST')) THEN b.performancedate ELSE NULL         END DESC,
		b.starttime,
        CASE 
			WHEN b.bookingtypecode='OPEN' THEN 1 
			WHEN b.bookingtypecode='MIDD' THEN 2 
            WHEN b.bookingtypecode='HEAD' THEN 3 
		END ASC;
END$$        
    


-- Get all information on a venue and its bookings from a venue id - no longer in use
-- replaced by GetVenueInfoBasic (for venue info) and GetVenueBookingInfo (for booking info)
DROP PROCEDURE IF EXISTS GetVenueInfo;
DELIMITER $$
CREATE PROCEDURE GetVenueInfo (
    IN SelectedVenueID      INT)
    
BEGIN

    SELECT v.venuename, v.venuedescription, v.capacity, v.foundingyear, v.websiteurl, v.photolink, v.phonenumber, v.address, v.city, v.state, v.zip, v.twodrinkminimum, v.twoitemminimum, 
           b.performancedate, TIME_FORMAT(b.starttime, '%l:%i %p') AS starttime, b.ticketpricemin, b.ticketpricemax, b.wascancelled,
           p.firstname, p.middlename, p.lastname, 
           bt.bookingtypedescription, p.performerid
    FROM Venue v 
    LEFT JOIN Booking b ON v.venueid = b.venueid
    LEFT JOIN Performer p ON b.performerid = p.performerid
    LEFT JOIN BookingType bt ON b.bookingtypecode = bt.bookingtypecode
    WHERE v.venueid = SelectedVenueID
	AND b.wascancelled = 0
    ORDER BY 
		CASE WHEN b.performancedate >= DATE(CONVERT_TZ(NOW(),'UTC','EST')) THEN b.performancedate ELSE '9999-12-31' END ASC, 
		CASE WHEN b.performancedate <  DATE(CONVERT_TZ(NOW(),'UTC','EST')) THEN b.performancedate ELSE NULL         END DESC,
		b.starttime,
        CASE 
			WHEN b.bookingtypecode='OPEN' THEN 1 
			WHEN b.bookingtypecode='MIDD' THEN 2 
            WHEN b.bookingtypecode='HEAD' THEN 3 
		END ASC;

END$$

-- Find a username if it exists
DROP PROCEDURE IF EXISTS CheckUsername;
DELIMITER $$
CREATE PROCEDURE CheckUsername (
    IN UN		CHAR(50))
    
BEGIN

	SELECT COUNT(*) AS uncount 
	FROM Performer 
	WHERE username = UN;

END$$
DELIMITER ;

-- Add a new performer to the database
DROP PROCEDURE IF EXISTS CreatePerformer;
DELIMITER $$
CREATE PROCEDURE CreatePerformer (
    IN NewFirstName			VARCHAR(50),
    IN NewMiddleName		VARCHAR(50),
    IN NewLastName			VARCHAR(50),
    IN NewDob				DATE,
    IN NewGenderIdentity	CHAR(1),
    IN NewEthnicityCode     CHAR(2),
    IN NewBio				VARCHAR(2000),
    IN NewWebsiteUrl		VARCHAR(300),
    IN NewPhotoLink			VARCHAR(300),
    IN NewPerformerWithDisability	BOOLEAN,
    IN NewCreatedDate		DATETIME,
    IN NewCreatedBy			VARCHAR(50),
    IN NewLastModifiedDate	DATETIME,
    IN NewLastModifiedBy	VARCHAR(50))
    
BEGIN

	INSERT INTO Performer (username, firstname, middlename, lastname, dob, genderidentity, ethnicitycode, bio, websiteurl, photolink, performerwithdisability, createddate, createdby, lastmodifieddate, lastmodifiedby)
    VALUES (LOWER(CONCAT(NewFirstName,NewLastName)), NewFirstName, NewMiddleName, NewLastName, NewDob, NewGenderIdentity, NewEthnicityCode, NewBio, NewWebsiteUrl, NewPhotoLink, NewPerformerWithDisability,
    NewCreatedDate, NewCreatedBy,NewLastModifiedDate, NewLastModifiedBy);

END$$
DELIMITER ;

-- Add a new performance to the database
DROP PROCEDURE IF EXISTS CreatePerformance;
DELIMITER $$
CREATE PROCEDURE CreatePerformance (
    IN NewVenueID           INT,
    IN NewPerformerID	    INT,
    IN NewPerformanceDate   DATE,
    IN NewStartTime         TIME,
    IN NewBookingTypeCode   CHAR(4),
    IN NewTicketPriceMin    DECIMAL(6,2),
    IN NewTicketPriceMax    DECIMAL(6,2),
    IN NewWasCancelled      BOOLEAN,
    IN NewCreatedDate       DATETIME,
    IN NewCreatedBy         VARCHAR(50),
    IN NewLastModifiedDate  DATETIME,
    IN NewLastModifiedBy    VARCHAR(50))    
BEGIN

    INSERT INTO Booking (venueid, performerid, performancedate, starttime, bookingtypecode, ticketpricemin, ticketpricemax, wascancelled, createddate, createdby, lastmodifieddate, lastmodifiedby)
    VALUES (NewVenueID, NewPerformerID, NewPerformanceDate, NewStartTime, NewBookingTypeCode, NewTicketPriceMin, NewTicketPriceMax, NewWasCancelled, NewCreatedDate, NewCreatedBy, NewLastModifiedDate, NewLastModifiedBy); 

END$$
DELIMITER ;

-- Verify Login
DROP PROCEDURE IF EXISTS VerifyLogin;
DELIMITER |
CREATE PROCEDURE VerifyLogin(
	IN VerifyUsername		VARCHAR(50),
    IN VerifyPassword		CHAR(60))
	
BEGIN

	SELECT EXISTS(
         SELECT *
         FROM Users
         WHERE username = VerifyUsername AND password = VerifyPassword) AS Verify;

END |
DELIMITER ;


