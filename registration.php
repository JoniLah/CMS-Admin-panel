<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "admin/functions.php"; ?>
<?php
    $message = null;

    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        // Check for empty fields
        if (!empty($username) && !empty($password) && !empty($email)) {
            if (usernameExists($username)) {
                $message = "This username already exists!";
            } else if (emailExists($email)) {
                $message = "This email already exists!";
            } else {
                // Add security to the code
                $username = mysqli_real_escape_string($connection, $username);
                $password = mysqli_real_escape_string($connection, $password);
                $email = mysqli_real_escape_string($connection, $email);

                // An improved way to crypt the password
                $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

                $query = "INSERT INTO users(username, user_password, user_email, user_role) VALUES ('$username', '$password', '$email', 'subscriber')";
                mysqli_query($connection, $query);

                $message = "Your registration has been submitted!";
            }
        } else {
            $message = "Fields should not be empty!";
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
                        <h1>Register</h1>
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                                <h6 class="text-center"><?php echo $message; ?></h6>
                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password" autocomplete="off">
                                </div>
                        
                                <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                            </form>
                        
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>

        <hr>



<?php include "includes/footer.php";?>
