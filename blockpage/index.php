<?php
require('../config.php');

$safeurl = $conf['safeurl'];
$adminemail = $conf['adminemail'];

$hostname = gethostname();
$server_ip = $_SERVER['SERVER_ADDR']; 
$pipass_v = $conf['pipass_v'];

if(isset($_GET['url'])) {
  $url = $_GET['url'];
  $GLOBALS['url'] = $_GET['url'];
  $url_provided = true;
} else {
  $url_provided = false;
}

if($url == $server_ip) {
  $url = null;
  $url_provided = false;
}
?>

<!doctype html>
<html lang="en">
  <head>
  <script src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.js"></script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <title>Webpage Blocked</title>

    <!--- Inline styles -->
    <style>
        .container {
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            position: absolute;
        }

        #alert {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 95%;
        }

        .toast {
          margin-bottom: 0.5%;
        }

        #toastwrapper {
          margin-top: 1%;
          margin-right: 1%;
        }
    </style>

    <?php
    // Unblocking function

    if(isset($_GET['unblock'])) {
      unblock();
    }

    function unblock() {
      // Indicate to the user that we are trying to unblock the page

      echo <<<EOL
      <script>
      jQuery(function(){
        $('#requesting-toast').toast('show')
      });
      </script>
EOL;
    }
    ?>
  </head>
  <body>
    <div class="container">
        <div class="alert alert-danger" id="alert" role="alert">
            <h4 class="alert-heading"><i style="margin-right:1%;" class="fas fa-shield-alt"></i>Webpage Blocked</h4>
            <p>This website has been previously determined as a cybersecurity threat (e.g. phishing, malware) or a web tracking software and has been blocked. Sites such as advertising networks and scams may also be blocked, so it's in your best interest to avoid these blocked sites.</p>
                If you feel like this block has been made in error, select "Bypass Temporarily" below. If the block is causing recurring problems, select "Request Permanent Unblock" below. 
                The bypass temporarily function is automated. The unblock will last for <?php echo $conf['time_friendly']; ?>, then revert to blocked. You may need to flush your DNS cache and/or <a href="https://kb.iu.edu/d/ahic">your browser's cache.</a>
                Otherwise, we suggest you do not visit this website.
            <br />
            <br />
            <strong>Blacklisted URL: </strong><?php if($url_provided) { echo $url; } else { echo "Unknown"; } ?>
            <hr>
            <button onclick='window.location="<?php echo $safeurl; ?>";' type="button" class="btn btn-success btn-lg btn-block">Back to Safety</button>
            <button onclick='window.location="mailto:<?php echo $adminurl; ?>?Subject=Unblock%20Request";' type="button" class="btn btn-primary btn-lg btn-block">Request Permanent Unblock</button>
            <form action="<?php echo $conf['unblock_url']; ?>">
              <input type="hidden" name="url" value="<?php echo $url; ?>">
              <input type="hidden" name="unblock" value="true">
              <button style="margin-top:1%;" type="submit" class="btn btn-warning btn-lg btn-block">Unblock Temporarily</button>
            </form>
            <?php
                    $date = $conf['date'];

                    if($conf['show_tech_info'] == true) {
                      echo <<<EOL
                      <br />
                      <br />
                      <code style="color:gray">TECHNICAL INFO:</code>
                      <br />
                      <code style="color:gray">Reported by $hostname ($server_ip) at $date. Running PiPass version $pipass_v.</code>
                      </div>
EOL;
                    } else {
                      echo <<<EOL
                      </div>
EOL;
                    }
            ?>
        </div>
    </div>
    <div aria-live="polite" aria-atomic="true" id="toastwrapper" style="position: relative; min-height: 200px;">
      <div aria-live="polite" aria-atomic="true">
          <div class="toast" id="requesting-toast" style="position: absolute; top: 0; right: 0;" data-delay="20000">
            <div class="toast-header">
              <strong class="mr-auto">PiPass</strong>
            </div>
            <div class="toast-body">
              Requesting temporary unblock from the server. Do not reload the page, this may take a few seconds.
            </div>
          </div>
        </div>
      <div aria-live="polite" aria-atomic="true">
        <div class="toast" id="success-toast" style="position: absolute; top: 47%; right: 0;" data-delay="20000">
            <div class="toast-header">
              <strong class="mr-auto">PiPass</strong>
            </div>
            <div class="toast-body">
              Success! The page will be unblocked for 2 hours. Please clear your browser's cache to use the website.
            </div>
          </div>
        </div>
      </div>

      <!--- $('#requesting-toast').toast('show') -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>