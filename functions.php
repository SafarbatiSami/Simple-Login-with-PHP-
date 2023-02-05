<?php
session_start();



$db = 'localhost';
$db_user = 'root';
$db_password= '';
$db_name ='login rfid';

$con=mysqli_connect($db,$db_user,$db_password,$db_name);

if(mysqli_connect_errno())
{
    exit('failed to connect to database :' . mysqli_connect_errno());
}

if($stmt=$con->prepare('SELECT id,password FROM accounts WHERE username= ?' ))
{
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows() > 0)
    {
        $stmt->bind_result($id,$password);
        $stmt->fetch();

        if($_POST['password'] === $password)
        {
            session_regenerate_id();
            $_SESSION['loggedin']= TRUE;
            $_SESSION['name']=$_POST['username'];
            $_SESSION['id']=$id;
            header('Location:../index.php');
        }else{
            echo ('incorrect password');
            header('refresh:2;url=login.html');
        }
    }else {
        echo ('incorrect username');
        header('refresh:2;url=login.html');
    }
    $stmt->close();
}


?>