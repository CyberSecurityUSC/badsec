#!/bin/bash
echo "upstream injection {
    server $INJECTION_PORT_1337_TCP_ADDR:1337;
}

upstream serverside {
    server $SERVERSIDE_PORT_1337_TCP_ADDR:1337;
}

upstream requests {
    server $REQUESTS_PORT_1337_TCP_ADDR:1337;
}" > /etc/nginx/sites-enabled/0_streams.conf

memcached -du root;
service nginx start;