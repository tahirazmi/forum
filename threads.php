<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>iDiscuss- Coding Forum</title>
</head>

<body>

<!-- Incleded header(NAVBAR) and code connecting to server -->
<?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>


    <!-- PHP to show thread.php after clicking on a discussion the will; show  on jumbotron  -->
    <?php
    $id=$_GET['threadid'];
    $sql="SELECT * FROM `threads` WHERE thread_id=$id"; 
    $result= mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $title= $row['thread_title'];
        $desc= $row['thread_desc'];
        $tby= $row['thread_user_id'];
        $sql1 = "SELECT * FROM `users` WHERE `sno` = '$tby' ";
        $result1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($result1);
        $posted_by= $row1['user_email'];
        
    }
    ?>

<?php

$showAlert=false;
$method=$_SERVER['REQUEST_METHOD'];
if($method=="POST"){
$comment= $_POST['comment'];
$sno= $_POST['sno'];

$sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ( '$comment', '$id', '$sno', current_timestamp());";
$result = mysqli_query($conn, $sql);
$showAlert=true;
if($showAlert){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Success!</strong> Your comment has been added.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>';
}

}

?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">  <?php echo $title;?> </h1>
            <p class="lead"><?php echo $desc;?></p>
            <hr class="my-4">
            <p>Do not use obscene or offensive language. ...
                Do not post or link to material which might be considered sexist, racist, homophobic, transphobic,
                ableist or otherwise discriminatory or offensive in nature.
                Tell the truth. ...Respect the privacy of others. ...
            </p>
            <p><b>Posted By: <a class="btn btn-success" href="#" role="button"><?php echo  $posted_by;?></a></b></p>
        </div>
    </div>

    <!-- Bootstrap form to submit question -->
   <!-- $_SERVER['REQUEST_SELF'] used for same file location but it doesn't show ?id=1  and $_SERVER['REQUEST_URI'] use for URL even if the method is GET -->
   <!-- PHP logic to restrict user from posting comments if he/she is not logged in -->
   <?php
    
   if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
   {
   echo '<div class="container my-3">
   <h2>Post  a omment</h2>

   
   <form action=" ' . $_SERVER['REQUEST_URI'] .' " method="post">
       <div class="form-group">
           <label for="exampleFormControlTextarea1">Type your comment</label>
           <textarea class="form-control" id="comment" name="comment" rows="6"></textarea>
       </div>
     <input type="hidden" name="sno" value=" '. $_SESSION['sno'] .'   ">
       <button type="submit" class="btn btn-success">Post Comment</button>
   </form>
</div>';
}
else {
  echo '<div class="container">
  <h2>Start a Discussion</h2>
  <p class="lead">You are not logged in. Please Login to post a comment</p>
  </div>';
}
   ?>

    



    <div class="container">
        <h2 class="py-2">Discussion</h2>
         <?php
    $id=$_GET['threadid'];
    $sql="SELECT * FROM `comments` WHERE thread_id=$id"; 
    $result= mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $id= $row['comment_id'];
        $content= $row['comment_content'];
        $comment_time= $row['comment_time'];
        $comment_by= $row['comment_by'];
        $sql2 = "SELECT * FROM `users` WHERE `sno` = '$comment_by' ";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        


         echo ' <div class="media my-2">
              <img src="img/userdefault.png" width="50px" class="mr-3" alt="...">
              <div class="media-body">  ' . $content . '
              </div>'
               . ' <p class="font-weight-bold my-0">' .$row2['user_email'].' at ' . $comment_time . '</p>'.
           ' </div>';

    }
    ?>

    </div>




    <?php include 'partials/_footer.php'; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
</body>

</html>