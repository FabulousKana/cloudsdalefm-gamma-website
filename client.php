<?php
    // Glorious client coded by CloudsdaleFM developers
    // Used on CloudsdaleFM Gamma website
    // gamma.cloudsdalefm.net

    header("Content-Type: text/html; charset=utf-8");
    $client_version = "1.0";

    // Just.. uhh.. yeah..
    if( substr($_SERVER["REQUEST_URI"], -10) == "client.php" ) {
        echo "
            <style type='text/css'>body { background: #111; color: white; text-align: center; }</style>
            <h2>Beep! This is client.php. I'm a backend thingy.<br/>
            You're using me almost all the time on normal pages.<br/>
            But here I am useless!!11 ; _ ;</h2>
        ";
    }


    function save_to_log_file($text) {
        // Saves things to log file hoping that logs.txt won't have 5 PB.
        file_put_contents(
            "private/logs.txt", 
            "[" . date("Y-m-d H:i:s") . "] " . $text . PHP_EOL, // <- actual text that will be written to file, wow!
            FILE_APPEND | LOCK_EX
        );
    }


    class accounts {
        // Account management
        public function init() {
            // Starts a session and sets some useful variables
            date_default_timezone_set("Europe/Warsaw");
            $this->host = $_SERVER["HTTP_HOST"];
            $config = json_decode(file_get_contents("private/config.json", 1), 1);
            $this->sql = $config["sql"]; 
            $this->lang = $config["lang"];
            session_start();
        }

        public function connectto_mysql() {
            // Connects to MySQL server using the data from configuration file. Simple, right?
            if( !isset($this->sql)  ) { self::init(); }
            $sql = mysqli_connect($this->sql["host"], $this->sql["username"], $this->sql["password"], $this->sql["database"]);
            if( !$sql ) {
                save_to_log_file("(MySQL Error) " . mysqli_connect_errno());
                echo "<b>".$this->lang["mysql_cant_connect_error"]."</b>";
                return;
            } else {
                save_to_log_file($this->lang["mysql_connected_success"]);
            }
            return $sql;
        }

        public function get_from_db($exactlywhat, $recordname="*") {
            // Gets funny stuff from the database and converts
            // it to array() to make things even easier!!1
            $sql = self::connectto_mysql();
            $result = $sql->query("SELECT $recordname FROM $exactlywhat");
            while( $row = mysqli_fetch_assoc($result) ) {
                $resultbutarray[] = $row;
            }
            $sql->close();
            return $resultbutarray;
        }

        public function send_to_db($whichtable, $dataquery) {
            // Filters spooky stuff to prevent bad people to hack
            // our glorious databases and uploads safe things :3
            // $dataquery has to be array()!11
            $sql = self::connectto_mysql();
            $query = "";
            foreach( $dataquery as $onethingy ) {
                if( is_string($onethingy) ) {
                    $query .= "'".mysqli_real_escape_string($sql, $onethingy)."', ";
                } else {
                    $query .= "$onethingy, ";
                }
            }
            save_to_log_file($this->lang["mysql_sending"] . $_SERVER['REMOTE_ADDR']);
            echo "Sending an [ " . substr($query, 0, -2) . " ] to database.<br/>";
            $sql->query("INSERT INTO $whichtable VALUES (0, " . substr($query, 0, -2) . ")");
            $sql->close();
            return 1;
        }

        public function verify_credientials($username, $password) {
            // Verifies if the sent credentials are cool and good.
            // Returns bool.
            $accounts = self::get_from_db("accounts");
            foreach( $accounts as $account ) {
                if( $account["username"] == $username ) {
                    if( password_verify($password, $account["password"]) ) {
                        save_to_log_file($this->lang["verifyc_success"]);
                        return 1;
                    } else {
                        save_to_log_file($this->lang["verifyc_wrongcredentials"]);
                        return 0;
                    }
                }
            }
            save_to_log_file($this->lang["verifyc_noaccfound"]);
            return 0;
        }

        public function register($username, $password, $email) {
            // Checks if everything is cool and good
            // and creates an account
            if( (strlen($username) > 4) && (strlen($username) < 24) ) {
                if( filter_var($email, FILTER_VALIDATE_EMAIL) ) {
                    if( strlen($password) > 14 && strlen($password) < 128 ) {
                        $usernames = self::get_from_db("accounts", "username");
                        foreach( $usernames as $user ) {
                            if( $user["username"] == $username ) {
                                return $this->lang["register_username_in_use"];
                            }
                        }
                        unset($usernames);
                        $output = self::send_to_db(
                            "accounts",
                            array($username, password_hash($password, PASSWORD_BCRYPT), 0, "", "", "", 0)
                        );
                        if( $output ) {
                            return $this->lang["register_success"];
                        } else {
                            return "D:";
                        }
                    } else {
                        return $this->lang["register_password_wrong_length"];
                    }
                } else {
                    return $this->lang["register_wrong_email"];
                }
            } else {
                return $this->lang["register_username_wrong_length"];
            }
        }

        public function is_logged_in() {
            // Checks if the user is logged in based on a $_SESSION variables
            if( !isset($_SESSION["username"]) ) {
                echo "
                    <a href='login'><button>Zaloguj się</button></a>
                ";
            } else {
                if( $acc->verify_credientials($_SESSION["username"], $_SESSION["password"]) ) {
                    $users = self::get_from_db("accounts");
                    foreach($users as $user) {
                        if( $user["username"] == $_SESSION["username"] ) {
                            if( $user["avatar"] ) {
                                echo "<img src='$user[avatar]' alt='$user[username]' class='avatar'/>";
                                return;
                            }
                        }
                    }
                }
            }
        }


    
    }

    // $acc = new accounts(); // <-- you can use this sorcery to use this GLORIOUS CLASS!1

?>