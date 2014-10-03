#!/bin/bash
cd /sites;
chmod 555 ./;
rm /bin/mv /bin/rm; # pretty desperate

echo "use serverside;INSERT INTO \`secrets\` VALUES ('5bd6e98e1369d551dc1eb7a805c0a074');\
INSERT INTO \`secrets\` VALUES ('06c1653a2fea476a1966f3052c40b14d');" > /home/notroot/.mysql_history;

su - notroot -c "hhvm --mode server -vServer.Type=fastcgi -vServer.Port=1337";