kvhost
======

A PHP script that creates a new virtual host file and webroot subdirectory.

Just set these varriables to your specifications

```php
$c['server_admin'] = 'cobolt.exe@gmail.com';
$c['my_domain'] = 'panzer-planet.com';
$c['sites_available'] = '/etc/apache2/sites-available';
$c['web_root'] = '/var/www';
```

then from the command line run

```bash
sudo php kvhost.php hostname
```

A virtual host file will be created in the sites-available directory like this

```php
<VirtualHost *:80>
  ServerName {$host_name}.{$c['my_domain']}
  ServerAlias www.{$host_name}.{$c['my_domain']}
  ServerAdmin {$c['server_admin']}
  DocumentRoot /var/www/{$host_name}/public_html

  ErrorLog \${APACHE_LOG_DIR}/error.log
  CustomLog \${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
```
and a directory will be created under your webroot
```bash
/var/www/hostname/public_html
