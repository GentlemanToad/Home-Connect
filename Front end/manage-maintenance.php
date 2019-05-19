<?php
  require_once "config.inc.php";
  require_once "common.inc.php";
  require_once "check_login.php";

  if($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    $maintenanceId = $_POST['maintenanceId'];
  }
  else
  {
    $maintenanceId = $_GET['maintenanceId'];
  }

  $conn = Database::getInstance();
  $userId = GetLoggedInUserId();
  $query = "
    SELECT 
      m.*, 
      rp.AddressLine1,
      rp.AddressLine2,
      rp.Suburb,
      rp.P_State,
      PostCode,
      rp.Landlord_User_ID LandlordId,
      r.Tenants_ID TenantId,
      IF(r.Tenants_ID = :UserId, 0, 1) IsLandlord
    FROM Maintenance m
    INNER JOIN RentedProperties rp ON m.Property_ID = rp.Property_ID
    INNER JOIN Renter r ON rp.Property_ID = r.RentedProperty_ID
    WHERE 
      (rp.Landlord_User_ID = :UserId OR r.Tenants_ID = :UserId) AND
      m.Maintenance_ID = :MaintenanceId";
  $stmt = $conn->prepare($query);
  $stmt->bindPARAM(":UserId", $userId, PDO::PARAM_INT);
  $stmt->bindPARAM(":MaintenanceId", $maintenanceId, PDO::PARAM_INT);
  $stmt->execute();
  $maintenance = $stmt->fetchAll(PDO::FETCH_OBJ)[0];

  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    $query = "
      UPDATE Maintenance
      SET 
        MaintenanceStart = :MaintenanceStart,
        MaintenanceEnd = :MaintenanceEnd,
        MaintenanceStatus = :MaintenanceStatus
      WHERE Maintenance_ID = :MaintenanceId";
    $stmt = $conn->prepare($query);
    $stmt->bindPARAM(":MaintenanceId", $maintenanceId, PDO::PARAM_INT);
    $stmt->bindPARAM(":MaintenanceStart", $_POST['start'], PDO::PARAM_STR);
    $stmt->bindPARAM(":MaintenanceEnd", $_POST['end'], PDO::PARAM_STR);
    $stmt->bindPARAM(":MaintenanceStatus", $_POST['status'], PDO::PARAM_STR);
    $stmt->execute();

    Redirect("manage-maintenance.php?maintenanceId=" . $maintenanceId);
  }

  $statusList = array('Pending', 'Started', 'Completed', 'Abandoned', 'FollowUp');

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
      <h1><?=GetAddress($maintenance) ?></h1>

      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="update-tab" data-toggle="tab" href="#update" role="tab" aria-controls="contact" aria-selected="false">Update</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
          <div class="card-body">
            <h5>Description</h5>
            <small><?=$maintenance->Description ?></small>

            <h5>Starts On</h5>
            <small><?=$maintenance->MaintenanceStart ?></small>

            <h5>Ends On</h5>
            <small><?=$maintenance->MaintenanceEnd ?></small>

            <h5>Status</h5>
            <small><?=$maintenance->MaintenanceStatus ?></small>
          </div>
        </div>
        <div class="tab-pane fade" id="update" role="tabpanel" aria-labelledby="update-tab">
        
          <form id="manage-maintenance" method="POST">
            <input type="hidden" name="maintenanceId" value="<?=$maintenanceId ?>" />
            <div class="form-row">              
              <div class="form-group col-md-6">
                <label for="start">Starts On</label>
                <input type="text" class="form-control" name="start" id="start" value="<?=$maintenance->MaintenanceStart ?>" />
              </div>
              <div class="form-group col-md-6">
                <label for="end">Ends On</label>
                <input type="text" class="form-control" name="end" id="end" value="<?=$maintenance->MaintenanceEnd ?>" />
              </div>
              <div class="form-group col-md-6">
                <label for="status">Status</label>
                <select class="form-control" name="status" id="status">
                  <?=ToSelectOptions($statusList, $maintenance->MaintenanceStatus) ?>
                </select>
              </div>
              <div class="form-group col-md-12">            
                <button type="submit" class="btn btn-danger">
                  <i class="far fa-save"></i> Save
                </button>
              </div>
            </div>
          </form>

        </div>
      </div>

    </div>

    <?php include_once "footer.php" ?>

  </body>
</html>
