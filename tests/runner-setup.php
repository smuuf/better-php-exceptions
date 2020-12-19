<?php

// Scan for "php*" directories and create a list of present directories for
// separate PHP versions.
$presentPhpVersions = [];
foreach (glob(__DIR__ . '/unit/php*') as $dirPath) {
	$presentPhpVersions[] = str_replace('php', '', basename($dirPath));
}

// Add all directories not matching current PHP version to ignorelist, so that
// we don't run tests targeting different PHP version than the one currently
// executing our tests.

// PHP_MAJOR_VERSION constant would not reflect the PHP binary set to be used
// in tester, so we'll have to get interpreter info from the runner.
$phpVersion = $runner->getInterpreter()->getVersion();
$versionParts = explode('.', $phpVersion);
$majorVersion = $versionParts[0];

foreach ($presentPhpVersions as $ver) {
	if ($ver != $majorVersion) {
		$ignoreDir = "php{$ver}";
		$runner->ignoreDirs[] = $ignoreDir;
		echo "Ignoring dir '$ignoreDir' because this is PHP {$majorVersion}\n";
	}
}

