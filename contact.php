<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php
    $message = null; // Pop up message, not email message!
    if(isset($_POST['submit'])) {
        

        $path = '/usr/bin/perl';
        set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        /*
        $to = "donuto@feleroid.com";
        $subject = wordwrap($_POST['subject'], 70);
        $body = $_POST['body'];
        $header = "From: " . $_POST['email'];

        // send email
        mail($to, $subject, $body, $header);*/
        require_once "home/usr/php/Mail.php";
        $from = "From: " . $_POST['email'];
        $to = "support@feleroid.com";
        $subject = wordwrap($_POST['subject'], 70);
        $body = $_POST['body'];

        $host = "mail.zoner.fi";
        $username = "support@feleroid.com";
        $password = "f51y5h";
        $headers = array ('From' => $from,
        'To' => $to,
        'Subject' => $subject);
        $smtp = Mail::factory('smtp',
        array ('host' => $host,
            'auth' => true,
            'username' => $username,
            'password' => $password));
        $mail = $smtp->send($to, $headers, $body);
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
                            <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
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
