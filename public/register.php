<?php 
session_start();
date_default_timezone_set('Asia/Yangon');
define("DD",realpath("../"));
require DD . "/public/db.php";
if (isset($_POST['register'])) {

    $name=$_POST['name'];
    $email=$_POST['email'];
    $address=$_POST['address'];
    $password=$_POST['password'];
    $comfirmpassword=$_POST['comfirmpassword'];
    $NameError='';
    $EmailError='';
    $AddressError='';
    $PasswordError='';
    $ComfirmPasswordError='';
    if (empty($name)) {
       $NameError="You must field is required!";
    }
    if (empty($email)) {
        $EmailError="You must field is required!";
     }
     if (empty($address)) {
        $AddressError="You must field is required!";
     }
     if (empty($password)) {
        $PasswordError="You must field is required!";
     }
     if (empty($comfirmpassword)) {
        $ComfirmPasswordError="You must field is required!";
     }elseif ($password !== $comfirmpassword) {
        $ComfirmPasswordError="You password does not match!";
     }
 

    // Insert data 
     if ( !empty($name) && !empty($email) && !empty($address) && !empty($password) && !empty($comfirmpassword) && $password == $comfirmpassword) {
           //  select data 
            $query="SELECT email FROM `registerlist` WHERE email='$email'";
            $select=mysqli_query($db,$query);
            $result=mysqli_fetch_assoc($select);
            $selectemail=$result['email'];
            if ($email == $selectemail) {
                $EmailError="You are email already taken!";
            }else{
                $encryptpassword=md5($password);
             // select data 
                $query="INSERT INTO registerlist (name,email,address,password) Value('$name','$email','$address','$encryptpassword')";
                $result=mysqli_query($db,$query);
                if ($result) {
                $_SESSION['successMsg']="You are register successfully!";
                
                header('location:login.php');
                }
            }
         
     }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <!-- bootstrap cdn  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <section class="register vh-100" id="register" style="background-color: #508bfc;">
        <div class="container h-100">
            <div class="row h-100 d-flex justify-content-center align-items-center">
                <div class="col-md-3"></div>
                <div class="col-md-6 ">
                    <div class="card py-3 shadow shadow-sm rounded rounded-3">
                        <div class="card-header">
                            <div class="card-title justify-content-center align-items-center">
                                <h3 class="text-center">Register Form</h3>
                                <div style="background-color: #508bfc; height:4px; width:250px; margin:0 auto; margin-top:20px;" class="rounded rounded-2"></div>
                                <hr>
                            </div>
                            <div class="card-body">
                                <form action="register.php" method="post">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" class="form-control <?php if(!empty($NameError)) : ?>is-invalid<?php endif ?>" name="name" placeholder="Enter Your Name" value="<?php echo $name;?>">
                                        <h6 class="text-danger p-1"><?php echo $NameError; ?></h6>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" class="form-control <?php if(!empty($EmailError)) : ?>is-invalid<?php endif ?>" name="email" placeholder="Enter Your Email" value="<?php echo $email;?>">
                                        <h6 class="text-danger p-1"><?php echo $EmailError; ?></h6>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea name="address" id="address"  rows="3" class="form-control <?php if(!empty($AddressError)) : ?>is-invalid<?php endif ?>" placeholder="Enter Your Address"><?php echo $address;?></textarea>
                                        <h6 class="text-danger p-1"><?php echo $AddressError; ?></h6>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" id="password" class="form-control <?php if(!empty($PasswordError)) : ?>is-invalid<?php endif ?>" name="password"  placeholder="Enter Your Password" value="<?php echo $password;?>">
                                        <h6 class="text-danger p-1"><?php echo $PasswordError; ?></h6>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="comfirmpassword" class="form-label">Comfirm Password</label>
                                        <input type="password" id="comfirmpassword" class="form-control <?php if(!empty($ComfirmPasswordError)) : ?>is-invalid<?php endif ?>" name="comfirmpassword"  placeholder="Enter Your Comfirm Password" value="<?php echo $comfirmpassword;?>">
                                        <h6 class="text-danger p-1"><?php echo $ComfirmPasswordError; ?></h6>
                                    </div>
                                    <button class="btn btn-primary float-end mb-3 " name="register">Register</button>
                                </form>
                             
                                <span class="d-block mt-4">If You have already account! <a href="login.php">Login Here</a></span>
                            </div>               
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </section>

<!-- bootstrap cdn  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>   
</body>
</html>