#!/bin/bash
export DATABASE='injection'
export USER='someguy'
export PASSWORD='n4styliz4rd'

cd /sites/;
hhvm --mode server -vServer.Type=fastcgi -vServer.Port=1337;