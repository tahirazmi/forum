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
        



<!-- Search result start here -->
<div class="container" id="maincontainer">
<h2 class="my-3" style="text-align:center;"> Search result for "<em><?php echo $_GET['search'];?></em>"</h2>
<?php
            $noResult=true;
        $query=$_GET['search'];
        $sql= "SELECT*FROM `threads` WHERE MATCH(thread_title, thread_desc) AGAINST('$query')";
        $result=mysqli_query($conn, $sql);
        while($row= mysqli_fetch_assoc($result)){
            $noResult=false;
            $desc = $row['thread_desc'];
            $title = $row['thread_title'];
            $thread_id=$row['thread_id'];
            $url = "threads.php?threadid=".$thread_id ;
            echo '<div class="search">
            <h3><a href=" '. $url .'" class="text-dark">'. $title .'</a></h3>
           <p class="py-3">'. $desc .'</p>
           
        </div>';
        }
        if($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4">No Result Found</p>
              <h1 class="lead">Suggestions:<br>
               Make sure that all words are spelled correctly.<br>
              Try different keywords.<br>
              Try more general keywords.</h1>
            </div>
          </div>';
        }
        ?>




    


    
    



    <!-- Included footer -->
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