#!/bin/bash
export DATABASE='requests'
export USER='randomthing'
export PASSWORD='n4stierliz4rd'

cd /sites/;

tar -xzf /provisioning/gitlist.tar.gz;
mv gitlist/* gl;
rmdir gitlist;

cd gl;
ln -s /sites/config.ini config.ini;
ln -s /sites/repos repos;


hhvm --mode server -vServer.Type=fastcgi -vServer.Port=1337 -unotroot;
