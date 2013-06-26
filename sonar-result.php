<?php

if (!empty($_SERVER["WORKSPACE"]) && !is_dir($_SERVER["WORKSPACE"])) {
	die('$WORKSPACE not defined or not dir.'."\n");
}
Script::main();

class Script {
	function main() {
		$_this = new self;
		
		echo "#=== jenkins sonar script start ============\n";
		$_this->checkViolations();
		$_this->checkUnitTests();
		echo "#=== jenkins sonar script end   ============\n";
	}
	function checkUnitTests() {
		echo "#=== phpunit.xml =======================\n";
		
		$punit = sprintf('%s/.sonar/build/logs/phpunit.xml', $_SERVER["WORKSPACE"]);	
		if (!is_file($punit))
			die("$punit not found. \n");
		if (!($punit = simplexml_load_file($punit)) )
			die("failed to parse xml: $punit\n");
		
		$failures = array();
		$errors = array();
		foreach($punit->testsuite as $suite) {
			foreach($suite->testsuite as $_suite) {
				foreach($_suite->testcase as $case) {
					if (!empty($case->failure)) 
						$failures[] = (string)$case->failure;
					if (!empty($case->error))
						$errors[] = (string)$case->error;
				}
			}
		}
		if (!empty($failures)) {
			printf("#=== Failures -- %d found. ===\n", count($failures));
			foreach($failures as $failure) 
				printf("---\n%s\n---\n", trim($failure));
		}
		if (!empty($errors)) {
			printf("#=== Errors -- %d found. ===\n", count($errors));
			foreach($errors as $error) 
				printf("---\n%s\n---\n", trim($error));
		}
	}
	function checkViolations() {
		echo "#=== pmd.xml ===========================\n";
		
		$pmd = sprintf('%s/.sonar/build/logs/pmd.xml', $_SERVER["WORKSPACE"]);
		
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
}


