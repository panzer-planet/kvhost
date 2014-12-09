<?php

/** Create a new virtual host file and pop it into sites-available
 * @author Werner Roets <cobolt.exe@gmail.com>
 */
 #Set personal stuff
$c = array();
$c['server_admin'] = 'cobolt.exe@gmail.com';
$c['my_domain'] = 'panzer-planet.com';
$c['sites_available'] = '/etc/apache2/sites-available';
$c['web_root'] = '/var/www';


 #Function for formatting
function printn($str){
  echo $str.'
';}

 #Host name as first command line argument
$host_name = $argv[1];

 #Does this virtual host config file already exist?
$file = @fopen($c['sites_available']."/{$host_name}.conf",'r');
 #If yes then we exit
if($file){
  printn('File'.$c['sites_available']."/{$host_name}.conf already exists");
  printn('Exiting...');
  exit;
}
 #Otherwise move on...

 #The new directory goes here
$newdir = $c['web_root'].'/'.$host_name;
$result = `mkdir $newdir`;
  printn($result);

$newdir = $c['web_root'].'/'.$host_name.'/public_html';
$result = `mkdir $newdir`;
 printn($result);


$file = @fopen($c['sites_available']."/{$host_name}.conf",'x');
#die($c['sites_available']."/{$host_name}.conf");
if(!$file){
  printn("Could not create ".$c['sites_available']."/{$host_name}.conf".". Maybe you are not root?");
  printn('Exiting...');
  exit;
}


$data = <<<TEXT
<VirtualHost *:80>
  ServerName {$host_name}.{$c['my_domain']}
  ServerAlias www.{$host_name}.{$c['my_domain']}
  ServerAdmin {$c['server_admin']}
  DocumentRoot /var/www/{$host_name}/public_html

  ErrorLog \${APACHE_LOG_DIR}/error.log
  CustomLog \${APACHE_LOG_DIR}/access.log combined

</VirtualHost>


TEXT;


$result = fwrite($file,$data);
if(!$result){
  printn("Could not write any data to ".$c['sites_available']."/{$host_name}.conf");
}else{
  printn("");
  printn("Created ".$c['sites_available']."/{$host_name}.conf");
  printn("Your new vhost has been created here:");
  printn("");
  printn("   /var/www/{$host_name}/public_html");
  printn("");
  printn("Add it to /etc/hosts to make it available at:");
  printn("");
  printn("   http://{$host_name}.{$c['my_domain']}.com");
  printn("");
  printn("Don't forget to run 'a2ensite' {$host_name} and");
  printn("'service apache2 reload to enable the new host!'");
  printn("");
}
fclose($file);
