#!/bin/bash
cd /sites;
sudo chmod 555 .;
sudo chmod 555 *;
sudo chown root index.php;
sudo chgrp root index.php;

# There are ways to get around these, but would take effort.
# Quick Docker flush, and git tree reset and it's all good anyway 
rm /bin/mv /bin/rm /usr/bin/touch /bin/chmod /bin/chown /bin/kill; # pretty desperate

# ENV key
echo "
KEY=`echo YayIknowVariables | md5sum | grep -oP '[a-zA-Z0-9]*'`" >> /etc/environment;

# Yes Key
echo "
#!/bin/bash
echo KEY=`echo iAmTheYesMan | md5sum | grep -oP '[a-zA-Z0-9]*'`
" > /usr/bin/yes

# .mysql_history key
echo "use serverside; INSERT INTO \`secrets\` VALUES ('5bd6e98e1369d551dc1eb7a805c0a074');" > /home/notroot/.mysql_history;

# Start server
su - notroot -c "echo KEY=`echo YayIknowProcesses | md5sum | grep -oP '[a-zA-Z0-9]*'`;hhvm --mode server -vServer.Type=fastcgi -vServer.Port=1337";
