#!/bin/bash
export DATABASE='requests'
export USER='randomthing'
export PASSWORD='n4stierliz4rd'

cd /sites/;
su - notroot -c "hhvm --mode server -vServer.Type=fastcgi -vServer.Port=1337";