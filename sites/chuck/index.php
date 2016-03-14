<?php
ini_set("display_startup_errors",1);
error_reporting(E_ALL);
set_error_handler( function($errno,$errstr,$errfile,$errline,$errcontext){
  echo sprintf("<p style='list-style:disc outside none; display:list-item;margin-left: 20px;'><strong>Error:</strong> %s in %s on %d</p>\n",$errstr,$errfile,$errline);
} , E_ALL);

const WORSTJOKE = 241;
class Controller {

    private $db_server;
    public  $status;

    public function __construct(){
        $this->status = $this->index();
    }

    private function index(){
        $data = array("success"=> true, "data"=>array());
        return $this->get() + $data;
    }

    private function get(){
        $response = array("success"=> false);
        if (!$this->connect()) return $response;

        $joke = 0;
        if(!empty($_GET["joke"])) $joke = intval($_GET["joke"]);
        if($joke > 240) $joke = WORSTJOKE;
        else if($joke <= 1)  $joke = rand(2 , 240);
        return array("data"=>($this->db_server->query("SELECT * FROM jokes where id = $joke limit 1")->fetch_all(MYSQLI_ASSOC)));
    }

    private function connect(){
        # Did we already do this?
        if(isset($this->db_server) && $this->db_server)
            return true;

        # Database settings
        $this->db_server = mysqli_connect(getenv("MYSQL_PORT_3306_TCP_ADDR"), getenv("DBUSER"), getenv("PASSWORD")) or die(mysql_error());
        return $this->db_server->select_db(getenv("DATABASE"));
    }
}

$controller = new Controller();
header('Content-Type: application/json');
echo(json_encode($controller->status));