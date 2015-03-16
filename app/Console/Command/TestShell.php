<?php class TestShell extends AppShell {
    
	
	public function main() {
				$hostname = getenv('HOSTNAME');
				if(!$hostname) $hostname = trim(`hostname`);
				if(!$hostname) $hostname = exec('echo $HOSTNAME');
				if(!$hostname) $hostname = preg_replace('#^\w+\s+(\w+).*$#', '$1', exec('uname -a'));
				echo '1111111111111111';
				echo $hostname;
				
				echo gethostname();
				}

}?>