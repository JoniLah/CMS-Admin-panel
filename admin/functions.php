<?php

    function redirect($location) {
        header("Location: " . $location);
        exit;
    }

    // Checks for POST or GET methods
    function ifMethod($method = null) {
        return $_SERVER['REQUEST_METHOD'] == strtoupper($method) ? true: false;
    }

    function isLoggedIn() {
        return isset($_SESSION['role']) ? true : false;
    }

    function redirectLoggedInUser($redirectLocation = null) {
        isLoggedIn() ? redirect($redirectLocation) : "";
    }

    function confirm($result) {
        global $connection;
        if (!$result) {
            die("Query Failed - " . mysqli_error($connection));
        }
    }

    function insertCategories() {
        global $connection;
        if (isset($_POST['submit'])) {
            $cat_title = $_POST['cat_title'];
            if (strlen($cat_title) > 0) {
                $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?)");
                mysqli_stmt_bind_param($stmt, "s", $cat_title);
                mysqli_stmt_execute($stmt);
                confirm($stmt);
                echo "<h2>{$cat_title} added!</h2>";
            } else {
                echo "<h2>Category cannot be blank!</h2>";
            }
        }
    }

    function findAllCategories() {
        global $connection;
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_categories)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

            echo "<tr>";
            echo "<td>{$cat_id}</td>";
            echo "<td>{$cat_title}</td>";
            echo "<td><a href=\"categories.php?edit={$cat_id}\">Edit</a></td>";
            echo "<td><a href=\"categories.php?delete={$cat_id}\">Delete</a></td>";
            echo "</tr>";
        }
    }

    function deleteCategory() {
        global $connection;
        if (isset($_GET['delete'])) {
            $cat_id_delete = $_GET['delete'];
            $query = "DELETE FROM categories WHERE cat_id={$cat_id_delete}";
            $delete_query = mysqli_query($connection, $query);
            header("Location: categories.php");
        }
    }

    function usersOnline() {
        // Detect the JavaScript AJAX call
        if (isset($_GET['onlineusers'])) {
            global $connection;
            if (!$connection) {
                // Set session and retrieve database if there's no connection
                session_start();
                include("../includes/db.php");

                $session = session_id();
                $time = time();
                $time_out_in_seconds = 5;
                $time_out = ($time - $time_out_in_seconds);

                $query = "SELECT * FROM users_online WHERE session = '$session'"; // Confirm the correct user
                $session_query = mysqli_query($connection, $query);
                $count_user_time = mysqli_num_rows($session_query); // Counts the time and session for each user

                // If the user is new, add new row for the corresponding user
                if ($count_user_time == null) {
                    mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session', '$time')");
                } else { // Else just add the time for its session
                    mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
                }

                // Count the amount of users online
                $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
                echo $count_user = mysqli_num_rows($users_online_query);
            }  
        }
    }
    usersOnline(); // Call the function

    // Retrieves the count of defined item
    function recordCount($table) {
        global $connection;
        $select_all_items = mysqli_query($connection, "SELECT * FROM " . $table);
        confirm($select_all_items);
        return $result = mysqli_num_rows($select_all_items);
    }

    // Check the table status of defined column
    function checkStatus($table, $column, $status) {
        global $connection;
        $query = "SELECT * FROM $table WHERE $column = '$status'";
        $result = mysqli_query($connection, $query);
        confirm($result);
        return mysqli_num_rows($result);
    }

    function isAdmin($username) {
        global $connection;
        $query = "SELECT user_role FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query);
        confirm($result);

        $row = mysqli_fetch_array($result);
        return $row['user_role'] == "admin" ? true : false;
    }

    function usernameExists($username) {
        global $connection;
        if ($stmt = mysqli_prepare($connection, "SELECT username FROM users WHERE username = ?")) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            return mysqli_stmt_num_rows($stmt) > 0 ? true : false;
        }
    }

    function emailExists($email) {
        global $connection;
        if ($stmt = mysqli_prepare($connection, "SELECT user_email FROM users WHERE user_email = ?")) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            return mysqli_stmt_num_rows($stmt) > 0 ? true : false;
        }
    }

    function registerUser($username, $email, $password) {
        global $connection;

        // Add security to the code
        $username = mysqli_real_escape_string($connection, $username);
        $password = mysqli_real_escape_string($connection, $password);
        $email = mysqli_real_escape_string($connection, $email);

        // An improved way to crypt the password
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

        $query = "INSERT INTO users(username, user_password, user_email, user_role) VALUES ('$username', '$password', '$email', 'subscriber')";
        mysqli_query($connection, $query);
    }

    function loginUser($username, $password) {
        global $connection;

        // Remove whitespaces and prevent SQL Injection with escape
        $username = trim(mysqli_real_escape_string($connection, $username));
        $password = trim(mysqli_real_escape_string($connection, $password));

        $query = "SELECT * FROM users WHERE username = '$username'";
        $select_user_query = mysqli_query($connection, $query);
        confirm($select_user_query);

        while ($row = mysqli_fetch_array($select_user_query)) {
            $db_user_id = $row['user_id'];
            $db_username = $row['username'];
            $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_role = $row['user_role'];

            // We're logged in
            if (password_verify($password, $db_user_password)) {
                $_SESSION['user_id'] = $db_user_id;
                $_SESSION['username'] = $db_username;
                $_SESSION['firstname'] = $db_user_firstname;
                $_SESSION['lastname'] = $db_user_lastname;
                $_SESSION['role'] = $db_user_role;
                $result = mysqli_query($connection, "SELECT * FROM user_settings WHERE user_settings_id = $db_user_id");
                confirm($result);
                while ($row = mysqli_fetch_array($result)) {
                    $redirection = $row['user_redirection'];
                    $redirection == "admin" ? redirect("/cms/admin") : redirect("/cms");
                }
            } else {
                return false;
            }
        }
    }

    function imgPlaceholder($img = null) {
        return !$img ? $_SERVER['DOCUMENT_ROOT'] . "/cms/img/placeholder-images.jpg" : $img; 
    }
    
?>