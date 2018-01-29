<?php
    // Glorious partner management system coded by CloudsdaleFM developers
    // Used on CloudsdaleFM Gamma website
    // gamma.cloudsdalefm.net


    class partner {

        public function init() {
            $config = json_decode(file_get_contents("private/config.json", 1), 1);
            $this->sql = $config["sql"]; 
            $this->lang = $config["lang"];
            date_default_timezone_set($config["timezone"]);
        }


        // ---------------------- Useful functions copied from client.php ----------------------
        public function connectto_mysql() {
            // Connects to MySQL server using the data from configuration file. Simple, right?
            if( !isset($this->sql)  ) { self::init(); }
            $sql = mysqli_connect($this->sql["host"], $this->sql["username"], $this->sql["password"], $this->sql["database"]);
            if( !$sql ) {
                save_to_log_file("(MySQL Error) " . mysqli_connect_errno());
                throw new Exception($this->lang["mysql_cant_connect_error"]);
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
        // ---------------------------------------------------------------------------

        public function get_partner_list() {
            return self::get_from_db("partners");
        }

        public function show_partners() {
            $partners = self::get_partner_list();
            foreach($partners as $partner) {
                echo "<a href='$partner[url]' target='_blank'><img src='$partner[image]' class='partner'/></a>";
            }
        }

    }


?>