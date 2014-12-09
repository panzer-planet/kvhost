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
