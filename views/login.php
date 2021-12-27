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
                <input type="email" class="form-control email" id="exampleInputEmail1" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                    else.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control password" id="exampleInputPassword1">
            </div>
            <!-- <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            <button type="submit" class="btn btn-primary">Log in</button>
            <a href="/signup" class="btn btn-outline-primary">Do not have an acocunt yet? sign up hear</a>

        </form>
    </main>
    <footer>

        <?php
include_once '_footer.php';
?>
    </footer>
    <script src="/public/scripts/login.js"></script>
</body>

</html>