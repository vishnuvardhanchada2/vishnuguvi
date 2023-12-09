        <?php
        $jsonData=file_get_contents('php://input');
        $json=$_POST;
        $fullname=$json["fullname"];
        $email=$json["email"];
        $password=$json["password"];
        $passwordRepeat=$json["repeat_password"];
        $passwordHash=password_hash($password,PASSWORD_DEFAULT);
                $errors=array();
                if(empty($fullname) or empty($email) or empty($password) or empty($passwordRepeat)){
                    array_push($errors,"All fields are required");
                }
                if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                    array_push($errors,"Email is not valid");
                }
                if(strlen($password) < 8){
                    array_push($errors,"Password must be atleast 8 letters");
                }
                if($password != $passwordRepeat){
                    array_push($errors,"Password does not match");
                }
                require_once"database.php";
                $sql="SELECT * FROM users WHERE email='$email'";
                $result=mysqli_query($conn,$sql);
                $rowcount=mysqli_num_rows($result);
                if($rowcount> 0){
                    array_push($errors,"Email already exist");
                }
                if(count($errors) > 0){
                    foreach($errors as $error){
                        echo"<div class='alert alert-danger'>$error</div>";
                    }
                }
                else{
                    require_once"database.php";
                    $sql="INSERT INTO users (full_name,email,password)VALUES(?, ?, ?)";
                    $stmt=mysqli_stmt_init($conn);
                    $preparestmt=mysqli_stmt_prepare($stmt, $sql);
                    if($preparestmt){
                        mysqli_stmt_bind_param($stmt,"sss", $fullname, $email, $password);
                        mysqli_stmt_execute($stmt);
                        $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
                            $bulk = new MongoDB\Driver\BulkWrite;
                            $bulk->insert(['fullname' => $fullname, '_id' => $email,'address'=>' ','phno'=>' ','gender'=>' ','dob'=>' ']);

                            $manager->executeBulkWrite('mydb.user', $bulk);
                        $data ="registration sucessfull";
                        header('Content-Type: application/json; charset=utf-8');
                        echo json_encode($data);
                    }
                    else{
                        die("something went wrong in");
                    }
                }
        ?>