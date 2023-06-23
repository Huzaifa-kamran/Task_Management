<?php 
include "config.php";

session_start();

if(! isset($_SESSION['id'])){
    echo "<script> window.location.href = 'index.php' </script>";
}

$userId = $_SESSION['id'];
$query = "SELECT * FROM `tasks` WHERE  `user_id` = $userId";
$res = mysqli_query($conn,$query);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Document</title>
    <style>
        h1{
            margin: 15px;
            position: relative;
        }
        h1::before{
            content: '';
            position: absolute;
            top: 100%;
            left: 0%;
            width: 160px;
            border-radius: 50px;
            height: 3px;
            background-color: #573b8a;
        }
        .button-link{
      text-decoration: none;
}
.task-btn {
    border: none;
    outline: none;
  background-color: #573b8a;
  padding: 7px 9px;
  border-radius: 17px;
  position: relative;
  z-index: 5;
  overflow: hidden;
  color: #fff;
  opacity: 0.8;
  transition: 0.5s all ease-in-out;
}


.task-btn:hover {
  opacity: 1;
}
#search{
  border-radius: 20px;
  padding: 5px;
  border: 1px solid #573b8a;
  outline: none;
  width: 300px;
}
.logout{
  text-decoration: underline;
  color:  #573b8a;
  font-weight: 600;
}
    </style>
</head>
<body>
  <div class="container mt-2 d-flex justify-content-between align-content-center align-items-center">
   <h5>Hi <?php echo $_SESSION['user']?> !</h5>
   <a href="logout.php" class="logout">Logout</a>
  </div>

    <div class="container mt-4 d-flex justify-content-between align-content-center align-items-center">
    <h1>Your Tasks</h1>
    <a href="add-task.php" class="button-link" >
        <button class="task-btn"> Add Task </button>
      </a>
    
    </div>
    <div class="container" id="table">
      <div><input type="search" placeholder="Search" id="search"></div>
    <?php 
  if(mysqli_num_rows($res) > 0){
    ?>
    <table class="table  table-hover able-bordered" >
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">No.</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">Due Date</th>
      <th scope="col">Edit / Delete</th>
    </tr>
  </thead>
  <tbody id="tableBody">
  <?php 
  $count = 0;
   while($row = mysqli_fetch_assoc($res)){
    $count += 1;

    if($row['completed'] == 1){
      $style = "color: rgb(20, 167, 20) !important";
      $check = "checked";
    }elseif($row['completed'] == 0){
      $style = "";
      $check = "";
      $badge = '<span class="badge text-bg-warning ms-1">In Progress</span>'; // Added this line
    }
    

  ?>
    <tr>

      <th scope="row">
      <?php if($row['completed'] == 0){
        echo '<input type="checkbox" class="task-checkbox ms-4" data-task-id="'.$row["id"].'" '.$check.'>';
        $badge = '<span class="badge text-bg-warning ms-1">In progress</span>';
      }else{
        echo '<span class="badge text-bg-success ms-1">Completed</span>';
        $badge = '<span class="badge text-bg-success ms-1">Completed</span>';
      }
      ?>
      </th>
      <th style="<?php echo $style?>" scope="row" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['id']?>"><?php echo $count ;?></th>
      <td style="<?php echo $style?>" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['id']?>"><?php echo $row['name']?></td>
      <td style="<?php echo $style?>" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['id']?>"><?php echo $row['description']?></td>
      <td style="<?php echo $style?>" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['id']?>"><?php echo $row['due_date'];?></td>
      <td>
        <a href="edit-task.php?id=<?php echo $row['id']?>"><button type="button" class="btn btn-primary">Edit</button></a>
        <a href="delete-task.php?id=<?php echo $row['id']?>"><button type="button" class="btn btn-danger ms-2">Delete</button></a>
        
      </td>


      <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal<?php echo $row['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-5" id="exampleModalLabel"><?php echo $row['name']?></h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <p class="fs-5"> <?php echo $row['description']?></p> 
      <div class="mt-5">
       Due Date: <?php echo $row['due_date']; echo $badge;?>
       
      </div>
      </div>
      <div class="modal-footer">
      <a href="edit-task.php?id=<?php echo $row['id']?>"><button type="button" class="btn btn-primary">Edit</button></a>
        <a href="delete-task.php?id=<?php echo $row['id']?>"><button type="button" class="btn btn-danger ms-2">Delete</button></a>
      </div>
    </div>
  </div>
</div>
    </tr>
    <?php 
    }
    
    ?>
  </tbody>
</table>
<?php 
}else{
  echo "<h3 class='mt-3 ms-2'>No Task</h3>";
}

?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
<script>
$(document).ready(function () {
  $(document).on("click", ".task-checkbox", function(){
    let taskId = $(this).data('task-id');

    $.ajax({
      url: 'ajax-update.php',
      method: 'POST',
      data: {
        taskId: taskId,
      },
      success: function (data) {
        $("#tableBody").html(data);
      }
    });
  });



  $('#search').on('keyup', function() {

search = $(this).val();
console.log(search);


$.ajax(

  {
    url: "ajax-search.php",
    type: "POST",
    data: {
      searchTask: search
    },
    success: function(data) {
      $("#tableBody").html(data)

    }




  }


)



})

});

</script>
</html>