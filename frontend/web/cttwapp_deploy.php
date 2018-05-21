<?php
    /**
     * GIT DEPLOYMENT SCRIPT
     *
     * Used for automatically deploying websites via GitHub
     *
     */

    // array of commands
    $commands = array(
        'echo $PWD',
        'whoami',
        '(cd /var/www/web/cttwapp && git pull origin master 2>&1)',
        '(cd /var/www/web/cttwapp && git status 2>&1)',
        '(cd /var/www/web/cttwapp && git submodule sync 2>&1)',
        '(cd /var/www/web/cttwapp && git submodule update 2>&1)',
        '(cd /var/www/web/cttwapp && git submodule status 2>&1)',
        'sudo chown -R ricardo:www-data /var/www/web/cttwapp/ *.*',
        'sudo setfacl -R -m u:ricardo:rwX -m u:www-data:rwX -m u:git:rwX /var/www/web/cttwapp/ *.*'
    );

    // exec commands
    $output = '';
    foreach($commands AS $command){
        $tmp = shell_exec($command);

        $output .= "<span style=\"color: #6BE234;\">\$</span><span style=\"color: #729FCF;\">{$command}\n</span><br />";
        $output .= htmlentities(trim($tmp)) . "\n<br /><br />";
    }
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>CTTwapp Project - Git Deployment Script</title>
</head>
<style>
    body {
        width: 35em;
        margin: 0 auto;
        font-family: Tahoma, Verdana, Arial, sans-serif;
        background-color: #ffffff;
        color: #000000;
    }
</style>
<body>

	<h1>CTTwapp Project - Git Deployment Script</h1>
	<p>This page reports about git's commands status, for a production server updates based on GitHub's WebHooks.</p>

    <p><?= date('Y-m-d G:i:s'); ?></p>

	<div style="width:700px">
		<div style="float:left;width:350px;">
    			<p style="color:white;">CTTwapp Project - Git Deployment Script</p>
			<?= $output; ?>
		</div>
	</div>

</body>
</html>
