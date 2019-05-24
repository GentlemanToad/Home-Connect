<?php
    require_once "config.inc.php";
    require_once "common.inc.php";
    require_once "check_login.php";

    if (!isset($_GET["rentId"]) || !$_GET["rentId"]){
        echo "Missing rentId in the request";
        exit;
    }

    $conn = Database::getInstance();
    $userId = GetLoggedInUserId();
    $query = "
        SELECT 
            c.*,
            u.FirstName
        FROM ChatSession c
        INNER JOIN Users u ON c.From_User_ID = u.User_ID
        WHERE 
            (From_User_ID = :UserId OR To_User_ID = :UserId) AND
            Rent_Id = :RentId";
    $stmt = $conn->prepare($query);
    $stmt->bindPARAM(":UserId", $userId, PDO::PARAM_INT);
    $stmt->bindPARAM(":RentId", $_GET["rentId"], PDO::PARAM_INT);
    $stmt->execute();
    $chatMessages = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<?php foreach($chatMessages as $row) { ?>

    <div>
        <strong>[<?=date('h:i a', strtotime($row->MessageTime)) ?>] <?=$row->FirstName ?>: </strong>
        <span><?=$row->Message ?></span>
    </div>

<?php } ?>