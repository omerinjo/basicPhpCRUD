<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PHP CRUD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
  <?php require_once 'process.php';?>
  <div class="container">
  <?php   
     require_once 'config.php';
     $mysqli = new mysqli($host,$user,$password, $database) or die( mysqli_error($mysqli));
     $resoult = $mysqli->query("SELECT * FROM data") or die($mysqli->error);    
 ?>
 <?php   
  if(isset($_SESSION['message'])):?>
   <div class="alert alert-<?=$_SESSION['msg_type']?>"> 
     <?php 
        echo $_SESSION['message']; 
        unset($_SESSION['message']);
        ?>
   </div>
   <?php endif ?>
    <div class="row justify-content-center"> 
       <table class="table">
          <thead>
          <tr>
             <th>id</th>
            <th>Name</th>
            <th>Last name</th>
            <th>Email</th>
            <th colspan="2">Action</th>
          </tr>
          </thead>
       <?php  
          while ($row = $resoult->fetch_assoc()): ?> 
       <tr>
         <td><?php echo $row['id']; ?></td>
         <td><?php echo $row['name']; ?></td>
         <td><?php echo $row['last_name']; ?></td>
         <td><?php echo $row['email']; ?></td>
         <td>
           <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn btn-info" >Edit</a>
           <a href="process.php?delete=<?php echo $row['id'];?>" class="btn btn-danger">Delete </a>
  </td>
       </tr>  
        <?php endwhile; ?>
       </table>
   </div>
 <?php   
       pre_r($resoult->fetch_assoc());
     function pre_r($array){
       echo '<prev>';
       print_r($array);
       echo '</prev>';
     }
   ?>
   <div class="row justify-content-center">
    <form action="process.php" method="POST">
   <input  type="hidden" name="id" value=<?php echo $id ?>/> 
      <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value=<?php echo $name; ?>  >
      </div>
      <div class="form-group">
         <label>Last name</label>
         <input type="text" class="form-control" name="lastName"  value=<?php echo $lastName; ?> >
      </div>
      <div class="form-group">
         <label>Email</label>
         <input type="text" class="form-control" name="email"  value=<?php echo $email; ?>  >
      </div>
      <div class="form-group">
      <?php  
      if($update==true): 
      ?>
        <button type="submit" class="btn btn-info" name="update">Update</button>
      <?php else :?>
        <button type="submit" class="btn btn-primary" name="save">Save</button>
        <?php endif ?>
      </div>
    </form>
  </div> 
  </div> 
</body>
</html>