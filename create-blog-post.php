<?php
    session_start();
    $title = "";
    $subtitle = "";
    $content = "";
    $thumbnail = "";

    // Check if it is POST request and an admin is logged in.
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username']) && isset($_SESSION['AdminId'])) {
        // Get variables from form submission.
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $content = $_POST['content'];
        $thumbnail = $_POST['thumbnail'];

        // Validate form data.
        try {
            if (!isset($title) || !is_string($title)) {
                throw new Exception("Title is not a string.");
            } else if (!isset($subtitle) || !is_string($subtitle)) {
                throw new Exception("Subtitle is not a string.");
            } else if (!isset($content) || !is_string($content)) {
                throw new Exception("Content is not a string");
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
            die($message);
        }

        // Connect to SQL server
        try {
          $dbName = getenv('CLOUDSQL_DATABASE_NAME');
             $dbConn = getenv('CLOUDSQL_CONNECTION_NAME');
             $dbUser = getenv('CLOUDSQL_USER');
             $dbPass = getenv('CLOUDSQL_PASSWORD');
             $dsn = "mysql:unix_socket=/cloudsql/${dbConn};dbname=${dbName}";
             $pdo = new PDO($dsn, $dbUser, $dbPass);
        } catch (Exception $e) {
            $message = $e->getMessage();
            die($message);
        }

        $toppost = $pdo->query("SELECT * FROM post ORDER BY postID DESC;");
        $postID = $toppost->fetch()["postID"];
        $postID = $postID + 1;
        // Get logged in user's adminId
        $adminID = $_SESSION['adminId'];

        // Get dates
        $createdAt = date("Y-m-d");
        $updatedAt = date("Y-m-d");

        // After connecting, insert a new post.
        $statement = $pdo->prepare("INSERT INTO post (postID, adminId, title, subtitle, content, createdAt, updatedAt, thumbnail) VALUES (:postID, :adminId, :title, :subtitle, :content, :createdAt, :updatedAt, :thumbnail)");
        $statement->execute([
            'postID' => $postID,
            'adminId' => $adminID,
            'title' => $title,
            'subtitle' => $subtitle,
            'content' => $content,
            'createdAt' => $createdAt,
            'updatedAt' => $updatedAt,
            'thumbnail' => $thumbnail
        ]);

        // If fininshed, redirect to home page.
        header("Location: blog-home.php");
    }
?>
