<?php
session_start();
//declare variables
$username = "";
$userPassword = "";

// Check if it is POST request.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get variables from form submission.
    $username = $_POST['username'];
    $userPassword = $_POST['userPassword'];

    // Validate form data.
    try {

        if (!isset($username) || !is_string($username)) {
            throw new Exception("Enter valid username");
        }
        if (!isset($userPassword) || !is_string($userPassword)) {
            throw new Exception("Enter valid password");
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
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        $message = $e->getMessage();
        die($message);
    }

    $statement= $pdo->prepare("SELECT * FROM admin WHERE username=:username AND password=:password");
    $statement->execute([
        'username' => $username,
        'password' => $userPassword,
    ]);
    $user = $statement->fetch();
    if(isset($user)){
        $_SESSION['username'] = $user['username'];
        $_SESSION['id'] = $user['id'];
        header("Location: blog-home.php");
    } else{
        header("Location: loginForm.html");
    }
}
