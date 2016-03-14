#!/bin/bash

cd /sites/;

service ssh start;
chown -R notroot /home/notroot/.ssh
chgrp -R notroot /home/notroot/.ssh
chown -R notroot /home/notroot/.ssh/authorized_keys
chgrp -R notroot /home/notroot/.ssh/authorized_keys
chmod -R 600 /home/notroot/.ssh/authorized_keys

cd /home/notroot;
echo "
#!/usr/bin/python
import sys

def process(joke):
    joke ^= 127
    joke *= -1
    joke ^= 63
    joke += 1
    joke *= -1
    return joke

bestjoke = None
def run():
    global bestjoke
    print('You probably shouldn\'t run weird code...')
    if(len(sys.argv) == 2):
        joke = int(sys.argv[1])
        if(process(joke + 77) + joke < joke):
            bestjoke = joke

run()
" > bestjoke.py;

python -m compileall .;
rm bestjoke.py;
chmod 444 bestjoke.pyc;

# Set variables
echo "
DATABASE=jokes
DBUSER=thenorris
PASSWORD=cowboyF@ce
MYSQL_PORT_3306_TCP_ADDR=$MYSQL_PORT_3306_TCP_ADDR
" >> /etc/environment;

# Start server
cd /;
su - notroot -c "hhvm --mode server -vServer.Type=fastcgi -vServer.Port=1337";
