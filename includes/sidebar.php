<?php

    if (ifMethod("post")) {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            loginUser($_POST['username'], $_POST['password']);
        } else {
            redirect("/cms/");
        }
    }

?>

<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form> <!-- search form-->
        <!-- /.input-group -->
    </div>

    <!-- Login Well -->
    <div class="well">
        <?php
            // Shorthand method for if statement
            if(isset($_SESSION['role'])):
        ?>
            <h4>Logged in as <?php echo $_SESSION['username']; ?></h4>
            <a href="includes/logout.php" class="btn btn-primary">Logout</a>

        <?php else: ?>
            <h4>Login</h4>
            <form method="post">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Username">
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Password">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">Submit
                        </button>
                    </span>
                </div>
            </form> <!-- search form-->
            <!-- /.input-group -->
        <?php endif; ?>
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <?php
            $query = "SELECT * FROM categories";
            $select_categories_sidebar_query = mysqli_query($connection, $query);
        ?>
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                        while ($row = mysqli_fetch_assoc($select_categories_sidebar_query)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];

                        echo "<li><a href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "widget.php"; ?>

</div>