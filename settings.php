<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <meta name="author" content="CloudsdaleFM Developers"/>
        <title>CloudsdaleFM Gamma - Najlepsze kucykowe hity każdego dnia!</title>
        <meta property="og:title" content="Ustawienia konta"/>
        <meta property="og:site_name" content="CloudsdaleFM Gamma - Najlepsze kucykowe hity każdego dnia!"/>
        <meta name="description" content="Największe i najbardziej kucykowe radio w Polsce. Słuchaj już teraz w przeglądarce całkowicie za darmo i bez reklam najgorętszych hitów kucykowego fandomu!"/>
        <meta property="og:description" content="Największe i najbardziej kucykowe radio w Polsce. Słuchaj już teraz w przeglądarce całkowicie za darmo i bez reklam najgorętszych hitów kucykowego fandomu!"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="doc/style-min.css"/>
        <link rel="stylesheet" type="text/css" href="player/style-min.css"/>
        <link rel="shortcut icon" href="img/logo-small-compressed.png"/>
        <meta property="og:image" content="https://<?php echo $_SERVER["HTTP_HOST"];?>/img/logo-small-compressed.png"/>
        <!--<script type="text/javascript" src="doc/shuffle.js"></script>-->
        <script type="text/javascript" src="player/script.js"></script>
        <?php
            require_once("client.php");
            $acc = new accounts();
            $acc->init();
            require_once("partners.php");
            $part = new partner();
        ?>
    </head>
    <body>

        <div id="navbar">
            <a href="index"><img src="img/logo-compressed.png" alt="CloudsdaleFM.net"/></a>
            <a href="listen"><button>Słuchaj</button></a>
            <a href="about"><button>O nas</button></a>
            <a href="archive"><button>Archiwum</button></a>
            <a href="help"><button>Pomoc</button></a>
            <div id="user-area">
                <?php $acc->is_logged_in(); ?>
            </div>
        </div>

        <div id="sky">
            <div class="skyhalf">
                <div id="accountsettings">
                    <?php
                        if( !$_SESSION["username"] ) {
                            echo "<script type='text/javascript'>window.location = 'https://$_SERVER[HTTP_HOST]/login?goto=settings';</script>";
                        }
                        $accounts = $acc->get_from_db("accounts");
                        foreach($accounts as $account) {
                            if( $account["username"] == $_SESSION["username"] ) {
                                if( $account["is_member"] ) { $tick = "<img src='img/tick.png' style='width:15px;height:auto;'/>"; }
                                echo "
                                    <img src='$account[avatar]' class='avatar'/>
                                    <h3>$account[username]</h3>".$tick.
                                    "<p>$account[email]</p>
                                    <p>$account[location]</p>
                                    <p>$account[description]</p>
                                ";
                                break;
                            }
                        }
                    ?>
                </div>
            </div>
        </div>

        <div id="partners">
            <?php
                $part->show_partners();
            ?>
        </div>

        <div id="legal">
            cloudsdalefm.net &copy; 2017-2018<br/>
            Znajdź nasz kod na <a href="https://github.com/FabulousKana?tab=repositories&q=cloudsdalefm" target="_blank">GitHubie</a><br/>
            <a href="privacy">Prywatność</a> | <a href="tos">Zasady</a><br/>
            Tło jest wykonane przez <a href="https://kanistorshik.deviantart.com/art/Mare-of-Darkness-271990981" target="_blank">KANISTORSHIK</a><br/>
            My Little Pony: Przyjaźń to Magia należy do Hasbro Inc.
        </div>

    </body>
</html>