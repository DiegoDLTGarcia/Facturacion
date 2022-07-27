<?php

//if(empty($_SESSION['active'])){
  //  header('Location: ../');

//}
?>

<header>
    <div class="header">

        <h1><img src="img/logo-cbs-mexico.png" width="200" height="100"></h1>
        <div class="optionsBar">
            <p>Mexico, <?php echo fechaC();?></p>
            <span>|</span>
            <span class="user"><?php echo $_SESSION['user'].' - '.$_SESSION['rol_name'];?></span>
            <img class="photouser" src="img/user.png" alt="Usuario">
            <a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
        </div>
    </div>
    <?php include 'nav.php'?>

</header>
<div class="modal">
    <div class="bodyModal">
    
    </div>
</div>


    </div>
</div>