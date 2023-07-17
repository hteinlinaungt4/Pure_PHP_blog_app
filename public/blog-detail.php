<?php 
session_start();
define("DD",realpath("../"));
require DD ."/public/db.php";
if (!isset($_SESSION['userdata'])) {
    header('location:login.php');
}

if(isset($_GET['blogid'])){
    $id=$_GET['blogid'];
    $query="SELECT * FROM blog WHERE id='$id'";
    $blogresult=mysqli_query($db,$query);
    $blog=mysqli_fetch_assoc($blogresult);
}

if(isset($_POST['submit'])){
    $msg=$_POST['msg'];
    $userid=$_POST['userid'];
    $postid=$_POST['postid'];
    if(!empty($msg)){
        $query="INSERT INTO comment(postid,userid,message) VALUES('$postid','$userid','$msg ')";
        mysqli_query($db,$query);
        
    }
   
}

$postid=$blog['id'];

$query="SELECT * FROM comment 
INNER JOIN blog ON comment.postid = blog.id
INNER JOIN registerlist ON comment.userid = registerlist.id  
WHERE blog.id=$postid
";
$comment=mysqli_query($db,$query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>blogging system</title>
    <!-- bootstrap cdn  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- custom css  -->
    <link rel="stylesheet" href="../temple/assets/css/app.css">
    <!-- aos  -->
    <link rel="stylesheet" href="../temple/assets/aos/aos.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="index.php" data-aos="fade-right" data-aos-duration="2000">Hornbill Blog</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" data-aos="fade-left" data-aos-duration="2000">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Sign In</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Sign Up</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>


    <div id="blog-detail">
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-8">
                    <h3 data-aos="fade-right" data-aos-duration="2000">Blog Detail</h3>
                    <div class="heading-line" data-aos="fade-left" data-aos-duration="2000"></div>
                    <div class="card my-3" data-aos="zoom-in" data-aos-duration="2000">
                        <div class="card-body p-0">
                            <div class="img-wrapper">
                                <img src="../temple/assets/images/<?php echo $blog['image']; ?>" class="img-fluid" alt="">
                            </div>
                            <div class="content p-3">
                                <h5><?php echo $blog['title']; ?></h5>
                                <div class="mb-3"><?php echo $blog['time'];?>| by <?php echo $blog['author'] ?></div>
                                <p>
                                    <?php echo $blog['content']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="comment">
                        <h5 data-aos="fade-right" data-aos-duration="2000">Leave a Comment</h5>
                        <form action="" method="post" data-aos="fade-left" data-aos-duration="2000">
                                <input type="text" class="d-none" name="postid" value="<?php echo $blog['id']; ?>">
                                <input type="text" class="d-none" name="userid" value="<?php echo $_SESSION['userdata']['id']; ?>">
                                <textarea name="msg" id=""  rows="5" class="form-control"></textarea>
                                <button class="btn btn-primary mt-3" name="submit">Submit</button>
                        </form>
                        <?php 
                           foreach($comment as $cmt){

                            ?>
                        
                        <div class="card card-body my-3" data-aos="fade-right" data-aos-duration="2000">
                            <h6><?php echo $cmt['name']; ?></h6>
                            <?php echo $cmt['message']; ?>
                            <div class="mt-3">
                                <span class="float-end"><?php echo $cmt['cmttime'] ; ?></span>
                            </div>
                        </div>
                        <?php
                            
                           }
                        
                        
                        ?>
                       
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 data-aos="fade-left" data-aos-duration="2000">Blogs Categories</h5>
                    <div class="heading-line" data-aos="fade-right" data-aos-duration="2000"></div>
                    <ul class="mb-5" data-aos="zoom-in" data-aos-duration="2000">
                        <?php 
                            $query="SELECT * FROM category";
                            $category=mysqli_query($db,$query);
                            foreach($category as $catlist){
                           
                        ?>
                        
                             <li class="my-2"><a href="recentblog.php?catid=<?php echo $catlist['id']; ?>"><?php  echo $catlist['name']; ?></a></li>
                        
                        <?php
                        }
                        ?>
                    </ul>
                    <h5 data-aos="fade-left" data-aos-duration="2000">Blogs You May Like</h5>
                    <div class="heading-line" data-aos="fade-right" data-aos-duration="2000"></div>
                    
                   <?php 
                     $query="SELECT * FROM blog ORDER BY id DESC";
                     $blogresult=mysqli_query($db,$query);
                     foreach($blogresult as $blog){
                    ?>
                   
                    <a href="blog-detail.php?blogid=<?php echo $blog['id']; ?>">
                        <div class="recent-blog border rounded p-2 my-1 d-flex justify-content-between align-items-center" data-aos="fade-left" data-aos-duration="2000">
                            <img src="../temple/assets/images/<?php  echo $blog['image'];?>" alt="">
                            <div class="ms-2">
                                <?php echo substr($blog['content'],0,100); ?>
                            </div>
                        </div>
                    </a>
                    <?php
                     }
                   ?>
                </div>
            </div>
        </div>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" id="footer-wave"><path fill="#6366f1" fill-opacity="1" d="M0,32L48,37.3C96,43,192,53,288,90.7C384,128,480,192,576,192C672,192,768,128,864,117.3C960,107,1056,149,1152,149.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
    <footer id="footer" class="d-flex justify-content-center align-items-center">
        <div class="container">
            <div>&copy; 2023 Hornbill Technology, Inc. All rights reserved.</div>
        </div>
    </footer>
    
    <!-- bootstrap cdn  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- aos  -->
    <script src="../temple/assets/aos/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>