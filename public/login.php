<?php 
session_start();
define("DD",realpath("../"));
require DD . "/public/db.php";
if(isset($_POST['login'])){
    $EmailError='';
    $PasswordError='';
    $email=trim($_POST['email']);
    $password=trim($_POST['password']);
    $encryptpassword=md5($password);
    $Error='';
    if (empty($email)) {
        $EmailError="You must field is required!";
     }
    if (empty($password)) {
        $PasswordError="You must field is required!";
    }
    if (!empty($email) && !empty($password)) {
    $query="SELECT * FROM registerlist WHERE email='$email' AND password='$encryptpassword'";
    $result=mysqli_query($db,$query);
   
    $select=mysqli_num_rows($result);
    if($select == 1){
       $data=mysqli_fetch_assoc($result);
       $_SESSION['userdata']=$data;
       if ($data['role'] == 'admin' || $data['role'] == 'user') {
        header('location:index.php');
       }
    }else{
        $Error = "You are email or password wrong!";
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
                                <h3 class="text-center">Login Form</h3>
                                <div style="background-color: #508bfc; height:4px; width:250px; margin:15px auto; " class="rounded rounded-2"></div>
                                <!-- Success Msg  -->
                                <?php if(isset($_SESSION['successMsg'])): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php 
                                    echo $_SESSION['successMsg'];
                                    unset($_SESSION['successMsg']);
                                    ?>
                                    
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php endif; ?>
                                <!-- Success Msg  -->
                                <?php if(!empty($Error)) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php 
                                        echo $Error;

                                    ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php endif; ?>
                                <hr>
                            </div>
                            <div class="card-body">
                                <form action="login.php" method="post">
                                  
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" class="form-control <?php if(!empty($EmailError)) : ?>is-invalid<?php endif ?>" name="email" placeholder="Enter Your Email" value="<?php echo $email;?>">
                                        <h6 class="text-danger p-1"><?php echo $EmailError; ?></h6>
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" id="password" class="form-control <?php if(!empty($PasswordError)) : ?>is-invalid<?php endif ?>" name="password"  placeholder="Enter Your Password" value="<?php echo $password;?>">
                                        <h6 class="text-danger p-1"><?php echo $PasswordError; ?></h6>
                                    </div>
                                   
                                    <button class="btn btn-primary float-end mb-3 " name="login">Login</button>
                                </form>
                             
                                <span class="d-block mt-4">If You have not account yet! <a href="register.php">Register Here</a></span>
                            </div>               
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </section>
<!-- sweet alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- bootstrap cdn  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>   
</body>
</html>