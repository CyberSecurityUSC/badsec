#!/bin/bash

if [ ! -f /sites/wordpress ]; then

	cd /sites/
	curl -L https://wordpress.org/latest.tar.gz | tar xz;
	cd /sites/wordpress;
	ln -s ../wp-config.php wp-config.php;
	cd wp-content;
	ln -s ../../uploads uploads;	
	cd themes;
	ln -s ../../../Cyber Cyber;
fi

service ssh start;
chown -R notroot /home/notroot/.ssh
chgrp -R notroot /home/notroot/.ssh
chown -R notroot /home/notroot/.ssh/authorized_keys
chgrp -R notroot /home/notroot/.ssh/authorized_keys
chmod -R 600 /home/notroot/.ssh/authorized_keys

#hhvm --mode daemon --config hhvm.hdf -unotroot -vhhvm.error_handling.call_user_handler_on_fatals=1 -vhhvm.server.implicit_flush;
hhvm --mode server -vServer.Type=fastcgi -vServer.Port=1337 \
	-vLog.Always_Log_Unhandled_Exceptions=false -vServer.Implicit_Flush=true \
	-unotroot;