<?
    require_once './SystemDB.php';
    require_once './user.php';
    require_once './assoc.php';
    require_once './json.php';
    //require_once './global_functions.php';


    class MainWebService{
        protected $form_data,
            $form_msg,
            $db,
            $method = 'GET';

        public function __construct($p = array()){
            //$this->db = new SystemDB::getInstance();
            $this->db = DB::getInstance();
            $this->form_data = array();
            $this->method = $_SERVER['REQUEST_METHOD'];
            $this->loadMethod();
        }

        public function loadMethod(){
            $method = strtolower($this->method);
            if(!method_exists($this, $method))
                return;
            if(!empty($_GET['tb']) && class_exists($_GET['tb']))
                $this->{$method}($_GET['tb']);
        }

        public function makeForm_Data($method){
            if(!empty($method))
                foreach($method as $key=>$value)
                    $this->form_data[$key] = $value;
            }

        public function get($t = null){
            $this->makeForm_Data($_GET);
            $mainQuery = 'SELECT * FROM `'.$t.'`';
            switch (count($this->form_data)){
                case 1:
                    $query = $this->db->query($mainQuery);
                    break;
                case 2:
                    $query = $this->db->query($mainQuery.' WHERE `id` = ?', array($this->chk_array($this->form_data, 'id_a')));
                    break;
                case 3:
                    $query = $this->db->query($mainQuery.' WHERE `id` BETWEEN ? AND ?', array($this->chk_array($this->form_data, 'id_a'), $this->chk_array($this->form_data, 'id_b')));
                    break;
            }
            $response = new $t($query->fetchAll(PDO::FETCH_OBJ));

            if(empty($response) || empty($response->data))
                $response = array(
                    'status' => 0,
                    'message' => $t.' não encontrado(a).'
                );
            $json = new JSON($response);
        }

        public function post($t = null){
            echo 'bHEello';
            //$this->makeForm_Data($_POST);
            if(!empty($_POST)){
                foreach($_POST as $key=>$value)
                    $this->form_data[$key] = $value;
            }
            if($this->chk_array($_GET, 'tb')){
                $q = $this->db->insert($t, $this->form_data);
                $response = array(
                    'status' => 1,
                    'status_message' => $t.' inserido(a) com sucesso.'
                );
            }
            $json = new JSON($response);
        }

        public function put($t = null, $id=null){
            parse_str(file_get_contents('php://input'), $_PUT);
            $this->makeForm_Data($_PUT);
            if($this->chk_array($_GET, 'tb')){
                $q = $this->db->update($t, 'id', $this->form_data['id'], $this->form_data);
                $response = array(
                    'status' => 1,
                    'message' => $t.' atualizado(a) com sucesso.'
                );
            } 
            $json = new JSON($response);
        }

        public function delete($t = null, $id=null){
            $this->makeForm_Data($_GET);
            if($this->chk_array($_GET, 'tb')){
                $q = $this->db->delete($t, 'id', $this->form_data['id'], $this->form_data);;
                $response = array(
                    'status' => 1,
                    'message' => $t.' del com sucesso.'
                );
            }else{
                $response = array(
                    'status' => 0,
                    'message' => $t.' não encontrado(a).'
                );
            }
            $json = new JSON($response);
        }

        //Codeigniter class
        function chk_array($array, $key){
            //Verifica se a chave exite no array
            if(isset($array[$key]) && !empty($array[$key]))
                return $array[$key];
            return null;
        }

    }

    $wb = new MainWebService()
?>