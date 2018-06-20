<?php
if (isset($_POST['create_post'])) {
    $post_title = $_POST['title'];
    $post_user = $_POST['post_user'];
    $post_category_id = $_POST['post_category'];
    $post_status = $_POST['post_status'];
    $post_description = $_POST['description'];

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = $_POST['post_tags'];
    $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);
    $post_date = date('d-m-y');
    $post_comment_count = 0;

    move_uploaded_file($post_image_temp, "../img/$post_image");

    $query = "INSERT INTO posts(post_category_id, post_title, post_brief, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
    $query .= "VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, "isssssssis", $post_category_id, $post_title, $post_description, $post_user, $post_date, $post_image, $post_content, $post_tags, $post_comment_count, $post_status);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    // Returns the id (generated with AUTO_INCREMENT) used in the last query.
    $post_id = mysqli_insert_id($connection);
    echo "<p class='bg-success'>Post created! <a href='../post.php?p_id={$post_id}'>View post</a> or <a href='posts.php'>Edit other posts</a></p>";
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="description">Short Description</label> <i class="far fa-question-circle" data-toggle="tooltip" title="A short description that displays in the article preview only."></i>
        <input type="text" class="form-control" name="description">
    </div>

    <div class="form-group">
        <label for="post_category">Category</label>
        <div class="custom-select" style="width: 200px;">
            <select name="post_category" id="post_category">
                <?php
                    $cat_id_edit = $_GET['edit'];
                    if ($stmt = mysqli_prepare($connection, "SELECT cat_id, cat_title FROM categories")) {
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $cat_id, $cat_title);
                        while(mysqli_stmt_fetch($stmt)) {
                            echo "<option value='{$cat_id}'>$cat_title</option>";
                        }
                    }
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="post_user">Post Author</label>
        <div class="custom-select" style="width: 200px;">
            <select name="post_user">
                <?php
                    if ($stmt = mysqli_prepare($connection, "SELECT user_id, username FROM users")) {
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $user_id, $username);
                        ?>

                        <!-- Set our logged in user as default -->
                        <option value="<?php echo $_SESSION['username']; ?>"><?php echo $_SESSION['username']; ?></option>

                        <?php
                        while(mysqli_stmt_fetch($stmt)) {
                            if ($username !== $_SESSION['username']) {
                                echo "<option value='{$username}'>$username</option>";
                            }
                        }
                    }
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label> <i class="far fa-question-circle" data-toggle="tooltip" title="Draft is only displayed to admin users in the front page."></i>
        <div class="custom-select" style="width: 200px;">
            <select name="post_status" id="">
                <option value="draft">Select Options</option>
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label> <i class="far fa-question-circle" data-toggle="tooltip" title="Separate words with commas."></i>
        <input type="text" class="form-control" name="post_tags" placeholder="tag1, tag2, tag3">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea type="text" id="body" class="form-control" name="post_content" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>

<script src="../js/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>