<?php 

include 'init.php';

if(!isset($_SESSION['auth'])) {
    redirect('login');
}

?>


<h1>Home</h1>



<a href="logout.php">logout</a>


