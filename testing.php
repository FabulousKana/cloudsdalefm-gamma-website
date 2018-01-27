<?php
    // Little thingy for CloudsdaleFM Gamma. Only for testing purposes.
    // Shouldn't be placed alongside client.php in the final project,
    // can cause serious security problemes.

    require_once("client.php");

    echo "<head><title>Gamma testing</title></head>";

    if( !$_GET["iwantto"] ) {
        echo "
            <a href='$_SERVER[REQUEST_URI]?iwantto=register'>Register</a><br/>
            <a href='$_SERVER[REQUEST_URI]?iwantto=verifyc'>Verify Credentials</a><br/>
        ";
    } else {
        if( $_GET["iwantto"] == "register" ) {
            if( !$_POST["email"] ) {
                echo "
                    <form method='post' action='testing.php?iwantto=register'>
                        <input type='text' name='username' placeholder='USERNAME'>
                        <input type='email' name='email' placeholder='EMAIL'>
                        <input type='password' name='password' placeholder='PASSWORD'>
                        <input type='submit' value='Register'>
                    </form>
                ";
            } else {
                $acc = new accounts();
                $acc->init();
                echo $acc->register($_POST["username"], $_POST["password"], $_POST["email"]);
            }
        } elseif( $_GET["iwantto"] == "verifyc" ) {
            if( !$_POST["username"] ) {
                echo "
                    <form method='post' action='testing.php?iwantto=verifyc'>
                        <input type='text' name='username' placeholder='USERNAME'>
                        <input type='password' name='password' placeholder='PASSWORD'>
                        <input type='submit' value='Login'>
                    </form>
                ";
            } else {
                $acc = new accounts();
                $acc->init();
                echo $acc->verify_credientials($_POST["username"], $_POST["password"]);
            }
        } elseif( $_GET["iwantto"] == "die" ) {
            echo "same";
        } else {
            echo "lol";
        }
    }

?>