# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box             = "hackme"
  config.vm.box_url         = "https://cloud-images.ubuntu.com/vagrant/trusty/current/trusty-server-cloudimg-amd64-vagrant-disk1.box"
  config.ssh.forward_agent  = true

  if Vagrant::Util::Platform.windows?
  	# Potentially configure for smb/rsync no luck on windows (DM)
    config.vm.synced_folder   "./", "/home/vagrant/"
  else
    config.vm.synced_folder   "./", "/home/vagrant/", nfs: true
  end
  
  config.vm.network :private_network, ip: "10.10.10.10"

end