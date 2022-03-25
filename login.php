<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'memberships');
define('DB_PORT', '3306');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

include 'init.php';

if (isset($_SESSION['auth'])) {
  redirect('home');
}

$error = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (!$email && !$password) {
    $error['email'] = "Email is required";
    $error['password'] = "Password is required";
  } elseif (!$email) {
    $error['email'] = "Email is required";
  } elseif (!$password) {
    $error['password'] = "Password is required";
  } elseif (count($error) == 0) {
    $sql = "SELECT * FROM user_list WHERE `Email`='$email' and `Password`='$password'";
    $result = mysqli_query($conn, $sql);
    if ($user = mysqli_fetch_assoc($result)) {
      $_SESSION['auth'] = [
        'email' => $user['email'],
        'password' => $user['password']
      ];
      redirect('home');
    } else {
      $error['wrong'] = "Email or password is incorrect";
    }
  }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <title>Login</title>
</head>

<body>
  <div class="container my-5">
    <div class="col-lg-6 m-auto">
      <div class="card p-5 shadow">
        <h4 class="text-center">Login Form</h4>
        <form method="POST" class="mt-4">
          <div class="form-group mb-3">
            <label for="name">Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email">

            <?php if (isset($error['email'])) { ?>
              <span class="text-danger"><?php echo $error['email']; ?></span>
            <?php } ?>
          </div>
          <div class="form-group mb-3">
            <label for="name">Password:</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password">

            <?php if (isset($error['password'])) { ?>
              <span class="text-danger"><?php echo $error['password']; ?></span>
            <?php } ?>
          </div>

          <div class="form-group mb-5">
            <?php if (isset($error['wrong'])) { ?>
              <span class="text-danger"><?php echo $error['wrong']; ?></span>
            <?php } ?>
          </div>


          <div class="text-center">
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="register.php" class="d-block mt-2">Already registered?</a>
          </div>

        </form>
      </div>
    </div>
  </div>
</body>

</html>