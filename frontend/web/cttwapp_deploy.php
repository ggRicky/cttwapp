<?php
    /**
     * Git Deployment Script for cttwapp project
     *
     * Used for automatically deploying cttwapp project at the production server via GitHub
     *
     */

    // 2018-05-21 : The Payload URL in Github hook configuration is https://www.ctt-app.com/cttwapp_deploy.php
    //              due to the new redirect request config in nginx server.
    // 2018-05-21 : Important. For a success execution to the next commands, in the sudoers file add the next line :
    //              www-data ALL=(ALL) NOPASSWD: ALL
    // 2019-10-14 : Important: The user who runs this script is www-data.

    // This is the array of commands to execute
    $commands = [
        '(cd /var/www/web/cttwapp && git pull origin master 2>&1)',
        '(cd /var/www/web/cttwapp && git status 2>&1)',
    ];

    // Execute each command in the array
    $output = '';
    foreach($commands AS $command){
        $tmp = shell_exec($command);

        // The next line is only for debug purpose
        // $output .= "<span style=\"color: #6BE234;\">\$</span><span style=\"color: #729FCF;\">{$command}</span><br />";
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
	<p>This script executes the git commands and reports the status of the updates on the production server. The script is executed through a webhook defined in a GitHub project.</p>

    <p>Last Update : 2019-10-15  11:50:00</p>

    <p style="color:red;">Executed At : <?= date('Y-m-d G:i:s'); ?></p>

	<div style="width:700px">
		<div style="float:left;width:350px;">
    			<p style="color:red;">Deployment Status</p>
			<?= $output; ?>
		</div>
	</div>

</body>
</html>
