<?php 

class Timer { 

	var $classname = "Timer"; 
	var $start = 0; 
	var $stop = 0; 
	var $elapsed = 0; 
	var $running = false;

# Constructor 
	function Timer( $start = true ) { 
		if ( $start ) {
			$this->start(); 
		}
	} 

# Start counting time 
	function start() { 
		if($this->running) {
			$this->stop();
		}
		$this->start = $this->_getTime();
		$this->running = true;
	} 

# Stop counting time 
	function stop() { 
		if($this->running) {
			$this->stop = $this->_getTime();
			$this->elapsed += $this->_compute(); 
			$this->running = false;
		}
	} 

# Get Elapsed Time 
	function elapsed() { 
		if ($this->running) { 
			$this->stop(); 
		}
		return $this->elapsed; 
	} 

# Get Elapsed Time 
	function reset() { 
		$this->start   = 0; 
		$this->stop    = 0; 
		$this->elapsed = 0; 
		$this->running = false;
	}

# Demo
	function demoTest() {

		echo "cumulative timing test\n";
		echo "\trunning timer for ~2 seconds\n";
		$test = new Timer(true);
		sleep(2);
		echo "\ttime elapsed (should be ~2 sec): " . $test->elapsed() . "\n";
		sleep(2);	
		echo "\twaiting 2 sec to simulate break between timings\n";
		$test->start();
		echo "\trunning timer for another ~3 seconds\n";
		sleep(3);
		echo "\ttotal time elapsed should be cumulative (~5 sec): " . $test->elapsed() . "\n";
		$test->reset();
		echo 'reset test (should be 0): ' . $test->elapsed() . "\n";
		echo "done!\n";

	} 

#### PRIVATE METHODS #### 

# Get Current Time 
	function _getTime() { 
		$mtime = microtime(true); 
		$mtime = explode( " ", $mtime ); 
		return $mtime[1] + $mtime[0]; 
	} 

# Compute elapsed time 
	function _compute() { 
		return $this->stop - $this->start; 
	} 
}

