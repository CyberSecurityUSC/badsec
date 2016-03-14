<?php
    
    function lookup($site){
        # Don't ever, ever, ever execute from input
        $message = shell_exec("dig " . $site)?: "Something went wrong";
        
        # not going to let you xss yourself
        $message = htmlspecialchars($message);
        $message = preg_replace("@\n@", '<br/>', $message);
        return $message;
    }

?>

<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/bootstrap.css">
        <title>Can You DiG it?</title>
    </head>
    <body>
        <div class="container"> 
            <div class="center-block text-center">
                <iframe width="560" height="315" src="//www.youtube.com/embed/pFlsufZj9Fg" frameborder="0" allowfullscreen></iframe>
                <h1>Super awesome inbrowser Dig Lookup</h1>
                <h4>Can you DiG it?</h4>
                <form method="get" action="/" class="form-inline">
                    <input  class="form-control" type="text" name="site"/>
                    <button class="btn btn-primary">Look up a site</button>
                </form>
            </div>
            <hr/>
            <?php if(!empty($_GET["site"])){ # Start if?>
                <pre class="results"><p><?php echo lookup($_GET["site"])?></p></pre>
            <?php }; # End if?>
        </div>
    </body>
</html>
