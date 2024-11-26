<!-- INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Nighter', 'Pull out nighter today', current_timestamp()); -->
<?php
// Connect to database
$server = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($server, $username, $password, $database);

//_____________________________________________________________________________________________________________________
// Post into table
$insert = false;
$update = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST["snoEdit"])) {
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];
    $sno = $_POST["snoEdit"];
    // add a new row into the notes
    $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $sno;";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      $update = true;
    }
  } elseif (isset($_POST["snoDelete"])) {
    $sno = $_POST["snoDelete"];
    // delete a row from the notes
    $sql = "DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
    $result = mysqli_query($conn, $sql);
  } else {
    $title = $_POST["title"];
    $description = $_POST["description"];

    // add a new row into the notes
    $sql = "INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, '$title', '$description', current_timestamp());";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      $insert = true;
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <title>inote - notes taking made easier</title>
</head>

<body>
  <!-- Button trigger modal -->
  <!-- Modal edit -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/crud/index.php?update=true" method="POST">
            <input type="hidden" class="hidden" id="snoEdit" name="snoEdit" />
            <div class="form-group">
              <label for="title">Note Title</label>
              <input
                type="Text"
                class="form-control"
                id="titleEdit"
                name="titleEdit"
                aria-describedby="emailHelp"
                placeholder="Enter Note - title" />
            </div>
            <div class="form-group">
              <label for="description">Note Description</label>
              <textarea
                class="form-control"
                id="descriptionEdit"
                name="descriptionEdit"
                rows="3"
                placeholder="Enter Note - Description"></textarea>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Delete -->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Delete Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/crud/index.php?delete=true" method="POST">
            <input type="hidden" class="hidden" id="snoDelete" name="snoDelete" />
            <h6 class="mb-3">The note will be deleted Permanentaly</h6>
            <button type="submit" class="btn btn-danger">Delete note</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Inote</a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link disabled"
            href="#"
            tabindex="-1"
            aria-disabled="true">Contact Us</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input
          class="form-control mr-sm-2"
          type="search"
          placeholder="Search"
          aria-label="Search" />
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
          Search
        </button>
      </form>
    </div>
  </nav>
  <?php
  if ($insert) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>

  <div class="container mt-5">
    <h2>Add a Note</h2>
    <form action="/crud/index.php" method="POST">
      <div class="form-group">
        <label for="title">Note Title</label>
        <input
          type="Text"
          class="form-control"
          id="title"
          name="title"
          aria-describedby="emailHelp"
          placeholder="Enter Note - title" />
      </div>
      <div class="form-group">
        <label for="description">Note Description</label>
        <textarea
          class="form-control"
          id="description"
          name="description"
          rows="3"
          placeholder="Enter Note - Description"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add</button>
    </form>
  </div>

  <div class="container mt-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sno</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        $order = 1;
        if ($num > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
        <th scope='row'>" . $order . "</th>
        <td>" . $row['title'] . "</td>
        <td>" . $row['description'] . "</td>
        <td><button type='button' class='btn text-dark text-strong btn-info edit btn-outline-success btn-sm' data-toggle='modal' id=" . $row['sno'] . " data-target='#editModal' id='edit' >
          Edit
        </button> <button type='button' class='btn text-dark text-strong btn-danger delete btn-outline-success btn-sm' data-toggle='modal' id=" . $row['sno'] . " data-target='#deleteModal'>
          Delete
        </button></td>
      </tr>";
            $order++;
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <hr>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach(element => {
      element.addEventListener("click", (e) => {
        console.log("edit ", );
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        descriptionEdit.value = description;
        titleEdit.value = title;
        snoEdit.value = e.target.id;
        $('#editModal').modal('toggle')
      })
    });
  </script>
  <script>
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach(element => {
      element.addEventListener("click", (d) => {
        console.log("delete ", );
        tr = d.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        snoDelete.value = d.target.id;
        $('#deleteModal').modal('toggle')
      })
    });
  </script>
</body>

</html>