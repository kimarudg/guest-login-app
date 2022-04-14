<?php
if (isset($_GET['switch_url'])){
  $switch_url = $_GET['switch_url'];
  $switch_url = str_replace('https', 'http', $switch_url);
} else {
  $switch_url = '';
}
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$server = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$all_parameters = $_GET;


$params = 'switch_url='.$switch_url;

if (isset($_GET['ap_mac'])){
  $ap_mac = $_GET['ap_mac'];
} else {
  $ap_mac='';
}

$params = $params.'&ap_mac='.$ap_mac;

if (isset($_GET['client_mac'])){
  $client_mac = $_GET['client_mac'];
} else {
  $client_mac = '';
}
$params = $params.'&client_mac='.$client_mac;
if (isset($_GET['wlan'])){
  $wlan = $_GET['wlan'];
  $params = $params.'&wlan='.$wlan;
} else {
  $wlan = '';
  $is_hq_wifi = false;
}



if(isset($_GET['redirect'])){
  $redirect = $_GET['redirect'];
} else {
  $redirect = '';
}
$params = $params.'&redirect='.$redirect;

if (isset($_GET['location'])) {
  list($wlan, $switch_url) = explode("?", $_GET['location']);
  $params = $params.'&wlan='.$wlan;
}
$is_hq_wifi = strtolower($wlan) === strtolower('CA-HQ-GUEST');



if (isset($_GET['statusCode'])) {
  $params = $params.'&statusCode='.$statusCode;
  $statusCode = $_GET['statusCode'];
  if ($statusCode == 1) {
      $statusMessage = "You are already logged in.";
  }
  elseif ($statusCode == 2) {
      $statusMessage = "You are not configured to authenticate against this web portal.";
  }
  elseif ($statusCode == 3) {
      $statusMessage = "The email address specified cannot be used at this time. Perhaps the username is already logged into the system?";
  }
  elseif ($statusCode == 4) {
      $statusMessage = "This account has been excluded. Please contact the administrator.";
  }
  elseif ($statusCode == 5) {
      $statusMessage = "Invalid email or password. Please try again.";
  }
} else {
  $statusMessage = "";
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <title>Web Authentication</title>
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body class="c-app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
            <div class="card-header">
              <img src="assets/img/logo/logo.svg" />
            </div>
              <div class="card-body">
                <h1>Login</h1>
                <p class="text-muted">Sign In to your account</p>
                <?php if ($statusMessage) echo "<p class=\"alert\"><i class=\"fa fa-warning\"></i> {$statusMessage}</p>"; ?>
                <form action="<?php echo $switch_url; ?>" method="post" id="login-form">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend"><span class="input-group-text">
                        <svg class="c-icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                        </svg></span></div>
                    <input class="form-control" type="text" placeholder="Username" name="username" >
                  </div>
                  <div class="input-group mb-4">
                    <div class="input-group-prepend"><span class="input-group-text">
                        <svg class="c-icon">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                        </svg></span></div>
                    <input class="form-control" name="password" type="password" placeholder="Password">
                  </div>
                  <input type="hidden" name="buttonClicked" size="16" maxlength="15" value="4">
                  <div class="row">
                    <div class="col-12">
                      <input class="btn btn-primary col-12" type="submit" value="Log in" />
                    </div>
                    <?php if($is_hq_wifi){ ?>
                    <div class="col-12 text-right">
                      <a href="web/?actual=<?php echo $server.'?'.$params; ?>" class="btn btn-link col-12" type="button">Create Account</a>
                    </div>
                    <?php } else { ?>
                      <div class="col-12 text-right">
                      <span class="btn col-12" type="button">Get Login token from the reception</span>
                    </div>
                    <?php } ?>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <!--[if IE]><!-->
    <script src="vendors/@coreui/icons/js/svgxuse.min.js"></script>
    <!--<![endif]-->

  </body>
</html>