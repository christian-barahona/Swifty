<?php
include 'remedy_connection.php';
$term = $_GET["term"];
$users = [];

try {
    $conn = new PDO( "sqlsrv:server=$serverName;database=$database", $uid, $pwd);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    //echo "Connected to SQL Server<br /><br />\n";
    $stmt = $conn->prepare(
        "SELECT Site, Cost_Center, First_Name, Name, Status, Corporate_Account  
                   FROM REDACTED_TABLE_NAME
                   WHERE (Name LIKE '$term%' OR First_Name LIKE '$term%') AND (Site = 'REDACTED_SITE_NAME' OR Site = 'REDACTED_SITE_NAME' OR Site = 'REDACTED_SITE_NAME') AND Status = '0'");
    $stmt->execute();
    $result = $stmt-> fetchAll(PDO::FETCH_BOTH);

    foreach ($result as $row){
        $users[] = $row['First_Name'] . " " . $row['Name'] . " " . $row['Corporate_Account'] . " " .  $row['Cost_Center'];
    }
    sort($users);

    echo json_encode($users);

    $stmt = null;
    $conn = null;

} catch( PDOException $e ) {
    echo "<h1>Error connecting to SQL Server</h1><pre>";
    echo $e->getMessage();
    exit();
}

?>