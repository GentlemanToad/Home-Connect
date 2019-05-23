<?php
  require_once "config.inc.php";
  require_once "common.inc.php";
  require_once "check_login.php";

  $conn = Database::getInstance();
  $userId = GetLoggedInUserId();
  $query = "
    SELECT 
      rp.*,
      IF(r.Tenant_User_ID = :UserId, r.Landlord_User_ID, r.Tenant_User_ID) OtherUserId,
      r.Rent_ID
    FROM Renter r
    INNER JOIN RentedProperties rp ON r.Property_ID = rp.Property_ID
    WHERE r.Landlord_User_ID = :UserId OR r.Tenant_User_ID = :UserId";
  $stmt = $conn->prepare($query);
  $stmt->bindPARAM(":UserId", $userId, PDO::PARAM_INT);
  $stmt->execute();
  $rents = $stmt->fetchAll(PDO::FETCH_OBJ);

?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />
    <link  type="text/css" rel="stylesheet" href="style.css">

    <title>Home Connect</title>
  </head>
  <body>
    <div>
        <img src='../media/HomeConnectLogo.png' alt='HomeConnectLogo' height=80>
    </div>

    <?php include_once "nav.php" ?>

    <div class="container">

      <h1>Chat Sessions</h1>

      <table class="table table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Address</th>
            <th scope="col">Session With</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($rents as $row) { ?>
            <tr>
              <th scope="row"><?=$row->AddressLine1 ?></th>
              <td><?=GetUser($row->OtherUserId)["FullName"] ?></td>
              <td>
                <a class="btn btn-sm btn-secondary" href="chatsession.php?rentId=<?=$row->Rent_ID ?>">
                  <i class="fas fa-comments"></i> View Coversation
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

    </div>

    <?php include_once "footer.php" ?>

  </body>
</html>