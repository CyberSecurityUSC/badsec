# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box             = "hackme"
  config.vm.box_url         = "https://cloud-images.ubuntu.com/vagrant/trusty/current/trusty-server-cloudimg-amd64-vagrant-disk1.box"
  config.ssh.forward_agent  = true

  # Bah. Couldn't get NFS to work on Kali
  config.vm.synced_folder   "./", "/home/vagrant/"  

  config.vm.network :public_network, :bridge => "wlan0"
  config.vm.network :private_network, ip: "10.10.10.10" #, virtualbox__intnet: true

end