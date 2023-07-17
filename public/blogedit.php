<?php 
declare(strict_types = 1);
error_reporting(E_ALL);
ini_set("display_errors",'1');
session_start();
define("DD",realpath("../"));
require DD . "/public/db.php";

if ($_GET['id']) {
    $id=$_GET['id'];
    $query="SELECT * FROM blog WHERE id='$id'";

    $select=mysqli_query($db,$query);
    $editresult=mysqli_fetch_assoc($select);
    echo $editresult['category'];
   
    
}

if (!isset($_SESSION['userdata'])) {
    header('location:login.php');
}else{
    if ($_SESSION['userdata']['role'] !== 'admin' ) {
        header('location:userdashboard.php');
    }
}
$titleError='';
$selectError='';
$contentError='';
$fileError='';
if (isset($_POST['submit'])) {
    $img=$_POST['img'];
    $author=$_SESSION['userdata']['name'];
    $title=$_POST['title'];
    $id=$_POST['id'];
    $select=$_POST['select'];
    $content=$_POST['content'];
    $file=$_FILES['file'];
    $filename=$_FILES['file']['name'];
    $filetmp=$_FILES['file']['tmp_name'];
    $fileexp=explode(".",$filename);
    $fileext=end($fileexp);
    $filedir=DD ."/temple/assets/images/";
   
    if (empty($title)) {
        $titleError="You are field is required!";
    }
    if(empty($select)){
        $selectError="You are select is required!";
    }
    if (empty($content)) {
        $contentError="You are field is required!";
    }
    if (empty($filename)) {
        $updateimage=$img;
    }else{
        $newfile=md5($filename) . "." . $fileext;
        $destfile=$filedir . $newfile;
        $updateimage=$newfile;
        move_uploaded_file($filetmp,$destfile);

    }
    
   
    $query="SELECT * FROM blog WHERE id='$id'";
    $imageidcheck=mysqli_query($db,$query);
    $result=mysqli_fetch_assoc($imageidcheck);
            if (!empty($title) && !empty($select) && !empty($content)) {
                $query="UPDATE `blog` SET `image`='$updateimage',`category`='$select',`title`='$title',`content`='$content' WHERE id='$id'";
                $result=mysqli_query($db,$query);
                if ($result) {
                    $_SESSION['UpdateMsg']="You are Upadate successfully blog!";
                    header('location:blog.php');
                }
      
            }
       
    
}
function checkMineType(String $name) : bool{
    $allowedMineTypes=[
        'image/jpeg',
        'image/png',
        'image/gif',
        'application/pdf'
    ];
    if(in_array(mime_content_type($name),$allowedMineTypes)){
        return true;
    }else{
        return false;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Custom fonts for this template-->
    <link href="../temple/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../temple/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../public/index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Hornbill Blog</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="admindashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt fs-3"></i>
                    <span class="fs-5">Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="category.php">
                <i class='fas fa-calendar-alt fs-3'></i>
                    <span class="fs-5">Category</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="blog.php">
                <i class='fa fa-folder fs-3'></i>
                    <span class="fs-5">Blog</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " href="user.php">
                <i class='fas fa-user-cog fs-3'></i>
                    <span class="fs-5">User</span></a>
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle"
                                    src="../temple/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-title bg-light d-flex  justify-content-between">
                            <h4 class="p-3 text-primary fw-bold">Blog Edit Form</h4>
                            <div class="my-3 mx-3 "><a href="blog.php" class="btn btn-primary float-right" > << back </a></div>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="number" name="id" value="<?php echo $editresult['id'];?>" class="d-none">
                                <div class="form-group">
                                    <label for="title" class="form-label fs-4 text-primary">Title</label>
                                    <input type="text" class="form-control <?php if(!empty($titleError)) : ?>is-invalid <?php endif ?>" id="title" name="title" value="<?php echo $editresult['title'];?>" >
                                    <span class="text-danger fs-5 py-3"><?php echo $titleError; ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="form-label fs-4 text-primary">Category</label>
                                    <select name="select" class="form-select <?php if(!empty($selectError)) : ?> is-invalid <?php endif ?>" id="title" >
                                        <option value="">Select Category</option>
                                        <?php 
                                            $query="SELECT * FROM category";
                                            $category=mysqli_query($db,$query);
                                            foreach($category as $catlist){
                                            
                                        ?>
                                        <option value="<?php echo $catlist['name'];?>"  <?php if($editresult['category'] == $catlist['name'] ) : ?>selected<?php  endif ?> ><?php  echo $catlist['name']; ?></option>
                                        <?php } ?>       
                                    </select>
                                       
                                    <span class="text-danger fs-5 py-3"><?php echo $selectError; ?></span>

                                </div>
                                <div class="form-group">
                                    <label for="textarea" class="form-label fs-4 text-primary">Content</label>
                                    <textarea name="content" id="textarea" class="form-control <?php if(!empty($contentError)) :?>is-invalid<?php endif ?>" rows="10" ><?php echo $editresult['content'] ?></textarea>
                                    <span class="text-danger fs-5 py-3"><?php echo $contentError; ?></span>

                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label fs-4 text-primary">Image</label>
                                    <input type="file"  name="file" id="" class="form-control <?php if(!empty($fileError)) :?>is-invalid<?php endif ?>" >
                                    <span class="text-danger fs-5 py-3"><?php echo $fileError; ?></span>

                                </div>
                                <div class="form-group">
                                    
                                    <input type="text" class="form-control" name="img" value="<?php echo $editresult['image'] ;?>" >
                                    <img src="../temple/assets/images/<?php echo $editresult['image'] ;?>" alt="" style="width: 200px; height: 100px; object-fit:contain; object-position: center; " >

                                </div>
                                <button class="btn btn-primary fw-bold fs-5" name="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End of Main Content -->

          

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../temple/vendor/jquery/jquery.min.js"></script>
    <script src="../temple/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../temple/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../temple/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../temple/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../temple/js/demo/chart-area-demo.js"></script>
    <script src="../temple/js/demo/chart-pie-demo.js"></script>

</body>

</html>