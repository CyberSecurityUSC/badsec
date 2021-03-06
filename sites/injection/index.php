<?php

ini_set("display_startup_errors",1);
error_reporting(E_ALL);
set_error_handler( function($errno,$errstr,$errfile,$errline,$errcontext){
  echo sprintf("<p style='list-style:disc outside none; display:list-item;margin-left: 20px;'><strong>Error:</strong> %s in %s on %d</p>\n",$errstr,$errfile,$errline);
} , E_ALL);

class Controller {

    private $db_server;
    private $query ="SELECT idea ,from_unixtime(time,'%M %e, %Y, %l:%i %p:') as formatted FROM injection ORDER BY time DESC limit 5";

    public function __construct(){
        # Where are you going?
        switch($_SERVER["REQUEST_URI"]){
            case "/":
                $this->status = $this->index();
                break;
            default:
                header("HTTP/1.0 404 Not Found");
                echo "404";
                break;
        }
    }

    private function index(){
        $data = array("success"=> true,"message"=> "Try to post!", "data"=>array());

        # Post or get?
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $data = $this->post() + $data;
        }
        return $this->messages() + $data;
    }

    private function post(){

        $response = array("success"=> false, "message"=> "Database error.. Our munchkins are on it");

        # Database
        if (!$this->connect()) return $response;

        # Store our message.
        # I'm not going to allow xss, 
        # because it's a legit security concern to users
        $message = htmlspecialchars($_POST['message']);

        # Meta
        $time  = time();

        # Validate
        $short    = strlen($message) < 2001;

        # Insert if I can
        if($short){
            # yeah, this is a bad idea
            # string','0'),((SELECT secret from secrets limit 1),'9000000000000'),((SELECT secret from secrets limit 1,1),'9000000000000'),((SELECT secret from secrets limit 2,1),'9000000000000'),('…
            $this->db_server->query("INSERT INTO injection (idea, time) VALUES('$message', '$time')") or die(mysql_error()); 
            $response = array("success"=> true, "message"=> "WOW!  So Original of you ;)");
        }else{
            $response = array("success"=> false, "message"=> "Too long friend");
        }
        return $response;
    }

    private function connect(){
        # Did we already do this?
        if(isset($this->db_server) && $this->db_server)
            return true;

        # Database settings
        $this->db_server = mysqli_connect(getenv("MYSQL_PORT_3306_TCP_ADDR"), getenv("USER"), getenv("PASSWORD")) or die(mysql_error());
        return $this->db_server->select_db(getenv("DATABASE"));
    }

    private function messages(){
        $response = array("message"=>"Momentary difficulities. We're on it.");
        if (!$this->connect()) return $response;
        return array("data"=>($this->db_server->query($this->query)->fetch_all(MYSQLI_ASSOC)));
    }
}

$controller = new Controller();
?>

<!doctype html>
<html>
    <head>
        <!-- KEY=826e13ba7a7fa26448ceadff62022c31154c725ce324bc188c37b364801d395e -->
        <link rel="stylesheet" href="/bootstrap.css">
        <title>SQL Injection App</title>
    </head>
    <body>
        <div class="container">
            <div class="center-block text-center">
                <img src="/exploits.jpg" title="Her daughter is named Help I'm trapped in a driver's license factory." alt="Exploits of a mom"/>
                <h1>Post something to this page!!!</h1>
                <h4><?php echo $controller->status["message"]?></h4>
                <form method="post" action="/" class="form-inline">
                    <input class="form-control" type="text" name="message"/>
                    <button type="submit" class="btn btn-primary">Post that Jazz</button>
                </form>
                <hr/>
            </div>
            <table class='table'>        
            <?php
                foreach ($controller->status["data"] as $row) {?>
                <tr class="time">
                    <td><b><?php echo $row["formatted"]; ?></b></td>
                    <td class="idea"> 
                        <?php echo $row["idea"]; ?>
                    </td> 
                </tr>
            <?php }?>
            </table>
        </div>
    </body>
</html>