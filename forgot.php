<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>
<?php include_once "admin/functions.php"; ?>

<?php

    require "./vendor/autoload.php";

    /*if (!ifMethod("get") || !isset($_GET['forgot'])) {
        redirect("/cms");
    }*/

    if (isset($_POST['recover-submit'])) {
        if (isset($_POST['email'])) {
            $email = mysqli_real_escape_string($connection, $_POST['email']);
            $length = 50;
            $token = bin2hex(openssl_random_pseudo_bytes($length));

            if (emailExists($email)) {
                if ($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email = ?")) {
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    // Configure PHPMailer
                    $mail = new PHPMailer();
                    try {
                        $mail->isSMTP();                                      // Set mailer to use SMTP
                        $mail->Host = Config::SMTP_HOST;                      // Specify main and backup SMTP servers
                        $mail->SMTPAuth = true;                               // Enable SMTP authentication
                        $mail->Username = Config::SMTP_USER;                  // SMTP username
                        $mail->Password = Config::SMTP_PASSWORD;              // SMTP password
                        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                        $mail->Port = Config::SMTP_PORT;                      // TCP port to connect to
                        $mail->isHTML(true);                                  // Set email format to HTML

                        $mail->setFrom("joni.lahdesmaki@hotmail.fi", "Joni Lähdesmäki");
                        $mail->addAddress($email); // Add a recipient

                        $mail->Subject = "This is a test email ää";
                        $mail->Body = "<h2>Please click <a href='http://localhost/cms/reset.php?email=" . $email . "&token=" . $token . "'>here</a> to reset your password</h2>";
                        $mail->CharSet = "UTF-8";

                        $mail->send();
                        echo "<h2 class='text-center'>Password reset link has been sent to your email!</h2>";  
                    } catch (Exception $e) {
                        echo "<h2 class='text-center'>Message couldn't be sent! Mailer error: $mail->ErrorInfo</h2>";
                    }
                } else {
                    echo "<h2 class='text-center'>" . mysqli_error($connection) . "</h2>";
                }
            } else {
                echo "<h2 class='text-center'>This email doesn't exists.</h2>";
            }
        }
    }
?>

<!-- Page Content -->
<div class="container">
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">
                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                            <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>
                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>
                            </div><!-- Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <?php include "includes/footer.php";?>
</div> <!-- /.container -->

