<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/cms/admin">CMS Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <!-- OLD WAY <li><a href="#">Users Online: <?php //echo usersOnline(); ?></a></li> -->
        <li><a href="#"><i class="fas fa-user-secret"></i> Admins Online: <span class="users-online"></span></a></li>
        <li><a href="/cms">Home</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['firstname'] . " "; echo $_SESSION['lastname']; ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="/cms/admin/profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li>
                    <a href="settings.php"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts-dropdown"><i class="fas fa-newspaper"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts-dropdown" class="collapse">
                    <li>
                        <a href="posts.php"><i class="fas fa-search"></i> View All Posts</a>
                    </li>
                    <li>
                        <a href="posts.php?source=add_post"><i class="fas fa-plus-circle"></i> Add Post</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="./categories.php"><i class="fas fa-book-open"></i> Categories</a>
            </li>
            <li>
                <a href="./comments.php"><i class="fas fa-comment-dots"></i> Comments</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#users-dropdown"><i class="fas fa-users"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="users-dropdown" class="collapse">
                    <li>
                        <a href="users.php"><i class="fas fa-search"></i> View All Users</a>
                    </li>
                    <li>
                        <a href="users.php?source=add_user"><i class="fas fa-user-plus"></i> Add User</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="profile.php"><i class="fas fa-user-tie"></i> Profile</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>