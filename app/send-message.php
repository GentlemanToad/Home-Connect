<?php
    require_once "config.inc.php";
    require_once "common.inc.php";
    require_once "check_login.php";

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST["message"]) || !$_POST["message"]){
        echo "Invalid request";
        exit;
    }

    $conn = Database::getInstance();
    $userId = GetLoggedInUserId();
    $query = "
        SELECT 
            IF(Tenant_User_ID = :UserId, Landlord_User_ID, Tenant_User_ID) OtherUserId
        FROM Renter
        WHERE 
            (Landlord_User_ID = :UserId OR Tenant_User_ID = :UserId) AND 
            Rent_ID = :RentId";
    $stmt = $conn->prepare($query);
    $stmt->bindPARAM(":UserId", $userId, PDO::PARAM_INT);
    $stmt->bindPARAM(":RentId", $_POST["rentId"], PDO::PARAM_INT);
    $stmt->execute();
    $renter = $stmt->fetchAll(PDO::FETCH_OBJ);

    if($renter && count($renter) > 0){
        $query = "
            INSERT INTO ChatSession (
                Rent_ID,
                From_User_ID,
                To_User_ID,
                Message,
                MessageTime) 
            VALUES (
                :RentId,
                :FromUserId,
                :ToUserId,
                :Message,
                CURRENT_TIMESTAMP()
            )";
        $stmt = $conn->prepare($query);
        $stmt->bindPARAM(":RentId", $_POST["rentId"], PDO::PARAM_INT);
        $stmt->bindPARAM(":FromUserId", $userId, PDO::PARAM_INT);
        $stmt->bindPARAM(":ToUserId", $renter[0]->OtherUserId, PDO::PARAM_INT);
        $stmt->bindPARAM(":Message", $_POST["message"], PDO::PARAM_STR);
        $stmt->execute();
    }
