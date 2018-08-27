# -*- mode: ruby -*-
# vi: set ft=ruby :
# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.

# This path
SYSTEM_PATH = __dir__
SYSTEM_PATH_ON_VM = "/opt/pondo"

# Load the config (and possibly local config)
vconfig = YAML.load_file("./vagrant.default.yml")

if File.exist?("./vagrant.local.yml")
  local_config = YAML.load_file("./vagrant.local.yml")
  vconfig.merge!(local_config) if local_config
end

# ensure vagrant version
Vagrant.require_version '>= 1.8.5'

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|

  # Use host manager to manage hostnames
  if Vagrant.has_plugin?('vagrant-hostmanager')
    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
  else
    fail_with_message "vagrant-hostmanager missing, please install the plugin with this command:\nvagrant plugin install vagrant-hostmanager\n\nOr install landrush for multisite subdomains:\nvagrant plugin install landrush"
  end

  # General SSH config
  config.ssh.forward_agent = true

  # Fix for: "stdin: is not a tty"
  # https://github.com/mitchellh/vagrant/issues/1673#issuecomment-28288042
  config.ssh.shell = %{bash -c 'BASH_ENV=/etc/profile exec bash'}

# Create webserver
  config.vm.define 'web' do |web|
    server_config = vconfig.fetch('hosts').fetch('web')

    # General box settings
    web.vm.box = server_config.fetch('vagrant_box')
    web.vm.network "private_network", ip: server_config.fetch('vagrant_ip'), hostsupdater: 'skip'
    web.vm.network "forwarded_port", guest: 80, host: 8117
    web.hostmanager.aliases = server_config.fetch('vagrant_hostname')
    web.hostmanager.manage_host = true
    web.hostmanager.enabled = true

    # Shared folders
    if Vagrant::Util::Platform.windows? and !Vagrant.has_plugin? 'vagrant-winnfsd'
      web.vm.synced_folder SYSTEM_PATH, SYSTEM_PATH_ON_VM, mount_options: ['dmode=777', 'fmode=666']
      web.vm.synced_folder "data/vagrant/config", "/opt/vagrant", mount_options: ['dmode=755', 'fmode=644']
    else
      if !Vagrant.has_plugin? 'vagrant-bindfs'
        fail_with_message "vagrant-bindfs missing, please install the plugin with this command:\nvagrant plugin install vagrant-bindfs"
      else
        # web.vm.synced_folder "data/vagrant/config", "/vagrant-nfs", type: 'nfs'
        # web.bindfs.bind_folder '/vagrant-nfs', "/opt/vagrant", o: 'nonempty', p: '0666,a+D'
        # web.vm.synced_folder SYSTEM_PATH, '/system-nfs', type: 'nfs'
        # web.bindfs.bind_folder '/system-nfs', SYSTEM_PATH_ON_VM, o: 'nonempty', p: '0666,a+D'

        web.vm.synced_folder "data/vagrant/config", "/opt/vagrant", type: 'sshfs'
        web.vm.synced_folder SYSTEM_PATH, SYSTEM_PATH_ON_VM, type: 'sshfs'

      end
    end

    # Provision scripts
    web.vm.provision "shell", path: "data/vagrant/provision/apache/install.sh"
    web.vm.provision "configure-apache", type: "shell", path: "data/vagrant/provision/apache/configure.sh", run: "always"
    web.vm.provision "shell", path: "data/vagrant/provision/php/install-fpm.sh"
    web.vm.provision "configure-php", type: "shell", path: "data/vagrant/provision/php/configure-fpm.sh", run: "always"

    # Virtualbox settings
    web.vm.provider 'virtualbox' do |vb|
      # Customize settings
      vb.name = server_config.fetch('vagrant_hostname')
      vb.customize ['modifyvm', :id, '--cpus', server_config.fetch('vagrant_cpus')]
      vb.customize ['modifyvm', :id, '--memory', server_config.fetch('vagrant_memory')]

      # Fix for slow external network connections
      vb.customize ['modifyvm', :id, '--natdnshostresolver1', 'on']
      vb.customize ['modifyvm', :id, '--natdnsproxy1', 'on']
      vb.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate/vagrant", "1"]
      vb.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate/current", "1"]
    end
  end


  # Create DB server
  config.vm.define 'mysql' do |mysql|
    server_config = vconfig.fetch('hosts').fetch('mysql')

    # General box settings
    mysql.vm.box = server_config.fetch('vagrant_box')
    mysql.vm.network "private_network", ip: server_config.fetch('vagrant_ip'), hostsupdater: 'skip'
    mysql.hostmanager.aliases = server_config.fetch('vagrant_hostname')
    mysql.hostmanager.manage_host = true
    mysql.hostmanager.enabled = true

    # Shared folders
    if Vagrant::Util::Platform.windows? and !Vagrant.has_plugin? 'vagrant-winnfsd'
      mysql.vm.synced_folder "data/vagrant/config", "/opt/vagrant", mount_options: ['dmode=755', 'fmode=644']
    else
      if !Vagrant.has_plugin? 'vagrant-bindfs'
        fail_with_message "vagrant-bindfs missing, please install the plugin with this command:\nvagrant plugin install vagrant-bindfs"
      else
        # mysql.vm.synced_folder "data/vagrant/config", "/vagrant-nfs", type: 'nfs'
        # mysql.bindfs.bind_folder '/vagrant-nfs', "/opt/vagrant", o: 'nonempty', p: '0644,a+D'
        mysql.vm.synced_folder "data/vagrant/config", "/opt/vagrant", type: 'sshfs'
      end
    end

    # Provision scripts
    mysql.vm.provision "shell", path: "data/vagrant/provision/mysql/install.sh"
    mysql.vm.provision "configure", type: "shell", path: "data/vagrant/provision/mysql/configure.sh"

    # Virtualbox settings
    mysql.vm.provider 'virtualbox' do |vb|
      # Customize settings
      vb.name = server_config.fetch('vagrant_hostname')
      vb.customize ['modifyvm', :id, '--cpus', server_config.fetch('vagrant_cpus')]
      vb.customize ['modifyvm', :id, '--memory', server_config.fetch('vagrant_memory')]

      # Fix for slow external network connections
      vb.customize ['modifyvm', :id, '--natdnshostresolver1', 'on']
      vb.customize ['modifyvm', :id, '--natdnsproxy1', 'on']
      vb.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate/vagrant", "1"]
      vb.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate/current", "1"]
    end
  end

end
