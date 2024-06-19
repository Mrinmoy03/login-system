<?php
$login = false;
$showError = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
  include 'partials/_dbconnect.php';
  $username = $_POST["username"];
    $password = $_POST["password"];
    
  
    $sql = "Select * from users where username='$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
        if ($num == 1){
          while($row=mysqli_fetch_assoc($result)){
            if (password_verify($password, $row['password'])){

              $login = true;
              session_start();
          $_SESSION['loggedin'] = true;
          $_SESSION['username'] = $username;
          header("location: welcome.php");
            }
            else{
              $showError = "Invalid Password";
          }
          }
          
  
      } 
      else{
          $showError = "Invalid Username";
      }
    }
 

    
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <?php require 'partials/_nav.php' ?>

  <?php
 if($login){
  echo "
  <div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success</strong> You are loggedin 
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
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
  
  ?>


  <div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
      <div class="col-md-10 mx-auto col-lg-5">
        
          <form  class="p-4 p-md-5 border rounded-3 bg-body-tertiary" action="http://localhost/phpt/project/login-system/login.php" method="post">
            <div class="mb-3">
              <label for="username" class="form-label">User Name</label>
              <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" required>
            </div>

            <div class="mb-3 ">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            

            <button type="submit" class="w-100 btn btn-lg btn-primary">Login</button>
           
          </form>

      </div>
      <div class="col-lg-6">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Welcome Back to iNotes</h1>
        <h3>Give corrent USER NAME and PASSWORD to get log in</h3>
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