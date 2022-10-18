<?php
    class Singleton{
        //SINGLETON
        private static $instance;

        private $host = 'localhost',
            $db_name = 'webservice',
            $password = '',
            $user = 'root',
            $charset = 'utf8',
            $pdo = null,
            $error = null,
            $debug = true,
            $last_id = null;

        public function __construct($host = null, $db_name = null, $password = null, $user = null, $charset = null, $debug = null){
            //SINGLETON
            $this->host = defined('HOSTNAME') ? HOSTNAME : $this->host;
            $this->db_name = defined('DB_NAME') ? DB_NAME : $this->db_name;
            $this->password = defined('DB_PASSWORD') ? DB_PASSWORD : $this->password;
            $this->user = defined('DB_USER') ? DB_USER : $this->user;
            $this->charset = defined('DB_CHARSET') ? DB_CHARSET : $this->charset;
            $this->debug = defined('DEBUG') ? DEBUG : $this->debug;
            $this->connect();
        }

        //SINGLETON
        public static function getInstance() {
            if (!isset(self::$instance)) {
                self::$instance = new SystemDB();
            }
            echo 'Ligação estabelecida';
            return self::$instance;
        }

        final protected function connect(){
            $pdo_details = "mysql:host={$this->host};";
            $pdo_details .= "dbname={$this->db_name};";
            $pdo_details .= "charset={$this->charset};";
            try{
                //SINGLETON
                //$this->pdo = self::getInstance($pdo_details, $this->user, $this->password);
                $this->pdo = new PDO($pdo_details, $this->user, $this->password);
                if($this->debug === true)
                    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                

                unset($this->host);
                unset($this->db_name);
                unset($this->password);
                unset($this->user);
                unset($this->charset);
            }catch(PDOException $e){
                if($this->debug === true)
                    echo "Erro: ".$e->getMessage();
                die();
            }
        }
    }
?>