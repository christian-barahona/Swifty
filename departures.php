<?php
ini_set('display_errors', 'On');
include 'remedy_connection.php';
try {
    $conn = new PDO( "sqlsrv:server=$serverName;database=$database", $uid, $pwd);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    // Creates window of time between two date periods
    $days_forward = time() + (30 * 24 * 60 * 60);
    $days_backward = time() - (30 * 24 * 60 * 60);

    // Query grabs all departure users within a specific corporate account group and site within a defined window of time
    $stmt = $conn->prepare(
        "SELECT Corporate_Account, 
                          Name, 
                          First_Name, 
                          Supervisor, 
                          End_Date, 
                          Start_Date, 
                          Email, 
                          Cost_Center, 
                          Site, 
                          Supervisor 
                  FROM REDACTED_TABLE_NAME
                  WHERE (Corporate_Account LIKE 'A%' OR Corporate_Account LIKE 'B%' OR Corporate_Account LIKE 'C%') AND (Site = 'REDACTED_SITE_NAME' OR Site = 'REDACTED_SITE_NAME' OR Site = 'REDACTED_SITE_NAME') AND (End_Date >= $days_backward AND End_Date <= $days_forward)
                  ORDER BY End_Date DESC");

    $stmt->execute();
    $result = $stmt-> fetchAll(PDO::FETCH_BOTH);

    $stmt = null;
    $conn = null;

} catch( PDOException $e ) {
    echo "<h1>Error connecting to SQL Server</h1><pre>";
    echo $e->getMessage();
    exit();
}

?>

<div class="container-fluid">
    <div class="text-center">List of departures from <strong><?php echo date("n/j/Y", $days_backward);?></strong> to <strong><?php echo date("n/j/Y", $days_forward);?></strong></div>
    <div class="row">
        <table class="table table-striped table-hover" id="view-all">
            <thead>
            <tr>
                <th>Status</th>
                <th>Departure Date</th>
                <th>Name</th>
                <th>Corporate ID</th>
                <th>Email</th>
                <th>Manager</th>
                <th>Site</th>
            </tr>
            </thead>
            <?php
            // Converts database values into user-friendly versions and then displays them in a list
            foreach( $result as $row ) {
                $end_date = date("n/j/Y", $row["End_Date"]);

                if (strcasecmp($row["Site"], "REDACTED_SITE_NAME") == 0){
                    $site = "REDACTED_SITE_NAME";
                }
                elseif (strcasecmp($row["Site"], "REDACTED_SITE_NAME") == 0){
                    $site = "REDACTED_SITE_NAME";
                }
                elseif (strcasecmp($row["Site"], "REDACTED_SITE_NAME") == 0){
                    $site = "REDACTED_SITE_NAME";
                }

                echo <<<EOT
                    <tr> 
                        <th scope='row'></th>
                        <td>$end_date</td>
                        <td>$row[First_Name] $row[Name]</td>
                        <td>$row[Corporate_Account]</td>
                        <td>$row[Email]</td>
                        <td>$row[Supervisor]</td>
                        <td>$site</td>
                    </tr>
EOT;
            }
            ?>
        </table>
    </div>
</div>
