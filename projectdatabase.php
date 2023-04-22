<?php
try
{
  $connString = "mysql:host=article-dabase.czvgalvp0qdu.us-west-2.rds.amazonaws.com; dbname=article_db";
  $user = "admin";
  $pass = "password";
  $pdo = new PDO($connString, $user, $pass);
}
catch(PDOException $e )
{
  die($e->getMessage());
}
  echo "Connection Established\n";

  // This is for verifying the passed information where the passed information is username and userPassword
  $resultAdmin = $pdo->query("SELECT id FROM admin WHERE username = 'CSUSM' && password = '123654';");

  // Because we are grabbing ONLY the primary key,
  // there is no while loop necessary
  echo $resultAdmin->fetch()["id"] . "<br/>";


  // This one needs a while loop as it will select multiple rows
  $homePost = $pdo->query("SELECT * FROM post;");

  while($result = $homePost->fetch()) // While there are posts to fetch
  {
    // Perform functions that read all the data and create a proper barrier for them
    $title = $result["title"];
    echo $title . "<br/>";

    $subtitle = $result["subtitle"];
    echo $subtitle . "<br/>";

    $content = $result["content"];
    echo $content . "<br/>";

    $createdAt = $result["created_at"];
    echo $createdAt . "<br/>";

    $updatedAt = $result["updated_at"];
    echo $updatedAt . "<br/>";

    $thumbnail = $result["thumbnail_photo"];
    echo $thumbnail . "<br/>";
  }
  // This query grabs all values in the row that has the postID called
  $articlePost = $pdo->query("SELECT * FROM post WHERE id = '1001';");

  $articleResult = $articlePost->fetch();
  // Perform functions that read all the data and create a proper barrier for them
  $articleTitle = $articleResult["title"];
  echo $articleTitle . "<br/>";

  $articlesubtitle = $articleResult["subtitle"];
  echo $articleSubtitle . "<br/>";

  $articleContent = $articleResult["content"];
  echo $articleContent . "<br/>";

  $articleCreatedAt = $articleResult["created_at"];
  echo $articleCreatedAt . "<br/>";

  $articleUpdatedAt = $articleResult["updated_at"];
  echo $articleUpdatedAt . "<br/>";

  $articleThumbnail = $articleResult["thumbnail_photo"];
  echo $articleThumbnail . "<br/>";
?>
