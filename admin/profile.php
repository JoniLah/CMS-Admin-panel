<?php include "includes/header.php"; ?>
<?php

    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        $query = "SELECT * FROM users WHERE username = '$username'";

        $select_user_profile = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_user_profile)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
        }
    }

?>

<?php

    if (isset($_POST['update_profile'])) {
        $username = $_POST['username'];
        !empty($_POST['user_password']) ? $user_password = $_POST['user_password'] : $user_password = null;
        $user_password !== null ? $user_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost" => 12)) : "";
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];

        $query = "UPDATE users SET ";
        $query .= "username = '{$username}', ";
        !empty($_POST['user_password']) ? $query .= "user_password = '{$user_password}', " : "";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_email = '{$user_email}' ";
        $query .= "WHERE username = '{$username}'";

        $update_user = mysqli_query($connection, $query);
        confirm($update_user);
        session_unset();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['firstname'] = $user_firstname;
        $_SESSION['lastname'] = $user_lastname;
        $_SESSION['role'] = "admin";
    }

?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $_SESSION['firstname'] . " " .  $_SESSION['lastname']; ?>
                        </h1>  

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" value="<?php echo $username; ?>" name="username">
                            </div>

                            <div class="form-group">
                                <label for="user_password">Password</label>
                                <input type="password" class="form-control" name="user_password" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="user_firstname">First name</label>
                                <input type="text" class="form-control" value="<?php echo $user_firstname; ?>" name="user_firstname">
                            </div>

                            <div class="form-group">
                                <label for="user_lastname">Last name</label>
                                <input type="text" class="form-control" value="<?php echo $user_lastname; ?>" name="user_lastname">
                            </div>

                            <div class="form-group">
                                <label for="user_email">Email</label>
                                <input type="email" class="form-control" value="<?php echo $user_email; ?>" name="user_email">
                            </div>

                            <div class="form-group">
                                <label for="user_image">User Image</label>
                                <input type="file" name="image">
                            </div>

                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="update_profile" value="Update Profile">
                            </div>
                        </form>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/footer.php"; ?>