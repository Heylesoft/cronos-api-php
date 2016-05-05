<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Format class
 * Help convert between various formats such as XML, JSON, CSV, etc.
 *
 * @author    Phil Sturgeon, Chris Kacerguis, @softwarespot
 * @license   http://www.dbad-license.org/
 */
class ValidateAuth {

	/**
     * CodeIgniter instance
     *
     * @var object
     */
    private $_CI;

	function __construct()
    {
    	$this->_CI =& get_instance();
    	$this->_CI->load->database();
    	$this->_CI->load->model('application');
    }

    public function validateUser($username, $password)
    {
        $return = null;

        print_r($username);
        print_r($password);

        $this->_CI->application->setName($username);
        $this->_CI->application->setPrivateKey($password);

        $this->_CI->application = $this->_CI->application->validate();

        if($this->_CI->application->getId() == "")
        {
            return FALSE;
        } 
        else
        {
            // TODO: Valididy check
            return md5($this->_CI->application->getName() . ":" .config_item('rest_realm') . ":" . $this->_CI->application->getPrivateKey());
        }
    }
}