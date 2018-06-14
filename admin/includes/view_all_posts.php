<?php

    if (isset($_POST['checkBoxArray'])) {
        foreach($_POST['checkBoxArray'] as $key) {
            $bulk_options = $_POST['bulk_options'];
            switch($bulk_options) {
                case "published":
                    $query = "UPDATE posts SET post_status = '$bulk_options' WHERE post_id = $key";
                    mysqli_query($connection, $query);
                    break;
                case "draft":
                    $query = "UPDATE posts SET post_status = '$bulk_options' WHERE post_id = $key";
                    mysqli_query($connection, $query);
                    break;
                case "clone":
                    $query = "SELECT * FROM posts WHERE post_id = '$key'";
                    $select_posts = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_array($select_posts)) {
                        $post_title = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_date = $row['post_date'];
                        $post_author = $row['post_author'];
                        $post_user = $row['post_user'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tags = $row['post_tags'];
                        $post_content = $row['post_content'];
                    }
                    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_status, post_image, post_tags, post_content) ";
                    $query .= "VALUES($post_category_id, '$post_title', '$post_author', now(), '$post_status', '$post_image', '$post_tags', '$post_content')";
                    $copy_query = mysqli_query($connection, $query);
                    confirm($copy_query);
                    break;
                case "delete":
                    $query = "DELETE FROM posts WHERE post_id = $key";
                    mysqli_query($connection, $query);
                    break;
            }
        }
    }

?>

<form action="" method="post">
    <table class="table table-bordered table-hover table-striped">
        <div id="bulkOptionsContainer" class="col-xs-4" style="padding: 0px;">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="clone">Clone</option>
                <option value="delete">Delete</option>
            </select>
        </div>

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>

        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>ID</th>
                <th>User/Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Views</th>
                <th>Date</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = "SELECT * FROM posts ORDER BY post_id DESC";
                $select_posts = mysqli_query($connection, $query);
        
                while ($row = mysqli_fetch_assoc($select_posts)) {
                    $post_id = $row['post_id'];
                    $post_user = $row['post_user'];
                    $post_author = $row['post_author'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comment_count= $row['post_comment_count'];
                    $post_date = $row['post_date'];
                    $post_views_count = $row['post_views_count'];
                    
                    echo "<tr>";
                    ?>
                    <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>
                    <?php
                    
                    echo "<td>{$post_id}</td>";

                    if (!empty($post_author)) {
                        echo "<td>{$post_author}</td>";
                    } else if (!empty($post_user)) {
                        echo "<td>$post_user</td>";
                    }
   
                    echo "<td>{$post_title}</td>";

                    $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                    $select_categories_id = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_categories_id)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                    }
                    echo !empty($cat_title) ? "<td>{$cat_title}</td>" : "<td></td>";

                    echo "<td>{$post_status}</td>";
                    echo "<td><img width='100' src='../img/{$post_image}' alt=''></td>";
                    echo "<td>{$post_tags}</td>";

                    // Count the post comment count
                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                    $comment_count_query = mysqli_query($connection, $query);
                    confirm($comment_count_query);
                    $row = mysqli_fetch_array($comment_count_query);
                    $comment_id = $row['comment_id'];
                    $count_comments = mysqli_num_rows($comment_count_query);

                    echo "<td><a href='post_comments.php?id={$post_id}'>{$count_comments}</a></td>";
                    echo "<td>{$post_views_count}</td>";
                    echo "<td>{$post_date}</td>";
                    echo "<td><a href='../post.php?p_id=$post_id'>View Post</a></td>";
                    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this item?');\" href='posts.php?delete={$post_id}'>Delete</a></td>";
                    echo "</tr>";
                }  
            ?>
        </tbody>
    </table>
</form>

<?php
    if (isset($_GET['delete'])) {

        $post_id_delete = $_GET['delete'];

        $query = "DELETE FROM posts WHERE post_id = {$post_id_delete}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: posts.php");
    }
?>