#!/bin/bash
export DATABASE='requests'
export USER='randomthing'
export PASSWORD='n4stierliz4rd'

cd /sites/;

tar -xzfv provisioning/gitlist.tar.gz ./;

hhvm --mode server -vServer.Type=fastcgi -vServer.Port=1337 -unotroot;
