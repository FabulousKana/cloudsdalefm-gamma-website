<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <meta name="author" content="CloudsdaleFM Developers"/>
        <title>CloudsdaleFM Gamma - Najlepsze kucykowe hity każdego dnia!</title>
        <meta property="og:title" content="Słuchaj radia CloudsdaleFM!"/>
        <meta property="og:site_name" content="CloudsdaleFM Gamma - Najlepsze kucykowe hity każdego dnia!"/>
        <meta name="description" content="Największe i najbardziej kucykowe radio w Polsce. Słuchaj już teraz w przeglądarce całkowicie za darmo i bez reklam najgorętszych hitów kucykowego fandomu!"/>
        <meta property="og:description" content="Największe i najbardziej kucykowe radio w Polsce. Słuchaj już teraz w przeglądarce całkowicie za darmo i bez reklam najgorętszych hitów kucykowego fandomu!"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="doc/style.css"/>
        <link rel="stylesheet" type="text/css" href="player/style.css"/>
        <link rel="shortcut icon" href="img/logo-small-compressed.png"/>
        <meta property="og:image" content="https://<?php echo $_SERVER["HTTP_HOST"];?>/img/logo-small-compressed.png"/>
        <!--<script type="text/javascript" src="doc/shuffle.js"></script>-->
        <script type="text/javascript" src="player/script.js"></script>
        <?php
            require_once("client.php");
            $acc = new accounts();
            $acc->init();
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
            <div id="sky-left">
                <div id="leftcontent">
                    <div id="player"></div>
                    <span class="player-info">
                        Chcesz słuchać we własnym odtwarzaczu?
                        <a href="download/cloudsdalefm.m3u">Pobierz m3u!</a><br/>
                        <a href="https://twitter.com/cloudsdalefm" target="_blank"><img src="img/social/twitter.png" alt="Twitter"/></a>
                        <a href="https://www.facebook.com/cloudsdaleFM.net/" target="_blank"><img src="img/social/facebook.png" alt="Facebook"/></a>
                        <a href="https://www.youtube.com/channel/UCkCVf7cZ44QUyln8pqKLGwg" target="_blank"><img src="img/social/youtube.png" alt="YouTube"/></a>
                        <a href="https://discord.gg/cCa4xBk" target="_blank"><img src="img/social/discord.png" alt="Discord"/></a>
                    </span>
                </div>
            </div>
            <div id="sky-right">
            </div>
        </div>

        <div id="legal">
            cloudsdalefm.net &copy; 2017-2018<br/>
            Znajdź nasz kod na <a href="https://github.com/FabulousKana?tab=repositories&q=cloudsdalefm" target="_blank">GitHubie</a><br/>
            Tło jest wykonane przez <a href="https://kanistorshik.deviantart.com/art/Mare-of-Darkness-271990981" target="_blank">KANISTORSHIK</a><br/>
            My Little Pony: Przyjaźń to Magia należy do Hasbro Inc.
        </div>

    </body>
</html>