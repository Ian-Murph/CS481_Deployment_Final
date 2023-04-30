<?php
  // Authors: Josue Gallardo, Antonio Rojas, Justin Yum
  session_start();
  //Declare Variables
  $postID = '';
  $title = '';
  $subtitle = '';
  $content = '';
  $date = '';
  $thumbnail = "images/";
//Try to connect to SQL server
try
{
  $dbName = getenv('CLOUDSQL_DATABASE_NAME');
     $dbConn = getenv('CLOUDSQL_CONNECTION_NAME');
     $dbUser = getenv('CLOUDSQL_USER');
     $dbPass = getenv('CLOUDSQL_PASSWORD');
     $dsn = "mysql:unix_socket=/cloudsql/${dbConn};dbname=${dbName}";
     $pdo = new PDO($dsn, $dbUser, $dbPass);
}
catch(PDOException $e )
{
  die($e->getMessage());
}
// After connecting, grab all articles from the SQL server and create block sets for each one
$homePost = $pdo->query("SELECT * FROM post ORDER BY postID DESC;");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/home-style.css">
    <title>CSUSM Blog</title>
</head>
<body>
    <h1>CSUSM Blog StartUp</h1>
    <header class="header">
        <a href="blog-home.php" class="logo"><span>CSUSM</span>Blog</a>
        <nav class="navbar">
            <a href="blog-home.php">Home</a>
            <?php if (isset($_SESSION['username']) && isset($_SESSION['id'])): ?>
              <a href="blog-create.php">Create Post</a>
              <a href="user-logout.php">Logout</a>
            <?php else: ?>
              <a href="loginForm.html">Login</a>
            <?php endif; ?>
        </nav>
        <form action="" class="search-form">
            <input type="search" placeholder="Search" id="search-box">
            <label for="search-box" class="fas fa-search"></label>
        </form>
    </header>

    <section class="container" id="posts">
        <div class="post-container">

            <?php
              while($posts = $homePost->fetch())
              {
                $postID = strval($posts["id"]);

                $title = $posts["title"];

                $subtitle = $posts["subtitle"];

                $content = $posts["content"];
                $content = substr($content, 0, 100);
                $content = $content . "...";

                $date = $posts["updated_at"];

                $thumbnail = $posts["thumbnail_photo"];

                echo "<div class='post'> <form action = 'articles/article.php' method = 'GET' > <input type = 'hidden' name = 'articleID' value = " . $postID . "> </input>";
                echo "<input type='image' src='" . $thumbnail . "' alt='Not found' class='image'>";
                echo "<div class='date'> <i class='far fa-clock'></i> <span>". $date ."</span> </div>";
                echo "<h3 class='title'>" . $title . "</h3>";
                echo "<p> " . $content . "</p>";
                echo "<a href='#' class='user'> <i class='far fa-user' ></i> <span>" . $subtitle . "</span> </a> </form> </div>";
              }
            ?>
        </div>
    </section>
</body>
</html>
