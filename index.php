<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once('Git.php');

use Tracy\Debugger as Debugger;
Debugger::enable(Debugger::DEVELOPMENT);
Debugger::$dumpTheme = 'dark';

const REPO = 'C:\wamp64\www\basic-bootstrap-theme';
const URL = 'http://localhost/php-version-control/';

# Use in windows OS
Git::windows_mode();

# Open local repository
$repo = Git::open(REPO);

# Git manipulation

# dump($repo->run('status'));
if(isset($_GET['branch']) && $_GET['branch'] !== '') :
	$repo->checkout($_GET['branch']);
endif;
bdump($repo->active_branch());
$branches = $repo->list_branches();
?>

<html style="overflow-y: hidden;">
<head>
	<title>PHP version control</title>
	<style>
		select{
			position: absolute;
			background: #bbbbbb;
			min-width: 100px;
			padding: 10px;
			top: 5px;
			left: 5px;
			font-size: 15px;
			outline: none;
		}
	</style>
	<script defer>
		function changeBranch(element) {
			var url = element.options[element.selectedIndex].getAttribute('data-url');
			window.location.href = url;
		}
	</script>
<head>
<body style="margin: 0px">
	<select onChange="changeBranch(this);">
		<?php foreach ($branches as $branch): ?>
			<option 
				value="<?php echo $branch ?>" 
				data-url="<?php echo URL ?>?branch=<?php echo $branch ?>&v=<?php echo rand(1, 99999999)?>"
				<?php echo ($repo->active_branch() === $branch) ? "selected" : "" ?>
			>
				<?php echo $branch ?>
			</option>
		<?php endforeach; ?>
	</select>
	<iframe style="width:100%; height:100%; border:none;" src="http://localhost/basic-bootstrap-theme/"></iframe>
<body>
</html>