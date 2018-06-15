<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

                    if (isset($_GET['category'])) {
                        $post_category_id = $_GET['category'];

                        // Check if we've been logged in as admin
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                            $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id ORDER BY post_id DESC";
                        } else {
                            $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id AND post_status = 'published' ORDER BY post_id DESC";
                        }

                        $select_all_posts_query = mysqli_query($connection, $query);

                        if (mysqli_num_rows($select_all_posts_query) < 1) {
                            echo "<h2 class='text-center'>We're sorry, there's no posts available!</h2>";
                        } else {
                            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];
                                $post_author = $row['post_author'];
                                $post_user = $row['post_user'];
                                $post_date = $row['post_date'];
                                $post_image = $row['post_image'];
                                $post_content = substr($row['post_content'], 0, 150); // Substract to 0 char to 150
    
                                ?>
    
                                <h1 class="page-header">
                                    <?php
                                        $title_query = mysqli_query($connection, "SELECT cat_title FROM categories WHERE cat_id = $post_category_id");
                                        while ($row = mysqli_fetch_assoc($title_query)) {
                                            echo $cat_title = $row['cat_title'];
                                        }
                                    ?>
                                </h1>
    
                                <!-- First Blog Post -->
                                <h2>
                                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                                </h2>
                                <p class="lead">
                                    by <a href="index.php"><?php echo $post_user; ?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                                <hr>
                                <img class="img-responsive" src="img/<?php echo $post_image; ?>" alt="">
                                <hr>
                                <p><?php echo $post_content; ?></p>
                                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
    
                                <hr>
                    <?php   } // end of while loop
                        } // end of else statement                    
                    } else { // no categories
                        header("Location: index.php");
                    }?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->
<?php include "includes/footer.php"; ?>
