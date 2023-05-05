<?php
include("./include/header.php");
include ("./include/db.php");

$query_categories = "SELECT * FROM categories";
$categories = $db->query($query_categories);

$user_email = $_SESSION['email'];

// Construct your SQL query
$sql = "SELECT id, name, email FROM subscribers WHERE email = '$user_email'";

// Execute the query and store the result set in a variable
$result = mysqli_query($conn, $sql);

// Check if there are any results returned from the query
if (mysqli_num_rows($result) > 0) {
    // Access the first row in the result set since there should be only one subscriber with this email
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['id'];
    $username = $row['name'];
} else {
    echo "No subscriber found with this email.";
}

// Close the database connection
mysqli_close($conn);

if (isset($_POST['add_post'])) {
    if (trim($_POST['title']) != "" && trim($_POST['category_id']) != "" && trim($_POST['body']) != "" && trim($_FILES['image']['name']) != "") {
        $title = $_POST['title'];
        $author = $username;
        $author_id = $user_id;
        $category_id = $_POST['category_id'];
        $body = $_POST['body'];
        $name_image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        if (move_uploaded_file($tmp_name, "../upload/posts/$name_image")) {
            echo "Upload Success";
        } else {
            echo "Upload Error";
        }

        $post_insert = $db->prepare("INSERT INTO posts (title, author, author_id, category_id, body, image) VALUES (:title , :author , :author_id , :category_id, :body, :image)");
        $post_insert->execute(['title' => $title,'author_id'=> $author_id, 'author' => $author, 'category_id' => $category_id, 'body' => $body, 'image' => $name_image]);

        header("Location:post.php");
        exit();
    } else {
        header("Location:new_post.php?err_msg= fields should filled");
        exit();
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between mt-5">
                <h3>Create</h3>
            </div>
            <hr>

            <?php if (isset($_GET['err_msg'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['err_msg'] ?>
                </div>
            <?php } ?>

            <form method="post" class="mb-5" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="category">Title : </label>
                    <input type="text" class="form-control" name="title" id="title">
                    <small class="form

                    <small class="form-text text-muted">insert the author .</small>
                </div>
                <div class="form-group">
                    <label for="category_id">Categories : </label>
                    <select class="form-control" name="category_id" id="category_id">
                        <?php
                        if ($categories->rowCount() > 0) {
                            foreach ($categories as $category) {
                                ?>
                                <option value="<?php echo $category['id'] ?>"> <?php echo $category['title'] ?> </option>

                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Body: </label>
                    <textarea class="form-control" name="body" id="body" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="author">image : </label>
                    <input type="file" class="form-control" name="image" id="image">
                    <small class="form-text text-muted">upload image.</small>
                </div>

                <button type="submit" name="add_post" class="btn btn-outline-primary">create</button>
            </form>

        </main>

    </div>

</div>

</body>
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('body');
</script>

</html>
