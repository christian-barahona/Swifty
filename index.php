<?php
include 'mysql_connection.php';

// Sets default landing page
$page_content = "landing.php";

// Pulls in requested paged into index and determines it is a real file
if(isset($_GET['p'])) {
    $page_content = str_replace('.', '', $_GET['p']);
    $page_content .= '.php';
    if (!is_file($page_content)) {
        $page_content = '404.php';
    }
}

// Random number generated for development purposes to avoid caching of JavaScript and CSS files due to constant updates
$random_number_1 = rand(0, 999999);
$random_number_2 = rand(0, 999999);

$random_number = $random_number_1 . "-" . $random_number_2;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="format-detection" content="telephone=no"/>
    <title>Swifty</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <?php echo "<link rel='stylesheet' href='css/datatables.min.css?dev=$random_number'>"; ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <?php echo "<link rel='stylesheet' href='css/style.css?dev=$random_number'>"; ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-expand-md navbar-toggleable-md navbar-light bg-faded" id="main-nav">
    <button class="navbar-toggler navbar-toggler-right hidden-print" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="?">
        <img src="assets/ucb_logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Swifty
    </a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="?p=new_hires">New Hires</a>
            <a class="nav-item nav-link" href="?p=departures">Departures</a>
            <a class="nav-item nav-link" href="?p=user_lookup">User Lookup</a>
        </div>
    </div>
</nav>
<?php include $page_content; ?>

<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<?php echo "<script src='js/datatables.min.js?dev=$random_number'></script>"; ?>
<?php echo "<script src='js/clipboard.min.js?dev=$random_number'></script>"; ?>
<script src="js/modernizr-custom.js"></script>
<?php echo "<script src='js/functions.js?dev=$random_number'></script>"; ?>
</body>
</html>