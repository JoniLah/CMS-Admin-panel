<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>
    <?php include "admin/functions.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php
                    if (isset($_POST['search'])) {
                        $search = $_POST['search'];

                        if (isset($_SESSION['username']) && isAdmin($_SESSION['username'])) {
                            $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' ORDER BY post_id DESC";
                        } else {
                            $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' AND post_status = 'published' ORDER BY post_id DESC";
                        }
                        $search_query = mysqli_query($connection, $query);

                        $count = mysqli_num_rows($search_query);
                        if ($count == 0) {
                            echo "<h2 class='text-center'>We're sorry, there's no posts available with '$search' tags!</h2>";
                        } else {
                            ?>
                            <h1 class="page-header">
                                Search Results for
                                <small><?php echo $search; ?></small>
                            </h1>
                            <?php
                            while ($row = mysqli_fetch_assoc($search_query)) {
                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];
                                $post_description = $row['post_brief'];
                                $post_author = $row['post_author'];
                                $post_user = $row['post_user'];
                                $post_date = $row['post_date'];
                                $post_image = $row['post_image'];
                                $post_content = $row['post_content'];
                                ?>

                                <!-- First Blog Post -->
                                <h2>
                                    <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                                </h2>
                                <p class="lead">
                                    by <a href="/cms/author_posts/<?php echo empty($post_author) ? $post_user : $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user; ?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                                <hr>
                                <a href="/cms/post/<?php echo $post_id ?>"><img class="img-responsive" src="img/<?php echo $post_image; ?>" alt=""></a>
                                <hr>
                                <h4><?php echo strip_tags($post_description); ?></h4>
                                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                                <hr>
                    <?php   }
                        }
                    } ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->
<?php include "includes/footer.php"; ?>
