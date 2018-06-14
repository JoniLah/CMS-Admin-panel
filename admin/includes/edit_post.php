<?php

    if (isset($_GET['p_id'])) {
        $p_id = $_GET['p_id'];
    }

    $query = "SELECT * FROM posts WHERE post_id = $p_id";
    $select_posts_by_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_author = $row['post_user'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment_count= $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_content = $row['post_content'];
    }

    if (isset($_POST['update_post'])) {

        $post_user = $_POST['post_user'];
        $post_title = $_POST['title'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];

        move_uploaded_file($post_image_temp, "../img/$post_image");

        // If user didn't reupload a picture, use the old one
        if (empty($post_image)) {
            $query = "SELECT * FROM posts WHERE post_id = $p_id";
            $select_image = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_array($select_image)) {
                $post_image = $row['post_image'];
            }
        }

        $query = "UPDATE posts SET ";
        $query .= "post_title = '{$post_title}', ";
        $query .= "post_category_id = '{$post_category_id}', ";
        $query .= "post_date = now(), ";
        $query .= "post_user = '{$post_user}', ";
        $query .= "post_status = '{$post_status}', ";
        $query .= "post_tags = '{$post_tags}', ";
        $query .= "post_content = '{$post_content}', ";
        $query .= "post_image = '{$post_image}' ";
        $query .= "WHERE post_id = {$post_id}";

        $update_post = mysqli_query($connection, $query);

        confirm($update_post);

        echo "<p class='bg-success'>Post updated! <a href='../post.php?p_id={$post_id}'>View post</a> or <a href='posts.php'>Edit other posts</a></p>";
        
    }
    

    
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" value="<?php echo $post_title; ?>" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="post_category">Category</label>
        <select name="post_category" id="post_category">
            <?php
                $cat_id_edit = $_GET['edit'];

                $query = "SELECT * FROM categories";
                $select_categories_edit = mysqli_query($connection, $query);

                confirm($select_categories_edit);

                echo "<option value='$username'>$username</option>";

                while ($row = mysqli_fetch_assoc($select_categories_edit)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    echo "<option value='{$cat_id}'>$cat_title</option>";
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_user">Post Author</label>
        <select name="post_user">
            <?php
                $query = "SELECT * FROM users";
                $select_users = mysqli_query($connection, $query);
                confirm($select_users);
                ?>
                <!-- Set our logged in user as default -->
                <option value="<?php echo $_SESSION['username']; ?>"><?php echo $_SESSION['username']; ?></option>
                <?php

                while ($row = mysqli_fetch_assoc($select_users)) {
                    $user_id = $row['user_id'];
                    $username = $row['username'];

                    echo "<option value='{$username}'>$username</option>";
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <select name="post_status" id="">
            <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
            <?php
                if($post_status == "published") {
                    echo "<option value='draft'>draft</option>";
                } else {
                    echo "<option value='published'>published</option>";
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <img width="100" src="../img/<?php echo $post_image; ?>" alt="">
        <label for="post_image">Post Image</label>
        <input type="file"  name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" value="<?php echo $post_tags; ?>" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea type="text" id="" class="form-control" name="post_content" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>
</form>