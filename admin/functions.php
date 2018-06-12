<?php

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


?>