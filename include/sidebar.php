<?php
$query_categories = "SELECT * FROM categories";

$categories = $db->query($query_categories);

?>
<div class="col-md-4 mb-3">



    <div class="list-group mb-3">
        <a href="#" class="list-group-item list-group-item-action active">
            categories
        </a>
        <?php
        if ($categories->rowCount() > 0) {
            foreach ($categories as $category) {
                ?>
                <a href="index.php?category=<?php echo $category['id'] ?>" class="list-group-item list-group-item-action">
                    <?php echo $category['title'] ?>
                </a>
                <?php
            }
        }

        ?>

    </div>





</div>
