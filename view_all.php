<?php
try {

        $conn = new PDO("mysql:host=$server;dbname=$database", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM REDACTED_TABLE_NAME");
        $stmt->execute();

        $result = $stmt-> fetchAll(PDO::FETCH_BOTH);

}	
catch(PDOException $e)

    {
        echo "Database connection failed: " . $e->getMessage();
    }
?>
<div class="container-fluid">
    <div class="row">
        <table class="table table-striped table-hover" id="view-all">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>iPad</th>
                    <th>iPhone</th>
                    <th>Laptop</th>
                    <th>Status</th>
                    <th>Last Update</th>
                </tr>
            </thead>
            <?php
            $row_counter = 0;
            foreach( $result as $row ) {
                $row_counter++;
                echo <<<EOT
                    <tr class="click-row" id="db-row-$row[id]"> 
                        <th scope='row'>$row_counter</th>
                        <td>$row[name]</td>
                        <td>$row[ipad]</td>
                        <td>$row[iphone]</td>
                        <td>$row[laptop]</td>
                        <td>$row[status]</td>
                        <td>$row[last_update]</td>
                    </tr>
EOT;
            }
?>
        </table>
    </div>
</div>