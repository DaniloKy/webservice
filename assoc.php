<? 

    class Assoc{
        public $data = array();
        public static $table = 'assoc';

        public function __construct($dt = null){
            $this->data = $dt;
        }
    }

?>