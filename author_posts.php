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

                    // Pagination init
                    $per_page = $GLOBALS['per_page']; // Posts per page
                    // Check the page url parameter
                    isset($_GET['page']) ? $page = $_GET['page'] : $page = null;
                    // Set the numbers for pagination buttons
                    ($page == null || $page == 1) ? $page_1 = 0 : $page_1 = ($page * $per_page) - $per_page;

                    if (isset($_GET['p_id'])) {
                        $post_id = $_GET['p_id'];
                        $post_author_url = $_GET['author'];
                    }

                    $query = "SELECT * FROM posts WHERE post_author = '$post_author_url' OR post_user = '$post_author_url' ORDER BY post_id DESC";
                    $select_all_posts_query = mysqli_query($connection, $query);
                    $total_count = $count = mysqli_num_rows($select_all_posts_query);

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $count = ceil($count / $per_page);
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];

                        ?>

                        <h1 class="page-header">
                            Posts
                            <small>by <?php echo $post_user; ?></small>
                        </h1>

                        <!-- First Blog Post -->
                        <h2>
                            <a href="/cms/post/"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            All posts by <?php echo empty($post_author) ? $post_user : $post_author; ?>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                        <hr>
                        <img class="img-responsive" src="/cms/img/<?php echo $post_image; ?>" alt="">
                        <hr>
                        <p><?php echo $post_content ?></p>
                        <a class="btn btn-primary" href="/cms/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>
            <?php   } ?>
                <!-- Blog Comments -->

                <?php
                    if (isset($_POST['create_comment'])) {

                        $post_id = $_GET['p_id'];

                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];

                        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($post_id, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now())";
                            $create_comment = mysqli_query($connection, $query);

                            // Increment the comment count of the post
                            $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $post_id";
                            $increment_comment_count = mysqli_query($connection, $query);
                        }
                    }
                ?>
                <hr>
            </div>

            

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <!-- Pagination -->
        <?php include "includes/pagination.php"; ?>

<?php include "includes/footer.php"; ?>
