<?php 

ini_set("display_startup_errors",1);
ini_set("display_errors",1);
error_reporting(E_ALL);
set_error_handler( function($errno,$errstr,$errfile,$errline,$errcontext){
  echo sprintf("<p style='list-style:disc outside none; display:list-item;margin-left: 20px;'><strong>Error:</strong> %s in %s on %d</p>\n",$errstr,$errfile,$errline);
} , E_ALL);

class Controller {

    private $db_server;
    private $flags  = "SELECT id, description FROM flags";
    private $users  = "SELECT name, count(pass) as points FROM points GROUP BY pass ORDER BY points DESC";
    private $key;
    private $hash;
    private $details;

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

        // encrypt
        $this->key   = file_get_contents("/key");
        $this->hash  = openssl_pkey_get_private($this->key);
        $this->details = openssl_pkey_get_details($this->hash);

        $data = array("success"=> true,"status"=>0,"message"=> "Try to post!", "data"=>array(), "public"=>"rsa.setPublic('".$this->to_hex($this->details['rsa']['n']) . "', '".$this->to_hex($this->details['rsa']['e'])."');");

        # Post or get?
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $data = $this->post() + $data;
        }

        return $data + $this->messages() + $this->won();
    }

    private function post(){
        $data = array("status"=>1);
        $cipher = $_POST['cipher'];
        // convert data from hexadecimal notation
        $cipher = pack('H*', $cipher);
        if (openssl_private_decrypt($cipher, $text, $this->hash)) {
            $values = explode(',',$text);
            if(count($values) != 4) return $data;
            if (!$this->connect()) return $data;

            $name = htmlspecialchars($this->db_server->real_escape_string($values[1]));
            $hash = md5($values[1] . $values[2]);
            $flag = $this->db_server->real_escape_string($values[3]);

            $this->db_server->query("INSERT into points select '$name' as name, '$hash' as pass, id as keyid from flags where secret='$flag' and id not in (select id from points a left join flags b on keyid=id where pass='$hash')");
            $data['status'] = $this->db_server->affected_rows + 1;

        }

        return $data;
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
        $response = array("success"=>false, "message"=>"Momentary difficulities. We're on it.");
        if (!$this->connect()) return $response;
        return array(
            "flags"=>($this->db_server->query($this->flags)->fetch_all(MYSQLI_ASSOC)),
            "users"=>($this->db_server->query($this->users)->fetch_all(MYSQLI_ASSOC))
        );
    }

    private function won(){
        $response = array("won"=>array(), "name"=>"");
        if(!isset($_COOKIE['lookup'])) return $response;
        if (!$this->connect()) return $response;        
        $lookup = $_COOKIE['lookup'];
        $lookup = pack('H*', $lookup);
        if (openssl_private_decrypt($lookup, $text, $this->hash)) {
            $values = explode(',',$text);
            if(count($values) != 3) return $data;
            if (!$this->connect()) return $data;

            $name = htmlspecialchars($this->db_server->real_escape_string($values[1]));
            $hash = md5($values[1] . $values[2]);
            $won = $this->db_server->query("SELECT keyid from points where pass='$hash'")->fetch_all(MYSQLI_ASSOC);

            $ids = array();
            foreach ($won as $arr) {
                $ids[] = $arr['keyid'];
            }

            return array(
                "won"  => $ids,
                "name" => $name
            );
        }

        return $response;
    }

    private function to_hex($data) {
        return strtoupper(bin2hex($data));
    }
}

$controller = new Controller();
?>

<!doctype html>
<html>
    <head>
        <script type="text/javascript" src="js/jsbn.js"></script>
        <script type="text/javascript" src="js/prng4.js"></script>
        <script type="text/javascript" src="js/rng.js"> </script>
        <script type="text/javascript" src="js/rsa.js"> </script>

        <link rel="stylesheet" href="/bootstrap.css">
        <title>Basic Dashboard</title>

        <style>
            button,input{ background-color: #fff;}
        </style>
    </head>
    <body>
    <div class="container">

        <h1>The really basic dashboard</h1>
        <h2>How's it work?</h2>
        <p>Choose a submission name and a passphrase- then start entering keys. Multiple people can use the same name, phrase combination.</p>

        <?php echo array(
            "",
            "<div class='alert alert-danger'>No points for you.</div>",
            "<div class='alert alert-success'><strong>Woohoo!</strong> Another point!</div>")[$controller->status["status"]]; ?>
        
        <form method="post" action="/" id="form" class="form-inline" onsubmit="event.preventDefault(); encrypt();">
            <input type="text"    class="form-control" id="name" name="name" placeholder="name" />
            <input type="text"    class="form-control" id="passphrase" name="passphrase" placeholder="passphrase" />
            <input type="hidden"  class="form-control" id="key" name="key" placeholder="key" />
            <input type="hidden"  class="form-control" id="cipher" name="cipher"/>
            <button type="submit" class="btn btn-primary">Go</button>
        </form>

        <table class='table'>
            <thead>
              <tr>
                <th>Leaderboard</th>
              </tr>
              <tr>
                <th>Person</th>
                <th>Points</th>
              </tr>
            </thead>
            <tbody>
            <?php
            foreach ($controller->status["users"] as $row) {?>
                <tr class="<?php echo $row['name'] == $controller->status['name']? 'info': ''; ?>">
                    <td class="name">
                        <?php echo $row["name"]; ?>
                    </td> 
                    <td class="points">
                        <?php echo $row["points"]; ?>
                    </td> 
                </tr>
            <?php }?>
            </tbody>
        </table>

        <table class='table'>
            <thead>
              <tr>
                <th>Flags</th>
              </tr>
              <tr>
                <th>Flag #</th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
            <?php
            foreach ($controller->status["flags"] as $row) {?>
                <tr class="<?php echo in_array($row['id'], $controller->status['won'])? 'success': ''; ?>">

                    <td class="id">
                        <?php echo $row["id"]; ?>
                    </td> 
                    <td class="description">
                        <?php echo $row["description"]; ?>
                    </td> 
                </tr>
            <?php }?>
            </tbody>
        </table>
        </div>
        <script>
        var rsa = new RSAKey();
        <?php echo $controller->status["public"]; ?>
        // encrypt using RSA

        var encrypt = function(){
            var cipher;

            // Grab vars
            var name = document.querySelector('#name').value.replace(',','','g');
            var pass = document.querySelector('#passphrase').value.replace(',','','g');
            var key  = document.querySelector('#key').value.replace(',','','g');

            // Clear Vars Now
            document.querySelector('#name').value = '';
            document.querySelector('#passphrase').value = '';
            document.querySelector('#key').value = '';

            // Check storage
            if(name != ''){
                window.sessionStorage['name'] = name;
            }else {
                name = window.sessionStorage['name'];
            }
            if(pass != ''){
                window.sessionStorage['pass'] = pass;
            }else {
                pass = window.sessionStorage['pass'];
            }

            cipher   = (new Date()).getTime() + ',' + name + ',' + pass;
            document.cookie = 'lookup=' + rsa.encrypt(cipher);

            if(key == ''){
                window.location = window.location;
            }else{
                document.querySelector('#cipher').value = rsa.encrypt(cipher + ',' + key);
                document.querySelector('#form').submit();
            }
        }

        var format = function(){
            if(window.sessionStorage['name'] != undefined && window.sessionStorage['pass'] != undefined){
                document.querySelector('#name').type = 'hidden';
                document.querySelector('#passphrase').type = 'hidden';
                document.querySelector('#key').type = 'text';              
                if(document.cookie == ""){
                    encrypt();
                }
            }
        }

        format();

        </script>
    </body>
</html>