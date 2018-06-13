<?php

    if (isset($_GET['edit_user'])) {
        $user_id = $_GET['edit_user'];

        $query = "SELECT * FROM users WHERE user_id = $user_id";
        $select_user = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_user)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
        }
    }


    if (isset($_POST['update_user'])) {
        $username = $_POST['username'];
        $user_password = $_POST['user_password'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_role = $_POST['user_role'];

        //Encrypt password
        $query = "SELECT rand_salt FROM users";
        $select_randsalt = mysqli_query($connection, $query);
        confirm($select_randsalt);
        $row = mysqli_fetch_array($select_randsalt);
        $salt = $row['rand_salt'];
        $hashed_password = crypt($user_password, $salt);

        $query = "UPDATE users SET ";
        $query .= "username = '{$username}', ";
        $query .= "user_password = '{$hashed_password}', ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_role = '{$user_role}' ";
        $query .= "WHERE user_id = {$user_id}";

        $update_user = mysqli_query($connection, $query);

        confirm($update_user);

        $_SESSION['username'] = $username;
        $_SESSION['firstname'] = $user_firstname;
        $_SESSION['lastname'] = $user_lastname;
        $_SESSION['role'] = $user_role;
    }
    

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" value="<?php echo $username; ?>" name="username">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" value="<?php echo $user_password; ?>"  name="user_password">
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
        <label for="user_role">Role</label>
        <select name="user_role" id="">
            <option value='<?php echo $user_role; ?>'><?php echo $user_role; ?></option>
            <?php
                if ($user_role == 'admin') {
                    echo "<option value='subscriber'>subscriber</option>";
                } else {
                    echo "<option value='admin'>admin</option>";
                }
            ?>
        </select>
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
        <input class="btn btn-primary" type="submit" name="update_user" value="Update User">
    </div>
</form>