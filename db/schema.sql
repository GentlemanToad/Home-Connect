DROP DATABASE IF EXISTS id20190501_homeconnect;
CREATE SCHEMA id20190501_homeconnect DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
use id20190501_homeconnect;

CREATE TABLE Users (
    User_ID INT NOT NULL AUTO_INCREMENT,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    Mobile INT NOT NULL,
    Password VARCHAR(50) NOT NULL,
    TempPassword VARCHAR(50) NULL,
    FailedAttempts TINYINT NOT NULL,
    Active BIT NOT NULL,
    DateCreated DATE NOT NULL,
    DateModified DATE NULL,
    PRIMARY KEY (User_ID)
);

CREATE TABLE RentedProperties (
    Property_ID INT NOT NULL AUTO_INCREMENT,
    Landlord_User_ID INT NOT NULL,
    AddressLine1 VARCHAR(100) NOT NULL,
    AddressLine2 VARCHAR(100) NULL,
    Suburb VARCHAR(100) NOT NULL,
    P_State ENUM('NSW', 'WA', 'SA', 'QLD', 'VIC', 'TAS') NOT NULL,
    PostCode INT NOT NULL,
    PRIMARY KEY (Property_ID),
    FOREIGN KEY (Landlord_User_ID)
        REFERENCES Users (User_ID)
);

CREATE TABLE Renter (
    Rent_ID INT NOT NULL AUTO_INCREMENT,
    Tenants_ID INT NOT NULL,
    RentedProperty_ID INT NOT NULL,
    RentStart DATE NOT NULL,
    RentEnd DATE NULL,
    PRIMARY KEY (Rent_ID),
    FOREIGN KEY (Tenants_ID)
        REFERENCES Users (User_ID),
    FOREIGN KEY (RentedProperty_ID)
        REFERENCES RentedProperties (Property_ID)
);

CREATE TABLE Files (
    FileID INT NOT NULL AUTO_INCREMENT,
    Owner_User_ID INT NOT NULL,
    MimeType VARCHAR(100) NOT NULL,
    FileName VARCHAR(100) NOT NULL,
    FilePath VARCHAR(250) NOT NULL,
    UploadedOn DATETIME NOT NULL,
    PRIMARY KEY (FileID),
    FOREIGN KEY (Owner_User_ID)
        REFERENCES Users (User_ID)
);

CREATE TABLE FileShares (
    FileShare_ID INT NOT NULL AUTO_INCREMENT,
    FileID INT NOT NULL,
    SharedWith_User_ID INT NOT NULL,
    AccessLevel ENUM('Read', 'Comment') NOT NULL,
    SharedOn DATETIME NOT NULL,
    PRIMARY KEY (FileShare_ID),
    FOREIGN KEY (FileID)
        REFERENCES Files (FileID),
    FOREIGN KEY (SharedWith_User_ID)
        REFERENCES Users (User_ID)
);

CREATE TABLE Maintenance (
    Maintenance_ID INT NOT NULL AUTO_INCREMENT,
    Status VARCHAR(20) NOT NULL,
    Catagory VARCHAR(50) NOT NULL,
    Description TEXT NOT NULL,
    PRIMARY KEY (Maintenance_ID)
);

CREATE TABLE MaintenanceRecords (
    MaintenanceRecord_ID INT NOT NULL AUTO_INCREMENT,
    M_Property_ID INT NOT NULL,
    M_Maintenance_ID INT NOT NULL,
    MaintenanceStart DATETIME NOT NULL,
    MaintenanceEnd DATETIME NULL,
    PRIMARY KEY (MaintenanceRecord_ID),
    FOREIGN KEY (M_Property_ID)
        REFERENCES RentedProperties (Property_ID),
    FOREIGN KEY (M_Maintenance_ID)
        REFERENCES Maintenance (Maintenance_ID)
);

CREATE TABLE ChatSession (
    Chat_ID INT NOT NULL AUTO_INCREMENT,
    UserOne_ID INT NOT NULL,
    UserTwo_ID INT NOT NULL,
    Messages TEXT NOT NULL,
    MessageTime DATETIME NOT NULL,
    PRIMARY KEY (Chat_ID),
    FOREIGN KEY (UserOne_ID)
        REFERENCES Users (User_ID),
    FOREIGN KEY (UserTwo_ID)
        REFERENCES Users (User_ID)
);