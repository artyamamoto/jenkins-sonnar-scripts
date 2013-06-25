#!/bin/bash

export SONAR_RUNNER_HOME=/usr/share/sonar-runner-2.2.1
export PATH="$PATH:$SONAR_RUNNER_HOME/bin"

if [ -n "$WORKSPACE" ]; then
	if [ -d "$WORKSPACE" ]; then
		SONAR_PROP="$WORKSPACE/sonar-project.properties"
		if [ -f "$SONAR_PROP" ]; then 
			export LANG=ja_JP.UTF-8
			pushd "$WORKSPACE" && sonar-runner
			php /home/ec2-user/bin/sonar.php
		fi
	fi
fi

exit 0

