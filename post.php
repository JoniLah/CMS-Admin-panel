<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "admin/functions.php"; ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php
                    if (isset($_GET['p_id'])) {
                        $post_id = $_GET['p_id'];

                        // View count
                        $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $post_id";
                        $send_query = mysqli_query($connection, $view_query);

                        // Check if we've been logged in as admin
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                            $query = "SELECT * FROM posts WHERE post_id = $post_id";
                        } else {
                            $query = "SELECT * FROM posts WHERE post_id = $post_id AND post_status = 'published'";
                        }
                        
                        $select_all_posts_query = mysqli_query($connection, $query);

                        if (mysqli_num_rows($select_all_posts_query) < 1) {
                            echo "<h2 class='text-center'>The specific post couldn't be found!</h2>";
                        } else {
                            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                                $post_title = $row['post_title'];
                                $post_author = $row['post_author'];
                                $post_user = $row['post_user'];
                                $post_date = $row['post_date'];
                                $post_image = $row['post_image'];
                                $post_content = $row['post_content'];
    
                                ?>
    
                                <h1 class="page-header">
                                    Posts
                                </h1>
    
                                <!-- First Blog Post -->
                                <h2>
                                    <a href="#"><?php echo $post_title; ?></a>
                                </h2>
                                <p class="lead">
                                    by <a href="/cms/author_posts/<?php echo empty($post_author) ? $post_user : $post_author; ?>"><?php echo empty($post_author) ? $post_user : $post_author; ?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                                <hr>
                                <img class="img-responsive" src="/cms/img/<?php echo imgPlaceholder($post_image); ?>" alt="">
                                <hr>
                                <p><?php echo $post_content; ?></p>
    
                                <hr>
                    <?php   } // end of while loop ?>
                           
                    
                <!-- Blog Comments -->

                <?php
                    if (isset($_POST['create_comment'])) {

                        $post_id = $_GET['p_id'];

                        $comment_author = mysqli_real_escape_string($connection, $_POST['comment_author']);
                        $comment_email = mysqli_real_escape_string($connection, $_POST['comment_email']);
                        $comment_content = mysqli_real_escape_string($connection, $_POST['comment_content']);

                        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($post_id, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now())";
                            $create_comment = mysqli_query($connection, $query);
                        }
                    }
                //} // This could be the problem
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form method="post" role="form">
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input class="form-control" type="text" name="comment_author">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="comment_email">
                        </div>

                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" name="comment_content" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>


                <hr>

                <!-- Posted Comments -->

                <?php

                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
                    $query .= "AND comment_status = 'approved' ";
                    $query .= "ORDER BY comment_id DESC";
                    $select_comment_query = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_array($select_comment_query)) {
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];

                        ?>

                        <!-- Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author; ?>
                                    <small><?php echo $comment_date; ?></small>
                                </h4>
                                <?php echo $comment_content; ?>
                            </div>
                        </div>

                        <?php
                    }
                ?>
                <?php
                    } // This is the ending brackets for WHILE LOOP in the post query!
                ?>
            </div>
            
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->
<?php
    // THIS IS THE ELSE STATEMENT FOR IF 'isset($_GET['p_id'])' AT THE BEGINNING OF THE FILE!
    // Redirect user and don't display anything
    } else { // this is for the isset block
        header("Location: index.php"); // Redirect the visitor if incorrect id in the url
    } 
?>
<?php include "includes/footer.php"; ?>
