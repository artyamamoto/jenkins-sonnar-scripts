
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
		cp -p ./* $(SONAR_RESULT_HOME)/
		chmod ugo+x $(SONAR_RESULT_HOME)/trigger-sonar-runner
	fi      


