use id20190501_homeconnect;

SET @LandlordEmail1 = "landlord1@homeconnect.com";
SET @LandlordEmail2 = "landlord2@homeconnect.com";
SET @TenantEmail1 = "tenant1@homeconnect.com";
SET @TenantEmail2 = "tenant2@homeconnect.com";
SET @Password = "pass123";

INSERT INTO Users (
    FirstName,
    LastName,
    Email,
    Mobile,
    Password,
    TempPassword,
    FailedAttempts,
    Active,
    DateCreated,
    DateModified
) VALUES 
('James', 'Bond', @LandlordEmail1, '0444888888', SHA1(@Password), SHA1(@Password), 0, 1, NOW(), NOW()),
('Jon', 'Snow', @LandlordEmail2, '0444888888', SHA1(@Password), SHA1(@Password), 0, 1, NOW(), NOW()),
('Arya', 'Stark', @TenantEmail1, '0444999999', SHA1(@Password), SHA1(@Password), 0, 1, NOW(), NOW()),
('Jason', 'Bourne', @TenantEmail2, '0444999999', SHA1(@Password), SHA1(@Password), 0, 1, NOW(), NOW());

SELECT @LandlordId1 := User_ID FROM Users WHERE Email = @LandlordEmail1;
SELECT @LandlordId2 := User_ID FROM Users WHERE Email = @LandlordEmail2;
SELECT @TenantId1 := User_ID FROM Users WHERE Email = @TenantEmail1;
SELECT @TenantId2 := User_ID FROM Users WHERE Email = @TenantEmail2;

INSERT INTO RentedProperties(
    AddressLine1,
    Suburb,
    P_State,
    PostCode
) VALUES
('55 Durrant Street', 'Brighton', 'VIC', 3186),
('111 Abbott Street', 'Sandringham', 'VIC', 3191),
('59 Jasper Road', 'Bentley', 'VIC', 3204);

SELECT @PropertyId1 := Property_ID FROM RentedProperties WHERE PostCode = 3186;
SELECT @PropertyId2 := Property_ID FROM RentedProperties WHERE PostCode = 3191;
SELECT @PropertyId3 := Property_ID FROM RentedProperties WHERE PostCode = 3204;

INSERT INTO Renter (
    Landlord_User_ID,
    Tenant_User_ID,
    Property_ID,
    RentStart,
    RentEnd
) VALUES 
(@LandlordId1, @TenantId1, @PropertyId1, '2018-10-10', null),
(@LandlordId1, @TenantId2, @PropertyId2, '2017-04-12', null),
(@LandlordId2, @LandlordId1, @PropertyId3, '2017-09-10', '2020-10-17');

SELECT @Rent1 := Rent_ID 
    FROM Renter 
    WHERE Landlord_User_ID = @LandlordId1 AND Tenant_User_ID = @TenantId1 AND Property_ID = @PropertyId1;
SELECT @Rent2 := Rent_ID 
    FROM Renter 
    WHERE Landlord_User_ID = @LandlordId1 AND Tenant_User_ID = @TenantId2 AND Property_ID = @PropertyId2;
SELECT @Rent3 := Rent_ID 
    FROM Renter 
    WHERE Landlord_User_ID = @LandlordId2 AND Tenant_User_ID = @LandlordId1 AND Property_ID = @PropertyId3;

INSERT INTO Maintenance (
    Rent_ID,
    Description,
    MaintenanceStart,
    MaintenanceEnd,
    MaintenanceStatus
) VALUES
(@Rent1, 'Please fix my boiler', '2019-02-01', '2019-02-12', 'Completed'),
(@Rent1, 'Please fix my gas', '2019-01-30', '2019-05-04', 'Pending'),
(@Rent2, 'Bathroom door is broken', '2019-04-23', '2019-05-12', 'Pending'),
(@Rent3, 'Please fix my boiler', '2019-01-30', null, 'Pending');

INSERT INTO ChatSession (
    Rent_ID,
    From_User_ID,
    To_User_ID,
    Message,
    MessageTime
) VALUES
(@Rent1, @TenantId1, @LandlordId1, 'Hi', CURRENT_TIMESTAMP()),
(@Rent1, @LandlordId1, @TenantId1, 'Hi, how is everything?', CURRENT_TIMESTAMP()),
(@Rent1, @TenantId1, @LandlordId1, 'We have a schduled maintanance next Monday, is there any chance we can move it?', CURRENT_TIMESTAMP()),
(@Rent1, @LandlordId1, @TenantId1, 'I guess I can, when would you be available?', CURRENT_TIMESTAMP()),
(@Rent1, @TenantId1, @LandlordId1, 'How about next, Friday?', CURRENT_TIMESTAMP()),
(@Rent1, @LandlordId1, @TenantId1, 'That looks good on my calandar, let us move then.', CURRENT_TIMESTAMP()),
(@Rent1, @LandlordId1, @TenantId1, 'done!', CURRENT_TIMESTAMP()),
(@Rent1, @TenantId1, @LandlordId1, 'Thanks, you are a star.', CURRENT_TIMESTAMP());
