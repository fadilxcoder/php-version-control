<?php
require_once __DIR__ . '/vendor/autoload.php';

use Tracy\Debugger as Debugger;
use CzProject\GitPhp\Git as Git;

Debugger::enable(Debugger::DEVELOPMENT);
Debugger::$dumpTheme = 'dark';

const REPO = 'C:\wamp64\www\basic-bootstrap-theme';
const APP_URL = 'http://localhost/basic-bootstrap-theme/';
const URL = 'http://localhost/php-version-control/';

# Open local repository
$git = new Git;
$repo = $git->open(REPO);

if(isset($_GET['branch']) && $_GET['branch'] !== '') :
	$repo->checkout($_GET['branch']);
endif;
bdump($repo->getCurrentBranchName());
$branches = $repo->getLocalBranches();
?>

<html style="overflow-y: hidden;">
<head>
	<title>PHP version control</title>
	<style>
		#git-version-control{
			position: absolute;
			background:transparent;
			display: inline;
			height: 40px;
			min-width: 140px;
			padding: 5px;
			left: -145px;
		}
		select{
			background: #FFF;
			padding: 10px;
			font-size: 15px;
			width: 125px;
			outline: none;
			display: inline;
			color: #000;
		}
		#toggle{
			font-size: 31px;
			text-align: center;
			cursor: pointer;
			display: inline;
			vertical-align: middle;
			color: #2196f3;
		}
	</style>
	<script defer>
		function changeBranch(element) {
			var url = element.options[element.selectedIndex].getAttribute('data-url');
			window.location.href = url;
		}

		function toggleWrapper() {
			var elem = document.getElementById('git-version-control');
			elem.style.left = '0px';
		}
	</script>
<head>
<body style="margin: 0px">
	<div id="git-version-control">
		<select onChange="changeBranch(this);">
			<?php foreach ($branches as $branch): ?>
				<option 
					value="<?php echo $branch ?>" 
					data-url="<?php echo URL ?>?branch=<?php echo $branch ?>"
					<?php echo ($repo->getCurrentBranchName() === $branch) ? "selected" : "" ?>
				>
					<?php echo $branch ?>
				</option>
			<?php endforeach; ?>
		</select>
		<div id="toggle" onclick="toggleWrapper()">&#8608;</div>
	</div>
	<iframe 
		style="width:100%; height:100%; border:none;" 
		src="<?php echo APP_URL; ?>" 
		name="<?php echo 'cached-version-' . rand(1, 999999) ?>"></iframe>
<body>
</html>