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
	</head>
	<body>
	<iframe width="560" height="315" src="//www.youtube.com/embed/pFlsufZj9Fg" frameborder="0" allowfullscreen></iframe>
	<h1>Super awesome whois lookup</h1>
	Can you DiG it?
	<form method="get" action="/">
	<input type="text" name="site"/>
	<button>Look up this site</button>
	</form>
	
	<?php if(!empty($_GET["site"])){ # Start if?>
		<div class="results">
			<?php echo lookup($_GET["site"])?>
		</div>
	<?php }; # End if?>
	</body>
</html>