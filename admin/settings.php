<?php include "includes/header.php"; ?>
<?php

    
    $query = mysqli_query($connection, "SELECT users.user_id, user_settings.user_redirection, user_settings.user_language FROM users, user_settings WHERE users.user_id = user_settings.user_settings_id");
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $redirection = $row['user_redirection'];
            $language = $row['user_language'];
        }
    }

    if (isset($_POST['save-settings'])) {
        $user_id = $_SESSION['user_id'];
        $redirection = $_POST['redirection'];
        $language = $_POST['language'];

        $query = mysqli_query($connection, "UPDATE user_settings SET user_redirection = '$redirection', user_language = '$language' WHERE user_settings_id = $user_id");
        confirm($query);
        redirect("index.php");
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
                            Settings
                        </h1>  

                        <form action="settings.php" method="post">
                            <div class="form-group">
                                <h2>Login Redirect Location</h2>
                                <div>
                                    <label class="label-container">Admin Panel
                                        <input type="radio" name="redirection" value="admin" <?php echo $redirection == "admin" ? "checked" : ""; ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="label-container">Home Page
                                        <input type="radio" name="redirection" value="home" <?php echo $redirection == "home" ? "checked" : ""; ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <hr>
                                <h2>Language</h2>
                                <div>
                                    <label class="label-container">English
                                        <input type="radio" name="language" value="english" <?php echo $language == "english" ? "checked" : ""; ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="label-container">Finnish
                                        <input type="radio" name="language" value="finnish" <?php echo $language == "finnish" ? "checked" : ""; ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Save Settings" name="save-settings">
                                </div>
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