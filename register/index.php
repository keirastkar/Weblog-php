<!-- CSS styles for the table -->

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.rtl.min.css"
          integrity="sha384-T5m5WERuXcjgzF8DAb7tRkByEZQGcpraRTinjpywg37AO96WoYN9+hrhDVoM6CaT" crossorigin="anonymous">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            margin-top: 100px;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;

        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../index.php">My weblog</a>
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="./index.php">Dashboard</a>
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="./new_post.php">Create post</a>

    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="./logout.php">Exit</a>
        </li>

    </ul>
</nav>
</body>

<?php
session_start();

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weblog";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the user is not logged in, redirect them to the login page
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// If a post has been marked for deletion, delete it from the database
if (isset($_POST['delete_post'])) {
    $post_id = $_POST['post_id'];
    $delete_sql = "DELETE FROM posts WHERE id = $post_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Post deleted successfully!";
    } else {
        echo "Error deleting post: " . $conn->error;
    }
}

// Retrieve the user's posts from the database
$email = $_SESSION['email'];
$sql = "SELECT * FROM posts WHERE author_id=(SELECT id FROM subscribers WHERE email='$email') and status = 1 ";
$result = $conn->query($sql);

// Display the user's posts on the dashboard page
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Title</th><th>Content</th><th >Setting</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='width: 10%'>" . $row["title"] . "</td>";

        // Limit content preview
        $content_preview = implode(' ', array_slice(str_word_count($row["body"], 1), 0, 500));

        echo "<td>" . $content_preview . "...</td>";
        echo "<td >";
        echo "<div class='d-flex'>";
        echo "<form action='' method='POST'><input type='hidden' name='post_id' value='" . $row['id'] . "'><button class='btn btn-outline-danger me-2' type='submit' name='delete_post'>Delete</button></form>";
        echo "<a href='edit_post.php?id=" . $row['id'] . "' class='btn btn-outline-info btn-sm ' style='margin-left: 5px; height: 38px !important;justify-content: center !important;'>Edit</a>";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "You have no posts.";
}

?>
