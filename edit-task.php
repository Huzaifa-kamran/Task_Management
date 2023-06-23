<?php
include "config.php";
session_start();

if(! isset($_SESSION['id'])){
    echo "<script> window.location.href = 'index.php' </script>";
}

if(isset($_GET['id'])){
	$taskId = $_GET['id'];
    $taskQuery = "SELECT * FROM `tasks` WHERE  `id` = $taskId";
     $taskRes = mysqli_query($conn,$taskQuery);
     $data = mysqli_fetch_assoc($taskRes);
	}
	



	if(isset($_POST['update'])){
    $id = $_POST['id'];
    $taskName = $_POST['name'];
	$taskDesc = $_POST['desc'];
	$date = $_POST['date'];
	$userId = $_SESSION['id'];
	
	

    if (empty($date)) {
        $update = "UPDATE `tasks` SET `name` = '$taskName', `description` = '$taskDesc' WHERE `tasks`.`id` = $id";
    } else {
        $update = "UPDATE `tasks` SET `name` = '$taskName', `description` = '$taskDesc', `due_date` = '$date' WHERE `tasks`.`id` = $id";
    }

	$res = mysqli_query($conn,$update);
    if($res){
        echo "<script> alert('Task Update Successfully.') </script>";
            echo "<script> window.location.href = 'task.php' </script>";
    }else{
        echo "<script> alert('An error occurred while updating the Task.') </script>";
            echo "<script> window.location.href = 'edit-task.php?uptID=$taskId' </script>";
    }
	
    }
	?>




<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link rel="stylesheet" href="style.css"> -->
	<title>Document</title>
</head>
<style>
	body {
		background-color: #fff !important;
		margin: 0;
		padding: 0;
		display: flex;
		justify-content: center;
		align-items: center;
		min-height: 100vh;
		font-family: 'Jost', sans-serif;
	}

	.main {
		width: 350px;
		height: 500px;
		background: red;
		overflow: hidden;
		background: url("https://doc-08-2c-docs.googleusercontent.com/docs/securesc/68c90smiglihng9534mvqmq1946dmis5/fo0picsp1nhiucmc0l25s29respgpr4j/1631524275000/03522360960922298374/03522360960922298374/1Sx0jhdpEpnNIydS4rnN4kHSJtU1EyWka?e=view&authuser=0&nonce=gcrocepgbb17m&user=03522360960922298374&hash=tfhgbs86ka6divo3llbvp93mg4csvb38") no-repeat center/ cover;
		border-radius: 10px;
		background-color: #573b8a;
		box-shadow: 5px 20px 50px #000;
	}

	#chk {
		display: none;
	}

	.signup {
		position: relative;
		width: 100%;
		height: 100%;
	}

	label {
		color: #fff;
		font-size: 2.3em;
		justify-content: center;
		display: flex;
		margin: 60px;
		font-weight: bold;
		cursor: pointer;
		transition: .5s ease-in-out;
	}

   .inp {
		width: 60%;
		height: 20px;
		background: #e0dede;
		justify-content: center;
		display: flex;
		margin: 20px auto;
		padding: 10px;
		border: none;
		outline: none;
		border-radius: 5px;
	}

	button {
		width: 60%;
		height: 40px;
		margin: 10px auto;
		justify-content: center;
		display: block;
		color: #573b8a;
		background: #fff;
		font-size: 1em;
		font-weight: bold;
		margin-top: 20px;
		outline: none;
		border: none;
		border-radius: 5px;
		transition: .2s ease-in;
		cursor: pointer;
		opacity: 0.9;
	}
	#textArea{
		height: 80px;
	}
    .date-span{
        color: #fff;
        margin-left: 18%;
    }

	button:hover {
		opacity: 1;
	}

	.login {
		height: 460px;
		background: #eee;
		border-radius: 60% / 10%;
		transform: translateY(-180px);
		transition: .8s ease-in-out;
	}

	.login label {
		color: #573b8a;
		transform: scale(.6);
	}

	#chk:checked~.login {
		transform: translateY(-500px);
	}

	#chk:checked~.login label {
		transform: scale(1);
	}

	#chk:checked~.signup label {
		transform: scale(.6);
	}
</style>

<body>
	<div class="main">
		<input type="checkbox" id="chk" aria-hidden="true">
		<div class="signup">
			<form method="POST" action="edit-task.php">
				<label for="chk" aria-hidden="true">Add Task</label>
				<input type="hidden" name="id"  value="<?php echo $data['id'];?>">
				<input type="text" class="inp" name="name" placeholder="Task Name"  value="<?php echo $data['name'];?>">
				<textarea  name="desc" id="textArea" class="inp" placeholder="Enter Description"><?php echo $data['description'];?></textarea>
                <span class="date-span">Due Date: <?php echo $data['due_date'];?> </span>
				<input type="date" id="dueDate" name="date" class="inp" <?php echo $data['due_date'];?>>
				<button type="submit" name="update">Update</button>
			</form>
		</div>
	</div>
</body>
<script>

  let today = new Date().toISOString().split('T')[0];
  let dueDateInput = document.getElementById('dueDate');

  dueDateInput.setAttribute('min', today);
</script>
</html>