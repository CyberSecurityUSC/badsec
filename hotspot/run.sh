#!/bin/bash
#Initial wifi interface configuration
ifconfig wlan0 up 10.0.0.1 netmask 255.255.255.0
sleep 2
 
#Start dnsmasq
service dnsmasq restart
 
#Enable NAT
iptables --flush
iptables --table nat --flush
iptables --delete-chain
iptables --table nat --delete-chain
iptables --table nat --append POSTROUTING --out-interface vboxnet0 -j MASQUERADE
iptables --append FORWARD --in-interface wlan0 -j ACCEPT
 
sysctl -w net.ipv4.ip_forward=1
 
#start hostapd
service hostapd restart
