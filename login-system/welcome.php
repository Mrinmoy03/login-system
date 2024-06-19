<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit;
}


?>




<?php

$insert = false;
$update = false;
$delete = false;
// connect to the data base  
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
  die("Sorry we failed to connect: " . mysqli_connect_error());
}
if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `notes`.`Sl. No` = $sno";
  $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['snoEdit'])) {
    //  update the record
    $sno = $_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];
    $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`Sl. No` = $sno;";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      $update = true;
    } else {
      echo "We could not update the record successfully";
    }
  } else {
    $title = $_POST["title"];
    $description = $_POST["description"];

    // sql query to be executed
    $sql = "INSERT INTO `notes` ( `title`, `description`, `tstamp`) VALUES ('$title', '$description', current_timestamp())";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      $insert = true;
    } else {
      echo "The record was not inserted because of this error: " . mysqli_error($conn);
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
  
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>

  <title>iNotes -  <?php 
  echo $_SESSION['username'];
  ?> </title>

</head>

<body>

  <!-- edit modal -->

  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Edit this note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/phpt/project/crud/index.php" method="POST">
          <div class="modal-body">

            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="titleEdit" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" />
            </div>
            <div class="mb-3">
              <label for="descriptionEdit" class="form-label">Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div>

            

          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- nav bar -->
  <?php require 'partials/_nav_logout.php' ?>

  <!-- alert for successful data insertion -->
  <?php
  if ($insert) {
    echo "
  <div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success</strong> Your note has been submitted successfully!
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>
  ";
  }
  ?>
  <?php
  if ($delete) {
    echo "
  <div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!!</strong> Your note has been deleted successfully!
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>
  ";
  }
  ?>
  <?php
  if ($update) {
    echo "
  <div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!!</strong> Your note has been updated successfully!
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>
  ";
  }
  ?>

  <!-- note input form -->
  <div class="container my-5">
    <h2>Add a note</h2>
    <form action="/phpt/project/crud/index.php" method="POST">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>

  <!-- note display and edit  -->
  <div class="container my-4">

    <!-- table -->
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sl. No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Time</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php

        // fetching data from database
        $sql = "SELECT * FROM `notes`";
        $sno = 0;
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
          $sno = $sno + 1;
          echo "<tr>
      <th scope='row'>" .  $sno .   "</th>
      <td>" . $row['title'] . "</td>
      <td>" . $row['description'] . "</td>
      <td>" . $row['tstamp'] . "</td>
      <td><button class='edit btn btn-sm btn-primary' id=" . $row['Sl. No'] . ">Edit</button> <button class='delete btn btn-sm btn-primary' id=d" . $row['Sl. No'] . ">Delete</button></td>
    </tr>";
        }

        ?>
      </tbody>
    </table>

  </div>

  <hr>

  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ", e);
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');
      });
    });

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("delete");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `/phpt/project/crud/index.php?delete=${sno}`;


        } else {
          console.log("no");
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>