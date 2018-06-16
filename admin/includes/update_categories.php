<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Update Category</label>
        <?php
            if (isset($_GET['edit'])) {
                $cat_id = $_GET['edit'];

                $stmt = mysqli_prepare($connection, "SELECT cat_id, cat_title FROM categories WHERE cat_id = ?");
                mysqli_stmt_bind_param($stmt, "i", $cat_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $cat_id, $cat_title);
                mysqli_stmt_store_result($stmt);

                while (mysqli_stmt_fetch($stmt)) {
                    ?>
                    <input class="form-control" value="<?php if (isset($cat_title)) {echo $cat_title;} ?>" type="text" name="cat_title">
        <?php   } 
            }
            
        ?>
        <?php // Update category query
            if (isset($_POST['update'])) {
                $cat_title = $_POST['cat_title'];
                $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id=?");
                mysqli_stmt_bind_param($stmt, "si", $cat_title, $cat_id);
                mysqli_stmt_execute($stmt);
                confirm($stmt);
                redirect("categories.php");
            }
        ?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update" value="Update Category">
    </div>
</form>