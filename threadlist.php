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


    <!-- PHP for selecting data from categories to show on Media Card -->
    <?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `categories` WHERE category_id=$id"; 
    $result= mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $catname= $row['category_name'];
        $catdesc= $row['category_discription'];


    }
    ?>

    <!-- php for Adding Discussion thread for every categories by using category_id -->
    <?php

          $showAlert=false;
        $method=$_SERVER['REQUEST_METHOD'];
        if($method=="POST"){
          $th_title= $_POST['title'];
          $th_desc= $_POST['desc'];
          $sno= $_POST['sno'];  
          $sql = "INSERT INTO `threads` (`thread_id`, `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES (NULL, '$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
          $result = mysqli_query($conn, $sql);
          $showAlert=true;
          if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your thread has been added. Please wait for community to respond.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
          }

        }

        ?>


    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"> Welcome to <?php echo $catname;?> forums</h1>
            <p class="lead"><?php echo $catdesc;?></p>
            <hr class="my-4">
            <p>Do not use obscene or offensive language. ...
                Do not post or link to material which might be considered sexist, racist, homophobic, transphobic,
                ableist or otherwise discriminatory or offensive in nature.
                Tell the truth. ...Respect the privacy of others. ...
            </p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>

      <!-- Bootstrap form to submit question -->
   <!-- $_SERVER['REQUEST_SELF'] used for same file location but it doesn't show ?id=1  and $_SERVER['REQUEST_URI'] use for URL even if the method is GET -->
  <!-- use php logic so that a user can start discussion only if he he is logged in else tell him to log in first    -->
  
   <?php
    // session_start();
   if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
   {
   echo '<div class="container my-3">
   <h2>Start a Discussion</h2>

 
   <form action=" '. $_SERVER["REQUEST_URI"] . '" method="post">
       <div class="form-group">
           <label for="exampleInputtitle1">Problem Title</label>
           <input type="text" class="form-control" id="title" name="title" aria-describedby="titleHelp">
           <small id="titleHelp" class="form-text text-muted">Keep Your title Short.</small>
       </div>
       <div class="form-group">
           <label for="exampleFormControlTextarea1">Elaborate Your Problem</label>
           <textarea class="form-control" id="desc" name="desc" rows="6"></textarea>
       </div>
       <input type="hidden" name="sno" value=" '. $_SESSION['sno'] .'   ">
       <button type="submit" class="btn btn-success">Submit</button>
   </form>
</div>';
}
else {
  echo '<div class="container">
  <h2>Start a Discussion</h2>
  <p class="lead">You are not logged in. Please Login to start a discussion</p>
  </div>';
}
   ?>

    <div class="container mb-4">
        <h2 class="py-2">Browse Questions</h2>

        <!-- PHP to fetch question from thread database and to show it on browse thread section -->
        <?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `threads` WHERE thread_cat_id=$id"; 
    $result= mysqli_query($conn, $sql);
    $noresult=true;
    while($row = mysqli_fetch_assoc($result)){
        $noresult=false;
        $id= $row['thread_id'];
        $title= $row['thread_title'];
        $desc= $row['thread_desc'];
        $thread_time= $row['timestamp'];
        $thread_user_id= $row['thread_user_id'];
        $sql2 = "SELECT * FROM `users` WHERE `sno` = '$thread_user_id' ";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        
// ?threadid='. $id .' this is used to set GET method and it will show id of every category
         echo ' <div class="media">
              <img src="img/userdefault.png" width="50px" class="mr-3" alt="...">
              <div class="media-body">'.
                '<h5 class="mt-0"><a  href="threads.php?threadid='. $id .'" class="text-dark" >' . $title .'</a></h5>
                <p>' . $desc . '</p>
              </div>' . ' <p class="font-weight-bold my-0">' .$row2['user_email'].' at ' . $thread_time . '</p>'.
            '</div>';

    }
      if($noresult){
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <p class="display-4">No Question</p>
          <h1 class="lead">Be the first person to ask a question</h1>
        </div>
      </div>' ;
        
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