<?php
    /**
     * Git deployment script for cttwapp project
     *
     * Used for automatically deploying cttwapp project via GitHub
     *
     */

    // 2018-05-21 : The Payload URL in Github hook configuration is https://www.ctt-app.com/cttwapp_deploy.php
    //              due to the new redirect request config in nginx server.

    // array of commands
    $commands = [
        'pwd', 'echo $?',
        'whoami', 'echo $?',
        'CD /var/www/web/cttwapp', 'echo $?',
        'ls -l','echo $?',
        'pwd', 'echo $?',
        'sudo git pull origin master 2>&1', 'echo $?',
        // 2018-05-21 : Important. For a success execution to the next two commands, in the sudoers file add the next line :
        //              www-data ALL=(ALL) NOPASSWD: ALL
        'sudo chown -R ricardo:www-data /var/www/web/cttwapp/ *.*', 'echo $?',
        'sudo setfacl -R -m u:ricardo:rwX -m u:www-data:rwX -m u:git:rwX /var/www/web/cttwapp/ *.*', 'echo $?',
    ];

    // execute each command
    $output = '';
    foreach($commands AS $command){
        $tmp = shell_exec($command);

        $output .= "<span style=\"color: #6BE234;\">\$</span><span style=\"color: #729FCF;\">{$command}</span><br />";
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
	<p>This page executes the git commands and reports the status of the updates on the production server, executing the webhook defined in GitHub.</p>

    <p><?= date('Y-m-d G:i:s'); ?></p>

	<div style="width:700px">
		<div style="float:left;width:350px;">
    			<p style="color:white;">CTTwapp Project - Git Deployment Script</p>
			<?= $output; ?>
		</div>
	</div>

</body>
</html>
