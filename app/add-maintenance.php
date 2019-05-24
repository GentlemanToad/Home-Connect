<?php
  require_once "config.inc.php";
  require_once "common.inc.php";
  require_once "check_login.php";

  if($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    $rentId = $_POST['rentId'];
  }
  else
  {
    $rentId = $_GET['rentId'];
  }

  $conn = Database::getInstance();
  $userId = GetLoggedInUserId();
  $query = "
    SELECT rp.* 
    FROM RentedProperties rp
    INNER JOIN Renter r ON rp.Property_ID = r.Property_ID
    WHERE 
      (r.Landlord_User_ID = :UserId OR r.Tenant_User_ID = :UserId) AND
      r.Rent_ID = :RentId";
  $stmt = $conn->prepare($query);
  $stmt->bindPARAM(":UserId", $userId, PDO::PARAM_INT);
  $stmt->bindPARAM(":RentId", $rentId, PDO::PARAM_INT);
  $stmt->execute();
  $rentedProperty = $stmt->fetchAll(PDO::FETCH_OBJ)[0];

  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    $query = "
      INSERT INTO Maintenance (
        Rent_ID, 
        Description,
        MaintenanceStatus)
      VALUES (
        :RentId, 
        :Description, 
        'Pending')";
    $stmt = $conn->prepare($query);
    $stmt->bindPARAM(":RentId", $rentId, PDO::PARAM_INT);
    $stmt->bindPARAM(":Description", $_POST['description'], PDO::PARAM_STR);
    $stmt->execute();

    Redirect("maintenance.php");
  }

?>
<!doctype html>
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
      <h1><?=GetAddress($rentedProperty) ?></h1>

      <form id="manage-maintenance" method="POST">
        <input type="hidden" name="rentId" value="<?=$rentId ?>" />
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="start">Description</label>
            <textarea class="form-control" name="description" id="description" rows="5"></textarea>
          </div>
          <div class="form-group col-md-12">            
            <button type="submit" class="btn btn-danger">
             <i class="fas fa-plus"></i> Create new maintenance
            </button>
          </div>
        </div>
      </form>

    </div>

    <?php include_once "footer.php" ?>

  </body>
</html>