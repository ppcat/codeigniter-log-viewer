<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library for reading codeigniter's log file
 *
 * @author Mike Feng
 */
class Log_library {

	/**
	 * Constructor
	 * 
	 */
	public function __construct()
    {
        $this->CI =& get_instance();
    }


    /**
     * Get log file from default location '/logs'.
     *
     * @param 	String 	@log_file
     * @return 	Array
     */
	public function get_file($log_file)
	{
		$path = APPPATH . 'logs/' . $log_file;

		if(file_exists($path))
		{
			$handle = fopen($path, "r");
			$cols = [];

			while (! feof($handle))
			{
				$content = fgets($handle, 4096);

				if (!$this->_startsWith($content, 'ERROR') && 
                    !$this->_startsWith($content, 'DEBUG') && 
                    !$this->_startsWith($content, 'INFO'))
				{
					continue;
				}

				$cols['level'][] = explode(" - ", $content)[0];
				preg_match("/(.+) - (\d{4}-\d{2}-\d{2}\s{1}\d{2}:\d{2}:\d{2}) /", $content, $time);
				$cols['time'][] = $time[2];
				$cols['message'][] = str_replace("\n", "", explode("--> ", $content, 2)[1]);
			}
			fclose ($handle);
			
			return $cols;
		}
        
		return NULL;
	}

	private function _startsWith($haystack, $needle) {
    	// search backwards starting from haystack length characters from the end
    	return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}
}
