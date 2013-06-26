
SONAR_RESULT_HOME = /usr/share/sonar-result
all:
	@echo "Type this command."
	@echo "    # make install"

clean:
	@echo "Remove by yourself."
	@echo "    # rm -rf $(SONAR_RESULT_HOME)"

install:
	if [ "root" != `whoami` ] ; then
		@echo "root user is required."
	else
		mkdir -p $(SONAR_RESULT_HOME)
		cp -p ./trigger-sonar-runner $(SONAR_RESULT_HOME)/
		cp -p ./sonar-result.php $(SONAR_RESULT_HOME)/
		if grep "^tomcat" /etc/passwd ; then
			chown -R tomcat:tomcat $(SONAR_RESULT_HOME)/
		fi
		chmod ugo+x $(SONAR_RESULT_HOME)/trigger-sonar-runner
	fi      


