<?php
if(isset($_GET["row"]))
{
    $edit_row = $_GET["row"];
}

if(isset(
    $_POST['name'],
    $_POST['status'],
    $_POST['ipad'],
    $_POST['iphone'],
    $_POST['laptop'],
    $_POST['ipad_imei'],
    $_POST['ipad_phone_number'],
    $_POST['iphone_imei'],
    $_POST['iphone_phone_number'],
    $_POST['iphone_carrier'],
    $_POST['laptop_asset_number']
    )

&& !empty($_POST['name'])) {
    $name = $_POST['name'];
    $status = $_POST['status'];
    $ipad = $_POST['ipad'];
    $iphone = $_POST['iphone'];
    $laptop = $_POST['laptop'];
    $ipad_imei = $_POST['ipad_imei'];
    $ipad_phone_number = $_POST['ipad_phone_number'];
    $iphone_imei = $_POST['iphone_imei'];
    $iphone_phone_number = $_POST['iphone_phone_number'];
    $iphone_carrier = $_POST['iphone_carrier'];
    $laptop_asset_number = $_POST['laptop_asset_number'];
    $timestamp = time();
    $last_update = date("F jS, Y @ g:i:s A", $timestamp);

    $get_row_id = $_POST['row_id'];

    // Query pulls in all records related to a departure user
    try {

        $conn = new PDO("mysql:host=$server;dbname=$database", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("UPDATE REDACTED_TABLE_NAME SET 
            status='$status',
            last_update='$last_update',
            name='$name',
            ipad='$ipad',
            ipad_imei='$ipad_imei',
            ipad_phone_number='$ipad_phone_number',
            iphone='$iphone',
            iphone_imei='$iphone_imei',
            iphone_phone_number='$iphone_phone_number',
            iphone_carrier='$iphone_carrier',
            laptop='$laptop',
            laptop_asset_number='$laptop_asset_number'
            
            WHERE id='$get_row_id'");
        $stmt->execute();

        header('Location: ?p=view_all');
    }
    catch(PDOException $e)

    {
        echo "Could not save, here's why: " . $e->getMessage();
    }
}

try {

    $conn = new PDO("mysql:host=$server;dbname=$database", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM REDACTED_TABLE_NAME WHERE id ='$edit_row' ");
    $stmt->execute();

    $result = $stmt-> fetchAll(PDO::FETCH_BOTH);

}
catch(PDOException $e)

{
    echo "Connection failed: " . $e->getMessage();
}
?>
<div class="container-fluid">
<?php
foreach( $result as $row ) {
    echo <<<EOT
<!-- Button trigger modal -->
<div class="text-center" ="top-buttons">
    <button type="button" class="btn btn-outline-primary hidden-print" id="print-button">Print</button>
    <button type="button" class="btn btn-outline-success hidden-print" data-toggle="modal" data-target="#confirmation-modal" id="save-button">Save</button>
    <button type="button" class="btn btn-outline-primary hidden-print" id="edit-button">Edit</button>
    <button type="button" class="btn btn-outline-danger hidden-print" id="go-back-button">Go Back</button>
    <button type="button" class="btn btn-outline-danger hidden-print" id="cancel-button">Cancel</button>
</div>
<div>
    <form method="POST" action="" id="edit-values">
        <table class="table table-striped display">
            <tbody>
                <input type="hidden" name="row_id" value="$row[id]">
                <tr>
                    <th scope="row">Status</th>
                    <td>
                        <div class="initial-text">$row[status]</div>
                        <select class="form-control view-input" name="status">
                            <option selected>Not Received</option>
                            <option>In Progress</option>
                            <option>Complete</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Name</th>
                    <td>
                        <div class="initial-text">$row[name]</div>
                        <input class="form-control view-input" type="text" value="$row[name]" name="name" id="name" autofocus>
                    </td>
                </tr>
                <tr>
                    <th scope="row">iPad</th>
                    <td>
                        <div class="initial-text">$row[ipad]</div>
                        <select class="form-control view-input" name="ipad">
                            <option selected>Not Received</option>
                            <option>Received</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">iPad IMEI</th>
                    <td>
                        <div class="initial-text">$row[ipad_imei]</div>
                        <input class="form-control view-input" type="text" value="$row[ipad_imei]" name="ipad_imei">
                    </td>
                </tr>
                <tr>
                    <th scope="row">iPad Phone #</th>
                    <td>
                        <div class="initial-text">$row[ipad_phone_number]</div>
                        <input class="form-control view-input" type="text" value="$row[ipad_phone_number]" name="ipad_phone_number">
                    </td>
                </tr>
                <tr>
                    <th scope="row">iPhone</th>
                    <td>
                        <div class="initial-text">$row[iphone]</div>
                        <select class="form-control view-input" name="iphone">
                            <option selected>Not Received</option>
                            <option>Received</option>
                            <option>Purchased</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">iPhone IMEI</th>
                    <td>
                        <div class="initial-text">$row[iphone_imei]</div>
                        <input class="form-control view-input" type="text" value="$row[iphone_imei]" name="iphone_imei">
                    </td>
                </tr>
                <tr>
                    <th scope="row">iPhone Phone #</th>
                    <td>
                        <div class="initial-text">$row[iphone_phone_number]</div>
                        <input class="form-control view-input" type="text" value="$row[iphone_phone_number]" name="iphone_phone_number">
                    </td>
                </tr>
                <tr>
                    <th scope="row">iPhone Carrier</th>
                    <td>
                        <div class="initial-text">$row[iphone_carrier]</div>
                        <input class="form-control view-input" type="text" value="$row[iphone_carrier]" name="iphone_carrier">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Laptop</th>
                    <td>
                        <div class="initial-text">$row[laptop]</div>
                        <select class="form-control view-input" name="laptop">
                            <option selected>Not Received</option>
                            <option>Received</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Laptop Asset #</th>
                    <td>
                        <div class="initial-text">$row[laptop_asset_number]</div>
                        <input class="form-control view-input" type="text" value="$row[laptop_asset_number]" name="laptop_asset_number">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
            
    <!-- Modal -->
    <div class="modal fade" id="confirmation-modal" tabindex="-1" role="dialog" aria-labelledby="confirmation-modal-label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmation-modal-label">Are you sure you want to save changes?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Changes cannot be undone.</p>
            <div id="changes-made"></div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="confirmation-cancel-button">Cancel</button>
            <button type="submit" class="btn btn-outline-success" form="edit-values" id="confirmation-save-button">Save changes</button>
          </div>
        </div>
      </div>
    </div>
</div>
EOT;
}
?>
</div>