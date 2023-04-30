<?php
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':                   // URL (without file name) to a default screen
      require 'blog-home.php';
      break;
    case '/blog-home.php':     // if you plan to also allow a URL with the file name
      require 'blog-home.php';
      break;
    case '/articles/article.php':
      require 'articles/article.php';
      break;

    case '/create-blog-post.php':
      require 'create-blog-post.php';
      break;

    case '/loginForm.html':
       require 'loginForm.html';
       break;
    case '/user-login.php':
       require 'user-login.php';
       break;
    case '/user-logout.php':
       require 'user-logout.php';
       break;
   default:
      http_response_code(404);
      exit('Not Found');
}
?>
