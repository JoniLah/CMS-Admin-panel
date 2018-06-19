<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include_once "admin/functions.php"; ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                
                <h1 class="page-header">
                    CMS Front-end
                    <small>Articles</small>
                </h1>

                <?php

                    // Pagination init
                    $per_page = $GLOBALS['per_page']; // Posts per page
                    // Check the page url parameter
                    isset($_GET['page']) ? $page = $_GET['page'] : $page = null;
                    // Set the numbers for pagination buttons
                    ($page == null || $page == 1) ? $page_1 = 0 : $page_1 = ($page * $per_page) - $per_page;

                    // Check if we've been logged in as admin
                    if (isset($_SESSION['username']) && isAdmin($_SESSION['username'])) {
                        $post_query_count = "SELECT * FROM posts"; // Count the posts
                    } else {
                        //TODO: PREPARED STATEMENT
                        $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'"; // Count the posts
                    }

                    $find_post_count_query = mysqli_query($connection, $post_query_count);
                    $total_count = $count = mysqli_num_rows($find_post_count_query);

                    if ($count < 1) {
                        echo "<h2 class='text-center'>We're sorry, there's no posts available!</h2>";
                    } else {
                        $count = ceil($count / $per_page);

                        if (isset($_SESSION['username']) && isAdmin($_SESSION['username'])) {
                            $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_1, $per_page";
                        } else {
                            $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $page_1, $per_page";
                        }
                        $select_all_posts_query = mysqli_query($connection, $query);

                        while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_user = $row['post_user'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = substr($row['post_content'], 0, 150); // Substract to 0 char to 150
                            $post_status = $row['post_status'];


                            ?>

                            <!-- First Blog Post -->
                            <h2>
                                <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                            </h2>
                            <p class="lead">
                            by <a href="/cms/author_posts/<?php echo empty($post_author) ? $post_user : $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo empty($post_author) ? $post_user : $post_author; ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                            <hr>
                            <a href="post.php?p_id=<?php echo $post_id ?>"><img class="img-responsive" src="img/<?php echo imgPlaceholder($post_image); ?>" alt=""></a>
                            <hr>
                            <p><?php echo $post_content ?></p>
                            <a class="btn btn-primary" href="/cms/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                            <hr>
                        <?php 
                        } // end of while loop
                    } // end of else statement ?>

            <hr>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <!-- Pagination -->
        <?php include "includes/pagination.php"; ?>

<?php include "includes/footer.php"; ?>
