<?php

if (!empty($_SERVER["WORKSPACE"]) && !is_dir($_SERVER["WORKSPACE"])) {
	die('$WORKSPACE not defined or not dir.'."\n");
}
main();

function main() {
	$pmd = sprintf('%s/.sonar/build/logs/pmd.xml', $_SERVER["WORKSPACE"]);
	$punit = sprintf('%s/.sonar/build/logs/punit.xml', $_SERVER["WORKSPACE"]);	
	
	if (! is_file($pmd)) 
		die("$pmd not found.\n");
	if (! ($pmd_xml = simplexml_load_file($pmd)))
		die("failed to parse xml: $pmd\n");
	
	$violation = 0;
	foreach($pmd_xml->file as $file) {
		if ($cnt = count($file->violation))
			$violation += $cnt;
	}
	echo "$pmd\n";
	printf("pmd violation: %d\n", $violation);
}


