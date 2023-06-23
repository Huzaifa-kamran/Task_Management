<?php 
include "config.php";
session_start();

if(isset($_POST['taskId'])){
  $id = $_POST['taskId'];

  $taskQuery = "SELECT * FROM `tasks` WHERE `id` = $id";
  $taskRes = mysqli_query($conn, $taskQuery);
  $data = mysqli_fetch_assoc($taskRes);

  // Toggle the completion status of the task
  $completed = $data['completed'] == 1 ? 0 : 1;
  $update = "UPDATE `tasks` SET `completed` = $completed WHERE `id` = $id";
  $updateQuery = mysqli_query($conn, $update);

  $userId = $_SESSION['id'];
  $query = "SELECT * FROM `tasks` WHERE `user_id` = $userId";
  $res = mysqli_query($conn, $query);
  $output = "";

  $count = 0;

  while($row = mysqli_fetch_assoc($res)){
      $count += 1;

      if($row['completed'] == 1){
          $style = 'color: rgb(20, 167, 20) !important';
          $check = 'checked';
          $badge = '<span class="badge text-bg-success ms-1">Completed</span>';
      } else {
          $style = '';
          $check = '';
          $badge = '<span class="badge text-bg-warning ms-1">In Progress</span>';
      }

      $output .=  '<tr style="'.$style.'">
      <th scope="row">';
      
      if($row['completed'] == 0){
          $output .= '<input type="checkbox" class="task-checkbox ms-4" data-task-id="'.$row["id"].'" '.$check.'>';
      } else {
          $output .= $badge;
      }

      $output .=  '</th>
      <th style="'.$style.'" scope="row" data-bs-toggle="modal" data-bs-target="#exampleModal'.$row['id'].'">'.$count.'</th>
      <td style="'.$style.'" data-bs-toggle="modal" data-bs-target="#exampleModal'.$row['id'].'">'.$row["name"].'</td>
      <td style="'.$style.'" data-bs-toggle="modal" data-bs-target="#exampleModal'.$row['id'].'">'.$row["description"].'</td>
      <td style="'.$style.'" data-bs-toggle="modal" data-bs-target="#exampleModal'.$row['id'].'">'.$row["due_date"].'</td>
      <td>
          <a href="edit-task.php?id='.$row["id"].'"><button type="button" class="btn btn-primary">Edit</button></a>
          <a href="delete-task.php?id='.$row["id"].'"><button type="button" class="btn btn-danger ms-2">Delete</button></a>
      </td>

      <div class="modal fade" id="exampleModal'.$row["id"].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h2 class="modal-title fs-5" id="exampleModalLabel">'.$row["name"].'</h2>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <p class="fs-5">'.$row["description"].'</p> 
                      <div class="mt-5">
                          Due Date:'.$row["due_date"].' '.$badge.'
                      </div>
                  </div>
                  <div class="modal-footer">
                      <a href="edit-task.php?id='.$row["id"].'"><button type="button" class="btn btn-primary">Edit</button></a>
                      <a href="delete-task.php?id='.$row["id"].'"><button type="button" class="btn btn-danger ms-2">Delete</button></a>
                  </div>
              </div>
          </div>
      </div>
      </tr>';
  }
  echo $output;
}


?>