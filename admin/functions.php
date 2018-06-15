<?php

    // Security function
    function escape($string) {
        global $connection;
        mysqli_real_escape_string($connection, trim($string));
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
                $query = "INSERT INTO categories(cat_title) VALUES('{$cat_title}')";
                $create_category_query = mysqli_query($connection, $query);

                if (!$create_category_query) {
                    die("<h2>Query couldn't be executed - " . mysqli_error($connection));
                }
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

    function checkStatus($table, $column, $status) {
        global $connection;
        $query = "SELECT * FROM $table WHERE $column = '$status'";
        $result = mysqli_query($connection, $query);
        confirm($result);
        return mysqli_num_rows($result);
    }


?>