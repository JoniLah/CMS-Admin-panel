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