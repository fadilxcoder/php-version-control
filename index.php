<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once('Git.php');

use Tracy\Debugger as Debugger;
Debugger::enable(Debugger::DEVELOPMENT);
Debugger::$dumpTheme = 'dark';
bdump("Tracy Active !");

const REPO = 'C:\wamp64\www\basic-bootstrap-theme';
const URL = 'http://localhost/php-version-control/';

# Use in windows OS
Git::windows_mode(); 
$repo = Git::open(REPO);

# Git manipulation

# dump($repo->run('status'));
# $repo->checkout('theme-2');
if(isset($_GET['branch']) && $_GET['branch'] !== '') :
	$repo->checkout($_GET['branch']);
endif;
bdump('ACTIVE BRANCH : ' . $repo->active_branch());
$branches = $repo->list_branches();
?>

<html style="overflow-y: hidden;">
<head>
	<title>PHP version control</title>
	<style>
		ul{
			position: absolute;
			margin: 0px;
			padding-top: 10px;
			padding-left: 25px;
			list-style: circle;
			background: #bbbbbb;
			width: 100px;
			min-height: 150px;
		}
		a{
			color: #000
		}
	</style>
<head>
<body style="margin: 0px">
	<ul>
		<?php foreach ($branches as $branch): ?>
		<li>
			<a href="<?php echo URL ?>?branch=<?php echo $branch ?>"><?php echo $branch ?></a>
		</li>
		<?php endforeach; ?>
	</ul>
	<iframe style="width:100%; height:calc(100% - 30px); border:none;" src="http://localhost/basic-bootstrap-theme/"></iframe>
<body>
</html>