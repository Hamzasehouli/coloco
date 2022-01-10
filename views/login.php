<!DOCTYPE html>
<html>

<?php include_once 'head.php';
?>

<head>
    <title>Login</title>
</head>

<body>

    <header>

        <?php
include_once '_header.php';
?>

    </header>
    <main>
        <form class="form form-login">
            <h2>Log in</h2>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input name="email" type="email" class="form-control email" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input name="password" type="password" class="form-control password">
            </div>
            <!-- <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            <button type="submit" class="btn btn-primary">Log in</button>
            <a href="/signup" class="btn btn-outline-primary">Do not have an acocunt yet? sign up here</a>
        </form>
    </main>
    <footer>

        <?php
include_once '_footer.php';
?>

    </footer>
</body>

</html>