<!-- ADMIN LOGIN - username: admin | password: 1111 -->
<?php

include '../components/connect.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING); 
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); 

   $select_admins = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ? LIMIT 1");
   $select_admins->execute([$name, $pass]);
   $row = $select_admins->fetch(PDO::FETCH_ASSOC);

   if($select_admins->rowCount() > 0){
      setcookie('admin_id', $row['id'], time() + 60*60*24*30, '/');
      header('location:dashboard.php');
   }else{
      $warning_msg[] = 'Incorrect Username or Password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin - Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<!-- login section starts  -->
<section class="form-container" style="min-height: 100vh;">
   <form action="" method="POST">
      <h3>Welcome Back!</h3>
      <p>Default Username = admin & Password = 1111</p>
      <input type="text" name="name" placeholder="Enter Username" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" placeholder="Enter Password" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Login Now" name="submit" class="btn">
   </form>
</section>
<!-- login section ends -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>
