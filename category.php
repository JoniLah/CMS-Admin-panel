<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include_once "admin/functions.php"; ?>
<?php 
    if (isset($_GET['category'])) {
        $post_category_id = $_GET['category'];
    }
?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                    <?php
                        $title_query = mysqli_query($connection, "SELECT cat_title FROM categories WHERE cat_id = $post_category_id");
                        while ($row = mysqli_fetch_assoc($title_query)) {
                            if (isset($_SESSION['username']) && isAdmin($_SESSION['username'])) {
                                $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id ORDER BY post_id DESC";
                            } else {
                                $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id AND post_status = 'published' ORDER BY post_id DESC";
                            }
                            $select_all_posts_query = mysqli_query($connection, $query);
                            if (mysqli_num_rows($select_all_posts_query) > 0) {
                                echo $cat_title = $row['cat_title'];
                            }
                            
                        }
                    ?>
                </h1>

                <?php

                    if (isset($_GET['category'])) {

                        // Check if we've been logged in as admin
                        if (isset($_SESSION['username']) && isAdmin($_SESSION['username'])) {
                            $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? ORDER BY post_id DESC");

                        } else if ((isset($_SESSION['username']) && !isAdmin($_SESSION['username'])) || (!isset($_SESSION['username']))) {
                            $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ? ORDER BY post_id DESC");
                            $published = "published";
                        }

                        if (isset($stmt1)) {
                            mysqli_stmt_bind_param($stmt1, "i", $post_category_id);
                            mysqli_stmt_execute($stmt1);
                            mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_user, $post_date, $post_image, $post_content);
                            $stmt = $stmt1;
                            mysqli_stmt_store_result($stmt);
                        } else {
                            mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_user, $post_date, $post_image, $post_content);
                            $stmt = $stmt2;
                            mysqli_stmt_store_result($stmt);
                        }

                        if (mysqli_stmt_num_rows($stmt) < 1) {
                            echo "<h2 class='text-center'>We're sorry, there's no posts available!</h2>";
                        }
                            while (mysqli_stmt_fetch($stmt)):
                                ?>
    
                                <!-- First Blog Post -->
                                <h2>
                                    <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                                </h2>
                                <p class="lead">
                                    by <a href="/cms/author_posts/<?php echo empty($post_author) ? $post_user : $post_author; ?>&p_id/<?php echo $post_id; ?>"><?php echo $post_user; ?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                                <hr>
                                <img class="img-responsive" src="img/<?php echo $post_image; ?>" alt="">
                                <hr>
                                <p><?php echo $post_content; ?></p>
                                <a class="btn btn-primary" href="/cms/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
    
                                <hr>
                            <?php endwhile; mysqli_stmt_close($stmt);
                        } else { // no categories
                            header("Location: /cms/");
                        }?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->
<?php include "includes/footer.php"; ?>
