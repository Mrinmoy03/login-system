<?php
$passwordError = false;
$showAlert = false;
$showError = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
  include 'partials/_dbconnect.php';
  $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $exists=false;
    // check whether username is already exsits or not 
    $existSql = "SELECT * FROM `users` WHERE  username = '$username'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if($numExistRows >0){
      // $exists = true;
      $showError = "Username Already Exists";
    }
    else{
      $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

 
    
    if(($password == $cpassword)){
      if (!preg_match($password_pattern, $password)) {
        $passwordError = true;
    }else{
      
    
      $hash = password_hash($password, PASSWORD_DEFAULT );
        $sql = "INSERT INTO `users` ( `username`, `password`, `dt`) VALUES ('$username', '$hash', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        if ($result){
            $showAlert = true;
            
        }
      }
    }else{
      $showError = "Passwords should be same , type carefully!";
    }
  }
 
}
    
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <?php require 'partials/_nav.php' ?>

  <?php
 if($showAlert){
  echo "
  <div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success</strong> Your account hasbeen created , You can now login!
  <button type='submit' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>
  ";
 
  }
 if($showError){
  echo "
  <div class='alert alert-danger alert-dismissible fade show' role='alert'>
  <strong>ERROR!</strong> $showError 
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>
  ";
  }
  
 if($passwordError){
  echo "
  <div class='alert alert-danger alert-dismissible fade show' role='alert'>
  <strong>ERROR!</strong>Password must have at least 8 character length with mimimum 1 uppercase, 1 lowercase, 1 number and 1 special characters
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>
  ";
  }
  
  ?>


  <div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
      <div class="col-md-10 mx-auto col-lg-5">
        
          <form  class="p-4 p-md-5 border rounded-3 bg-body-tertiary" action="http://localhost/phpt/project/login-system/home.php" method="post">
            <div class="mb-3">
              <label for="username" class="form-label">User Name</label>
              <input type="text" maxlength="30" class="form-control" id="username" name="username" aria-describedby="emailHelp" required>
            </div>

            <div class="mb-3 ">
              <label for="password" class="form-label">Password</label>
              <input type="password" maxlength="30" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 ">
              <label for="cpassword" class="form-label">Confirm Password</label>
              <input type="password" maxlength="30" class="form-control" id="cpassword" name="cpassword" required>
            </div>

            <button type="submit" class="w-100 btn btn-lg btn-primary">SignUp</button>
            <hr class="my-4">
            <small class="text-body-secondary">By clicking Sign up, you agree to the terms of use.</small>
          </form>

      </div>
      <div class="col-lg-6">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Welcome to iNotes</h1>
        <h3>Your Ultimate Note-Taking Companion</h3>
        <hr>
        <p class="lead">iNotes is the perfect tool for organizing your thoughts, ideas, and tasks. Whether you're at home, at work, or on the go, iNotes ensures that you never miss a beat.
          With iNotes, managing your tasks and ideas has never been easier. Join thousands of users who trust iNotes to keep their lives organized.

        </p>

      </div>
    </div>
  </div>






















  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html> 