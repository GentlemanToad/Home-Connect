<?php
  require_once "config.inc.php";
  require_once "common.inc.php";
  require_once "check_login.php";

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
    WHERE (rp.Landlord_User_ID = :UserId OR r.Tenants_ID = :UserId)";
  $stmt = $conn->prepare($query);
  $stmt->bindPARAM(":UserId", $userId, PDO::PARAM_INT);
  $stmt->execute();
  $maintenance = $stmt->fetchAll(PDO::FETCH_OBJ);

  $query = "
    SELECT
      rp.*, 
      rp.Landlord_User_ID LandlordId,
      r.Tenants_ID TenantId,
      IF(r.Tenants_ID = :UserId, 0, 1) IsLandlord
    FROM RentedProperties rp
    INNER JOIN Renter r ON rp.Property_ID = r.RentedProperty_ID
    WHERE (rp.Landlord_User_ID = :UserId OR r.Tenants_ID = :UserId)";
  $stmt = $conn->prepare($query);
  $stmt->bindPARAM(":UserId", $userId, PDO::PARAM_INT);
  $stmt->execute();
  $rentedProperties = $stmt->fetchAll(PDO::FETCH_OBJ);
  $landlordProperties = array();
  $tenantProperties = array();
  foreach ($rentedProperties as $row) {
    if($row->IsLandlord == 1)
    {
      array_push($landlordProperties, $row);
    }
    else
    {
      array_push($tenantProperties, $row);
    }
  }

  function GetAddress($row)
  {
    $address = $row->AddressLine1;
    if($row->AddressLine2)
    {
      $addess .= ", " . $row->AddressLine2;
    }

    return $address . ", " . $row->Suburb . ", " . $row->P_State . " " . $row->PostCode;
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

      <h1>Maintenance</h1>

      <div class="maintenance-actions">
        <div class="btn-group">
          <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Add a maintenance
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <?php foreach ($landlordProperties as $row) { ?>
              <a class="dropdown-item" href="add-maintenance.php?propertyId=<?=$row->Property_ID ?>">
                <i class="fa fa-home" style="color: #721c24"></i> <?=GetAddress($row) ?>
              </a>
            <?php } ?>
            
            <?php if(count($landlordProperties) > 0 && count($tenantProperties) > 0){ ?>
              <div class="dropdown-divider"></div>
            <?php } ?>

            <?php foreach ($tenantProperties as $row) { ?>
              <a class="dropdown-item" href="add-maintenance.php?propertyId=<?=$row->Property_ID ?>">
                <i class="fa fa-home" style="color: #0c5460"></i> 
                <span><?=GetAddress($row) ?></span>
              </a>
            <?php } ?>
          </div>
        </div>
      </div>

      <table class="table table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Address</th>
            <th scope="col">Description</th>
            <th scope="col">Start</th>
            <th scope="col">End</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($maintenance as $row) { ?>
            <tr class="<?=$row->IsLandlord ? "table-secondary" : "" ?>">
              <th scope="row"><?=$row->AddressLine1 ?></th>
              <td><?=$row->Description ?></td>
              <td><?=$row->MaintenanceStart ?></td>
              <td><?=$row->MaintenanceEnd ?></td>
              <td>
                <span class="badge badge-warning">
                  <?=$row->MaintenanceStatus ?>
                </span>
              </td>
              <td>
                <a class="btn btn-sm btn-secondary" href="manage-maintenance.php?maintenanceId=<?=$row->Maintenance_ID ?>">
                  <i class="fas fa-pencil-alt"></i> Manage
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