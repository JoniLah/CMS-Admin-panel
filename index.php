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
                
                <h1 class="page-header">
                    CMS Front-end
                    <small>Articles</small>
                </h1>

                <?php

                    $per_page = 5; // Posts per page

                    // Check the page url parameter
                    if (isset($_GET['page'])) {    
                        $page = $_GET['page'];
                    } else {
                        $page = null;
                    }

                    if ($page == null || $page == 1) {
                        $page_1 = 0;
                    } else {
                        $page_1 = ($page * $per_page) - $per_page;
                    }

                    // Check if we've been logged in as admin
                    if (isset($_SESSION['username']) && isAdmin($_SESSION['username'])) {
                        $post_query_count = "SELECT * FROM posts"; // Count the posts
                    } else {
                        //TODO: PREPARED STATEMENT
                        $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'"; // Count the posts
                    }

                    $find_post_count_query = mysqli_query($connection, $post_query_count);
                    $count = mysqli_num_rows($find_post_count_query);

                    if ($count < 1) {
                        echo "<h2 class='text-center'>We're sorry, there's no posts available!</h2>";
                    } else {
                        $count = ceil($count / $per_page);

                        $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_1, $per_page";
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
                                <a href="post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                            </h2>
                            <p class="lead">
                            by <a href="author_posts.php?author=<?php echo empty($post_author) ? $post_user : $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo empty($post_author) ? $post_user : $post_author; ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                            <hr>
                            <a href="post.php?p_id=<?php echo $post_id ?>"><img class="img-responsive" src="img/<?php echo $post_image; ?>" alt=""></a>
                            <hr>
                            <p><?php echo $post_content ?></p>
                            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

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
        <ul class="pager"> 
            <?php
                // Previous (last page) button
                if ($page <= 1) {
                    echo '<li class="disabled"><a><i class="fas fa-angle-double-left"></i></a></li>';
                    echo '<li class="disabled"><a><i class="fas fa-angle-left"></i></a></li>';
                } else {
                    $page_prev = $page - 1;
                    echo '<li><a href="index.php"><i class="fas fa-angle-double-left"></i></a></li>';
                    echo "<li><a href='index.php?page={$page_prev}'><i class='fas fa-angle-left'></i></a></li>";
                }

                // Keeps the number of page buttons to 5 at all times
                $min_page = $page - 2;
                $max_page = $page + 2;

                if ($min_page < 2) {
                    $max_page = 5;
                }

                if ($page == $count) {
                    $min_page = $min_page - 2;
                } else if ($page == ($count - 1)) {
                    $min_page = $min_page - 1;
                }

                if ($min_page < 1) {
                    $min_page = 1;
                }

                if ($max_page > $count) {
                    $max_page = $count;
                }

                // Page buttons
                for ($i = $min_page; $i <= $max_page; $i++) {
                    if ($i == $page) {
                    echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                    } else {
                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                    }
                }
                
                // Next page button
                if ($page >= $count) {
                    echo '<li class="disabled"><a><i class="fas fa-angle-right"></i></a></li>';
                    echo "<li class='disabled'><a><i class='fas fa-angle-double-right'></i></a></li>";
                } else {
                    $page_next = $page + 1;
                    echo "<li><a href='index.php?page={$page_next}'><i class='fas fa-angle-right'></i></a></li>";
                    echo "<li><a href='index.php?page={$count}'><i class='fas fa-angle-double-right'></i></a></li>";
                }
            ?>
        </ul>

<?php include "includes/footer.php"; ?>
