<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php
    $message = null; // Pop up message, not email message!
    if(isset($_POST['submit'])) {
        /*
        $to = "donuto@feleroid.com";
        $subject = wordwrap($_POST['subject'], 70);
        $body = $_POST['body'];
        $header = "From: " . $_POST['email'];

        // send email
        mail($to, $subject, $body, $header);*/
        set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());
        require_once "Mail.php";

        $host = "ssl://sub4.mail.dreamhost.com";
        $username = "youremail@example.com";
        $password = "your email password";
        $port = "465";
        $to = "address_form_will_send_TO@example.com";
        $email_from = "youremail@example.com";
        $email_subject = "Subject Line Here: " ;
        $email_body = "whatever you like" ;
        $email_address = "reply-to@example.com";

        $headers = array ('From' => $email_from, 'To' => $to, 'Subject' => $email_subject, 'Reply-To' => $email_address);
        $smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
        $mail = $smtp->send($to, $headers, $email_body);


        if (PEAR::isError($mail)) {
        echo("<p>" . $mail->getMessage() . "</p>");
        } else {
        echo("<p>Message successfully sent!</p>");
        }
    }
?>

    <!-- Navigation -->
    <?php  include "includes/navigation.php"; ?>
    
    <!-- Page Content -->
    <div class="container">
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-wrap">
                        <h1>Contact</h1>
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                                <h6 class="text-center"><?php echo $message; ?></h6>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Your email" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="subject" class="sr-only">Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <textarea name="message" id="body" class="form-control"></textarea>
                                </div>
                                
                                <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send Message">
                            </form>
                        
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>

        <hr>

<script>
    //CKEditor 5
    ClassicEditor.create(document.querySelector('#body')).catch( error => {
        console.error(error);
    });
</script>

<?php include "includes/footer.php";?>
