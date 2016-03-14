#!/bin/bash
export DATABASE='dashboard'
export USER='board'
export PASSWORD='4221175874985779da3'

cd /;
ssh-keygen -t rsa -f ./key -N "";
cd /sites/;
hhvm --mode server -vServer.Type=fastcgi -vServer.Port=1337 -unotroot;