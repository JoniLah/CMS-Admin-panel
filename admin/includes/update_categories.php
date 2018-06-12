<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Update Category</label>
        <?php
            if (isset($_GET['edit'])) {
                $cat_id_edit = $_GET['edit'];

                $query = "SELECT * FROM categories WHERE cat_id = $cat_id_edit";
                $select_categories_edit = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_categories_edit)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    ?>
                    <input class="form-control" value="<?php if (isset($cat_title)) {echo $cat_title;} ?>" type="text" name="cat_title">
        <?php   } 
            }
            
        ?>
        <?php // Update category query
            if (isset($_POST['update'])) {
                $cat_title_update = $_POST['cat_title'];
                $query = "UPDATE categories SET cat_title = '{$cat_title_update}' WHERE cat_id={$cat_id}";
                $update_query = mysqli_query($connection, $query);
                if (!$update_query) {
                    die("no");
                }
            }
        ?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update" value="Update Category">
    </div>
</form>