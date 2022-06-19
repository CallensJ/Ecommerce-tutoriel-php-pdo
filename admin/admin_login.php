<?php
include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING); // Remove all HTML tags from a string:
    $pass = sha1($_POST['password']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING); //Remove all HTML tags from a string:


    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
    $select_admin -> execute([$name, $pass]);
    

    if($select_admin->rowCount() > 0 ){
        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        $message[] = 'login working';
       
    }else{
        $message[] = 'incorrect username or password!';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <!--font awesome cdn link -->
    <link rel="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <!-- custom css file -->
    <link rel="stylesheet" href="../css/admin_style.css" />
</head>


?>
<body>


<?php
if(isset($message)){
    foreach($message as $message){
        echo '
        <div class = "message ">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

    <!-- admin login form section start -->

    <section class="form-container">
    <i class="fas fa-times">
        <form action="" method="POST">
            <h3>login now </h3>
            <p>default username = <span>admin</span> & password = <span>111</span></p>
            <input type="text" name="name" maxlength="20" requiredplaceholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="text" name="password" maxlength="20" requiredplaceholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type ="submit" value="login now" name="submit" class ="btn" />
        </form>
        
    </section>

    <!-- admin login form section ends -->
</body>

</html>