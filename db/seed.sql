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
('Landlord1', 'HC', @LandlordEmail1, '0444888888', SHA1(@Password), SHA1(@Password), 0, 1, NOW(), NOW()),
('Landlord2', 'HC', @LandlordEmail2, '0444888888', SHA1(@Password), SHA1(@Password), 0, 1, NOW(), NOW()),
('Tenant1', 'HC', @TenantEmail1, '0444999999', SHA1(@Password), SHA1(@Password), 0, 1, NOW(), NOW()),
('Tenant2', 'HC', @TenantEmail2, '0444999999', SHA1(@Password), SHA1(@Password), 0, 1, NOW(), NOW());

SELECT @LandlordId1 := User_ID FROM Users WHERE Email = @LandlordEmail1;
SELECT @LandlordId2 := User_ID FROM Users WHERE Email = @LandlordEmail2;
SELECT @TenantId1 := User_ID FROM Users WHERE Email = @TenantEmail1;
SELECT @TenantId2 := User_ID FROM Users WHERE Email = @TenantEmail2;

INSERT INTO RentedProperties(
    Landlord_User_ID,
    AddressLine1,
    Suburb,
    P_State,
    PostCode
) VALUES
(@LandlordId1, '55 Durrant Street', 'Brighton', 'VIC', 3186),
(@LandlordId1, '111 Abbott Street', 'Sandringham', 'VIC', 3191),
(@LandlordId2, '59 Jasper Road', 'Bentley', 'VIC', 3204);

SELECT @PropertyId1 := Property_ID FROM RentedProperties WHERE PostCode = 3186;
SELECT @PropertyId2 := Property_ID FROM RentedProperties WHERE PostCode = 3191;
SELECT @PropertyId3 := Property_ID FROM RentedProperties WHERE PostCode = 3204;

INSERT INTO Renter (
    Tenants_ID,
    RentedProperty_ID,
    RentStart,
    RentEnd
) VALUES 
(@TenantId1, @PropertyId1, '2018-10-10', null),
(@TenantId2, @PropertyId2, '2017-04-12', null),
(@LandlordId1, @PropertyId3, '2017-09-10', '2020-10-17');

INSERT INTO Maintenance (
    Property_ID,
    Description,
    MaintenanceStart,
    MaintenanceEnd,
    MaintenanceStatus
) VALUES
(@PropertyId1, 'Please fix my boiler', '2019-02-01', '2019-02-12', 'Completed'),
(@PropertyId1, 'Please fix my gas', '2019-01-30', '2019-05-04', 'Pending'),
(@PropertyId2, 'Bathroom door is broken', '2019-04-23', '2019-05-12', 'Pending'),
(@PropertyId3, 'Please fix my boiler', '2019-01-30', null, 'Pending');
