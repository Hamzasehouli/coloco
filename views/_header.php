<?php
use coloco\helpers\GenerateJwt;
if (isset($_SESSION['token'])) {
    $decoded = GenerateJwt::verifyToken($_SESSION['token']);
    extract($decoded);
}

?>

<header id="header">

    <nav class="nav">



        <a style="color:white" class="nav__logo-link" href="/">Coloco </a>

        <ul class="nav__links">



            <?php
if (isset($istokenValid)) {

    ?>

            <button type="submit">Logout</button>

            <?php

} else {

    ?>
            <li class="nav__item"><a class="btn btn-primary nav__link" href="/login">Login</a></li>
            <li class="nav__item"><a class="btn btn-primary nav__link" href="/signup">Signup</a></li>
            <?php

}
?>



        </ul>
    </nav>
</header>