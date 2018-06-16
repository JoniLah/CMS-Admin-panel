<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms">Home</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php

                    $query = "SELECT * FROM categories";
                    $select_all_categories_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];

                        // Empty classes for non-active links in the navigation
                        $category_class = "";
                        $registration_class = "";
                        $contact_class = "";

                        // Check which page we're at
                        $page_name = basename($_SERVER['PHP_SELF']);

                        // Set the active class for the active link in the navigation
                        if (isset($_GET['category']) && $_GET['category'] == $cat_id) {
                            $category_class = "active";
                        } else if ($page_name == "registration.php") {
                            $registration_class = "active";
                        } else if ($page_name == "contact.php") {
                            $contact_class = "active";
                        }

                        echo "<li class='$category_class'><a href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";
                    }


                ?>
                <li class="vl"></li> <!-- Separator -->
                <?php if (!isset($_SESSION['role'])): ?>
                    <li class="<?php echo $registration_class; ?>"><a href="/cms/registration">Registration</a></li>
                <?php endif; ?>
                <li class="<?php echo $contact_class; ?>"><a href="/cms/contact">Contact</a></li>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <li><a href="/cms/admin">Admin</a></li>
                <?php endif; ?>
                
                <?php
                    if (isset($_SESSION['role'])) {
                        if (isset($_GET['p_id']) && $_SESSION['role'] === "admin") {  
                            $p_id = $_GET['p_id'];
                            echo "<li><a href='admin/posts.php?source=edit_post&p_id=$p_id'>Edit Post</a></li>";
                        }
                    }
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>