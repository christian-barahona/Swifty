<?php
$notice = "";
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

    try {

        $conn = new PDO("mysql:host=$server;dbname=$database", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("INSERT INTO REDACTED_TABLE (status, last_update, name, ipad, ipad_imei, ipad_phone_number, iphone, iphone_imei, iphone_phone_number, iphone_carrier, laptop, laptop_asset_number) 
        VALUES ('$status', '$last_update', '$name', '$ipad', '$ipad_imei', '$ipad_phone_number', '$iphone', '$iphone_imei', '$iphone_phone_number', '$iphone_carrier', '$laptop', '$laptop_asset_number')");
        $stmt->execute();

        header('Location: ?p=view_all');
    }
    catch(PDOException $e)

    {
        echo "Could not save, here's why: " . $e->getMessage();
    }
}
else {
    $notice = "<div class='text-center hidden-print'>All fields are required. Type <strong>N/A</strong> if no data is available.</div>";
}
?>

<div class="container-fluid">

<?php
echo <<<EOT
<div class="text-center">
    
    <button type="button" class="btn btn-outline-success hidden-print" data-toggle="modal" data-target="#confirmation-modal">Submit</button>
    <button type="button" class="btn btn-outline-danger hidden-print" id="go-back-button">Cancel</button>
    <p>$notice</p>
</div>
<form method="POST" action="" id="new-entry">
    <table class="table table-striped">
        <tbody>
        <tr>
                    <th scope="row">Status</th>
                    <td>
                        <select class="form-control" name="status" id="status">
                            <option selected>In Progress</option>
                            <option hidden>N/A</option>
                            <option>Awaiting to be Received</option>
                            <option>Complete</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Name</th>
                    <td>
                        <input class="form-control" type="text" value="" name="name" id="name" onkeyup="showResult(this.value)" autofocus>
						<div id="search-result"></div>
					</td>
                </tr>
                <tr>
                    <th scope="row">iPad</th>
                    <td>
                        <select class="form-control" name="ipad" id="ipad">
                            <option disabled selected>Select a status</option>
                            <option hidden>N/A</option>
                            <option>Not Issued</option>
                            <option>Awaiting to be Received</option>
                            <option>Received</option>
							<option>Missing/Stolen</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">iPad IMEI</th>
                    <td>
                        <input class="form-control" type="text" value="" name="ipad_imei" id="ipad_imei">
                    </td>
                </tr>
                <tr>
                    <th scope="row">iPad Phone #</th>
                    <td>
                        <input class="form-control" type="text" value="" name="ipad_phone_number" id="ipad_phone_number">
                    </td>
                </tr>
                <tr>
                    <th scope="row">iPhone</th>
                    <td>
                        <select class="form-control" name="iphone" id="iphone">
                            <option disabled selected>Select a status</option>
                            <option hidden>N/A</option>
                            <option>Awaiting to be Received</option>
                            <option>Received</option>
                            <option>Purchased</option>
                            <option>Missing/Stolen</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">iPhone IMEI</th>
                    <td>
                        <input class="form-control" type="text" value="" name="iphone_imei" id="iphone_imei">
                    </td>
                </tr>
                <tr>
                    <th scope="row">iPhone Phone #</th>
                    <td>
                        <input class="form-control" type="text" value="" name="iphone_phone_number" id="iphone_phone_number">
                    </td>
                </tr>
                <tr>
                    <th scope="row">iPhone Carrier</th>
                    <td>
                        <select class="form-control" name="iphone_carrier" id="iphone_carrier">
                            <option disabled selected>Select a Carrier</option>
                            <option hidden>N/A</option>
                            <option>AT&T</option>
                            <option>Verizon</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Laptop</th>
                    <td>
                        <select class="form-control" name="laptop" id="laptop">
                            <option disabled selected>Select a status</option>
                            <option hidden>N/A</option>
                            <option>Awaiting to be Received</option>
                            <option>Received</option>
							<option>Missing/Stolen</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Laptop Asset #</th>
                    <td>
                        <input class="form-control" type="text" value="" name="laptop_asset_number" id="laptop_asset_number">
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
                <h5 class="modal-title" id="confirmation-modal-label">Are you sure you want to submit this entry?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Click <strong>Confirm</strong> to submit entry.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-outline-success" form="new-entry" id="confirmation-save-button">Confirm</button>
            </div>
        </div>
    </div>
</div>
EOT;
?>
</div>