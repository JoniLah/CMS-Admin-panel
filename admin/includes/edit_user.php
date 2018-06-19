<?php
    if (isset($_GET['edit_user'])) {
        $user_id = $_GET['edit_user'];

        if ($stmt = mysqli_prepare($connection, "SELECT user_id, username, user_password, user_firstname, user_lastname, user_email, user_image, user_role FROM users WHERE user_id = ?")) {
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $user_id, $username, $user_password, $user_firstname, $user_lastname, $user_email, $user_image, $user_role);
            
        }
        $query = "SELECT * FROM users WHERE user_id = $user_id";
        $select_user = mysqli_query($connection, $query);
        
        // Check if the ID actually exists in the database
        mysqli_num_rows($select_user) > 0 ? '' : header("Location: index.php");

        while ($row = mysqli_fetch_assoc($select_user)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $original_username = $username; // To check if the user changed their username
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $original_email = $user_email; // To check if the user changed their email
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
        }
    } else {
        header("Location: index.php");
    }

    if (isset($_POST['update_user'])) {
        $username = $_POST['username'];
        !empty($_POST['user_password']) ? $user_password = $_POST['user_password'] : $user_password = null;
        $user_password !== null ? $user_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost" => 12)) : "";
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_role = $_POST['user_role'];

        $error = [
            'firstname' => '',
            'lastname' => '',
            'username' => '',
            'email' => ''
        ];

        /*
            *** ERROR VALIDATION ***
        */
        
        // Firstname
        // Allow only letters for the first name
        if (!empty($user_firstname)) {
            if (!ctype_alpha($user_firstname)) {
                $error["firstname"] = "First name should only contain letters!";
            }
        }

        // Lastname
        // Allow only letters for the last name
        if (!empty($user_lastname)) {
            if (!ctype_alpha($user_lastname)) {
                $error["lastname"] = "Last name should only contain letters!";
            }
        }

        // Username
        if ($original_username !== $username) {
            // Username has been changed, check if the username is available
            if (usernameExists($username)) {
                $error["username"] = "Username is already taken!";
            }

            // Must be over 2 characters
            if (strlen($username) < 3) {
                $error["username"] = "Username needs to be longer!";
            }

            // Must not be over 20 characters
            if (strlen($username) > 20) {
                $error["username"] = "Username cannot be longer than 20 characters!";
            }
            
            // Must not be empty
            if (empty($username)) {
                $error["username"] = "Username cannot be empty!";
            }
            
            // Prevent using symbols
            if (!ctype_alnum($username)) {
                $error["username"] = "Username should only contain numbers and/or letters!";
            }
        }

        // Email
        if ($original_email !== $user_email) {
            // Username has been changed, check if the username is available
            if (usernameExists($user_email)) {
                $error["email"] = "Email is already taken!";
            }
    
            if (empty($user_email)) {
                $error["email"] = "Email cannot be empty!";
            }
    
            // In case the user removes email type from the input field
            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                $error["email"] = "Invalid email format!"; 
            }
        }

        foreach ($error as $key => $value) {
            if (empty($value)) {
                unset($error[$key]);
            }
        }

        // Update user
        if (empty($error)) {
            if (!empty($user_password)) {
                $query = "SELECT user_password FROM users WHERE user_id = $user_id";
                $get_user = mysqli_query($connection, $query);
                confirm($get_user);
    
                $row = mysqli_fetch_array($get_user);
    
                $db_user_password = $row['user_password'];
            }
    
            $query = "UPDATE users SET ";
            $query .= "username = '{$username}', ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "user_email = '{$user_email}', ";
            // If user changed the password
            !empty($_POST['user_password']) ? $query .= "user_password = '{$user_password}', " : "";
            $query .= "user_role = '{$user_role}' ";
            $query .= "WHERE user_id = {$user_id}";
    
            $update_user = mysqli_query($connection, $query);
            confirm($update_user);
    
            echo "User updated! " . "<a href='users.php'>View users</a>";
            /* Check if the ID is the same as the person who edits these
            session_unset();
            $_SESSION['username'] = $username;
            $_SESSION['firstname'] = $user_firstname;
            $_SESSION['lastname'] = $user_lastname;
            $_SESSION['role'] = $user_role;*/
    
    
            $query = "UPDATE users SET ";
            $query .= "username = '{$username}', ";
            !empty($_POST['user_password']) ? $query .= "user_password = '{$user_password}', " : "";

            // Pusher
            $data['message'] = "A new registered user: " . $username;
            $pusher->trigger("notifications", "new_user", $data);
        }
    }
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" value="<?php echo $username; ?>" name="username">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control"  name="user_password" autcomplete="off">
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