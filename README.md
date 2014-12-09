kvhost
======

A PHP script that creates, deletes and lists apache2 virtual host config files

Just set these varriables to your specifications

```php
$this->server_admin     = 'cobolt.exe@gmail.com';
    $this->company_domain   = 'panzer-planet.com';
    $this->sites_available  = '/etc/apache2/sites-available';
    $this->web_root         = '/var/www';
```

then from the command line run

```bash
# to create
sudo php kvhost.php c 
# to delete
sudo php kvhost.php d 
# to list
sudo php kvhost.php l 

```

A virtual host file will be created in the sites-available directory like this

```php
<VirtualHost *:80>
  ServerName {$this->host_name}.{$this->company_domain}
  ServerAlias www.{$this->host_name}.{$this->company_domain}
  ServerAdmin {$this->server_admin}
  DocumentRoot /var/www/{$this->host_name}/public_html

  ErrorLog \${APACHE_LOG_DIR}/error.log
  CustomLog \${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
```
