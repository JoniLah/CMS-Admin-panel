<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "admin/functions.php"; ?>
<?php 
    $message = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $error = [
            'username' => '',
            'email' => '',
            'password' => ''
        ];

        /*
            Username validation
        */
        if (strlen($username) < 3) {
            $error["username"] = "Username needs to be longer!";
        }

        if (strlen($username) > 20) {
            $error["username"] = "Username cannot be longer than 20 characters!";
        }

        if (empty($username)) {
            $error["username"] = "Username cannot be empty!";
        }

        if (usernameExists($username)) {
            $error["username"] = "Username is already taken!";
        }
        // Prevent using symbols
        if (!ctype_alnum($username)) {
            $error["username"] = "Username should only contain numbers and/or letters!";
        }

        /* 
            Email validation
        */
        if (empty($email)) {
            $error["email"] = "Email cannot be empty!";
        }

        if (emailExists($email)) {
            $error["email"] = "Email is already taken! <a href='index.php'>Login here</a>!";
        }
        // In case the user removes email type from the input field
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error["email"] = "Invalid email format!"; 
        }

        /* 
            Password validation
        */
        if (empty($password)) {
            $error["password"] = "Password cannot be empty!"; 
        }

        if (strlen($password) < 6) {
            $error["password"] = "Password should be at least 6 letters!"; 
        }

        foreach ($error as $key => $value) {
            if (empty($value)) {
                unset($error[$key]);
            }
        }

        if (empty($error)) {
            registerUser($username, $email, $password);
            loginUser($username, $password);
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
                            <form role="form" action="/cms/registration" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value="<?php echo isset($username) ? $username : ""; ?>">
                                    <p><?php echo isset($error['username']) ? $error['username'] : ""; ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value="<?php echo isset($email) ? $email : ""; ?>">
                                    <p><?php echo isset($error['email']) ? $error['email'] : ""; ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password" autocomplete="off">
                                    <p><?php echo isset($error['password']) ? $error['password'] : ""; ?></p>
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
