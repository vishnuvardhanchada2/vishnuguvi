<?php
    try{
    $jsonData=file_get_contents('php://input');
    $email=$_POST["email"];
    $password=$_POST["password"];
        require_once"database.php";
        $sql="SELECT * FROM users WHERE email='$email'";
        $result=mysqli_query($conn,$sql);
        $user=mysqli_fetch_array($result,MYSQLI_ASSOC);
        if($user){
            if( $password == $user["password"]){
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['success' => true,'email'=> $email]);
            }
            else{
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['success'=> false, 'msg'=>'password not valid']);
            }

        }
        else{
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success'=> false,'msg'=> 'user not found']);
        }
    }
    catch(Exception $e){
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success'=> false,'msg'=> $e->getMessage()]);
    }
?>
        