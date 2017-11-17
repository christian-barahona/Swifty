<?php
include 'remedy_connection.php';

try {
    $conn = new PDO( "sqlsrv:server=$serverName;database=$database", $uid, $pwd);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    // Provides window of time for results which can later be adjusted
    $days_backward = time() - (60 * 24 * 60 * 60);

    // Initializes corporate account array used to get requests tickets from second query
    $result_corporate_id = [];

    // Query to find all new hires based on start date from a specified site list and user group within a date range
    $stmt = $conn->prepare(
        "SELECT Corporate_Account, 
                          Name, 
                          First_Name, 
                          Supervisor, 
                          Start_Date, 
                          Email, 
                          Cost_Center, 
                          Site, 
                          Supervisor,
                          Supervisor_Email,
                          Supervisor_ID, 
                          Creation_date
                  FROM REDACTED_TABLE_NAME
                  WHERE (Corporate_Account LIKE 'A%' OR Corporate_Account LIKE 'B%' OR Corporate_Account LIKE 'B%') AND (Site = 'REDACTED_SITE_NAME' OR Site = 'REDACTED_SITE_NAME' OR Site = 'REDACTED_SITE_NAME' OR Site = 'REDACTED_SITE_NAME') AND (Start_Date >= $days_backward)
                  ORDER BY Start_Date DESC");
    $stmt->execute();
    $result = $stmt-> fetchAll(PDO::FETCH_BOTH);

    // Query gets corporate ID's from first query and searches all related requests on another table
    foreach( $result as $row ) {
        $result_corporate_id[] = "'" . $row['Corporate_Account'] . "'";
    }

    $temp = implode(',', $result_corporate_id);
    $stmt = $conn->prepare("
          SELECT Customer_First_Name, Customer_Last_Name, TitleFromSRD, Request_Number, Requested_For_Login_ID, InstanceID 
          FROM REDACTED_TABLE_NAME
          WHERE Requested_For_Login_ID IN ($temp) AND (SRD_Number = 'REDACTED_NUMBER' OR SRD_Number = 'REDACTED_NUMBER')
          ");

    $stmt->execute();
    $result_req = $stmt-> fetchAll(PDO::FETCH_BOTH);
    $stmt = null;
    $conn = null;

} catch( PDOException $e ) {
    echo "<h1>Error connecting to SQL Server</h1><pre>";
    echo $e->getMessage();
    exit();
}

?>

<div class="container-fluid">
    <div class="text-center">List of new hires from <strong><?php echo date("n/j/Y", $days_backward);?> </strong>onwards</strong></div>
</div>
<div>
    <label for="site-dropdown">Site </label>
    <select id="site-dropdown">
        <option value="">All</option>
        <option value="REDACTED_SITE_NAME">REDACTED_SITE_NAME</option>
        <option value="REDACTED_SITE_NAME">REDACTED_SITE_NAME</option>
        <option value="REDACTED_SITE_NAME">REDACTED_SITE_NAME</option>
        <option value="REDACTED_SITE_NAME">REDACTED_SITE_NAME</option>
    </select>
</div>
<div class="row">
    <table class="table table-striped table-hover" id="view-all">
            <thead>
            <tr>
                <th>Start Date</th>
                <th>New Hire Request</th>
                <th>Name</th>
                <th>Corporate ID</th>
                <th>Email</th>
                <th>Manager</th>
                <th>Site</th>
                <th>Creation Date</th>
            </tr>
            </thead>
            <?php
            foreach( $result as $row ) {
                $start_date = date("n/j/Y", $row["Start_Date"]);
                $creation_date = date("n/j/Y", $row["Creation_date"]);
                $site = $row["Site"];
                if (strcasecmp($site, "REDACTED_SITE_NAME") == 0){
                    $site = "REDACTED_SITE_NAME";
                }
                elseif (strcasecmp($site, "REDACTED_SITE_NAME") == 0){
                    $site = "Remote";
                }
                elseif (strcasecmp($site, "REDACTED_SITE_NAME") == 0){
                    $site = "REDACTED_SITE_NAME";
                }
                elseif (strcasecmp($site, "REDACTED_SITE_NAME") == 0){
                    $site = "REDACTED_SITE_NAME";
                }
                $email = strtoupper($row["Email"]);
                $supervisor_email = $row["Supervisor_Email"];
                $full_name = $row["First_Name"] . " " . $row["Name"];
                $new_hire_request = "";
                $instance_id = "";
                foreach ($result_req as $req){
                    if (strcasecmp($row["Corporate_Account"], $req["Requested_For_Login_ID"]) == 0){
                        $new_hire_request = $req["Request_Number"];
                        $instance_id = $req["InstanceID"];
                    }
                }
                echo <<<EOT
                    <tr class=""> 
                        <td>$start_date</td>
                        <td><a href='https://REDACTED_SITE_NAME/#/request/$instance_id' target="_blank">$new_hire_request</a></td>
                        <td><a href='https://REDACTED_SITE_NAME/#/person/$row[Corporate_Account]' target="_blank">$full_name</a> <button class="btn copy icon-button" data-clipboard-text="$full_name"><i class="material-icons md-20">content_copy</i></button></td>
                        <td>$row[Corporate_Account] <button class="btn copy icon-button" data-clipboard-text="$row[Corporate_Account]"><i class="material-icons md-20">content_copy</i></button></td>
                        <td>$email</td>
                        <td><a href='https://REDACTED_SITE_NAME/#/person/$row[Supervisor_ID]' target="_blank">$row[Supervisor]</a> <button class="btn icon-button email-button" onclick="location.href='mailto:$supervisor_email?Subject=New%20Hire%20-%20$full_name';"><i class="material-icons md-20">mail_outline</i></button></td>
                        <td>$site</td>
                        <td>$creation_date</td>
                    </tr>
EOT;
            }
            ?>
        </table>
    </div>
