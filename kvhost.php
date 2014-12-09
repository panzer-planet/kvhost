<?php

/** Create a new virtual host file and pop it into sites-available
 * @author Werner Roets <cobolt.exe@gmail.com>
 */
class KvHost{
   #Set personal stuff
  private $host_name, $server_admin, $company_domain, $sites_available, $web_root;

  public function __construct($argv){
    $this->host_name        = false;
    $this->server_admin     = 'cobolt.exe@gmail.com';
    $this->company_domain   = 'panzer-planet.com';
    $this->sites_available  = '/etc/apache2/sites-available';
    $this->web_root         = '/var/www';

    $result = $this->process_args($argv);

    if(!$result){
      exit;
    }
  }

  private function process_args($argv){
    if( count($argv) == 1 ){
      $this->printn("No arguments provided");
      return false;
    }elseif( count($argv) !== 2 ){
      $this->printn("Invalid arguments");
      return false;
    }

    $mode = $argv[1];

    switch ($mode){
      case 'c':
        $this->create_host();
        break;

      case 'l':

        #list
        $this->list_hosts();
        break;

      case 'd':
        #delete
        $this->list_hosts();
        $this->printn("Please enter filename in full. (e.g 000-default.conf)");
        $host_to_delete = trim(fgets(STDIN));

        if(file_exists($this->sites_available.'/'.$host_to_delete)){
          $result = unlink($this->sites_available.'/'.$host_to_delete);
          if($result){
            $this->printn($this->sites_available.'/'.$host_to_delete.' was deleted');
          }else{
            $this->printn("Could not delete ".$this->sites_available.'/'.$host_to_delete);
          }
        }else{
          $this->printn("That host file does not exist");
        }

        break;

    }
  }

  private function create_host(){
    while(!$this->host_name){
      $this->printn("Enter name for new virtual host:");
      $this->host_name = trim(fgets(STDIN));
    }
    $file_path = $this->sites_available.'/'.$this->host_name.'.conf';
    $result = $this->write_virtual_host_file($file_path);
    if($result){
      $this->printn("Virtual host file created at ".$file_path);
    }else{
      $this->printn("Could not create ".$file_path);
      $this->printn("Are you root?");
    }
  }

  private function delete_host(){
    echo' hi';
  }

  /*
   * List sites available
   */
  private function list_hosts(){
    $list = scandir($this->sites_available);
    if(!$list){
      #Something went wrong
      $this->printn("There has been an error listing hosts");
    }
    $i = 0;
    foreach($list as $item){
      if($i > 1) $this->printn(($i-1).'. '.$item);
      $i++;
    }
  }


  /* Function for formatting
   */
  private function printn($str){
    echo $str.'
';
  }

  public function write_virtual_host_file($file_location){
    $file = @fopen($file_location,'x');
    if(!$file) return false;

$data = <<<TEXT
<VirtualHost *:80>
  ServerName {$this->host_name}.{$this->company_domain}
  ServerAlias www.{$this->host_name}.{$this->company_domain}
  ServerAdmin {$this->server_admin}
  DocumentRoot /var/www/{$this->host_name}/public_html

  ErrorLog \${APACHE_LOG_DIR}/error.log
  CustomLog \${APACHE_LOG_DIR}/access.log combined

</VirtualHost>


TEXT;
    $result = fwrite($file,$data);
    fclose($file);
    return $result;
  }

  public function print_success(){
    $this->printn("");
    $this->printn("Created {$this->sites_available}/{$this->host_name}.conf");
    $this->printn("Your new vhost has been created here:");
    $this->printn("");
    $this->printn("   /var/www/{$this->host_name}/public_html");
    $this->printn("");
    $this->printn("Add it to /etc/hosts to make it available at:");
    $this->printn("");
    $this->printn("   http://{$this->host_name}.{$this->company_domain}");
    $this->printn("");
    $this->printn("Don't forget to run 'a2ensite' {$this->host_name} and");
    $this->printn("'service apache2 reload to enable the new host!'");
    $this->printn("");
  }

}

$kvhost = new KvHost($argv);





/*
 * END OF FILE
 */
