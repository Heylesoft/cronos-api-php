<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->database();
		$this->load->view('welcome_message');

		$this->load->model('key');
		$this->load->model('application');

		//print_r($this->key);	

		//$key = $this->key->generateKey();

		//print_r("key: " . $key);		

        //$level = 1;
        //$ignore_limits = 1;

        //if ($this->key->insertKey($key, ['level' => $level, 'ignore_limits' => $ignore_limits]))
        //{
			//$this->application->setName('FRONT_END');
			//$this->application->setPrivateKey('4w08w44c4o0k8owk0w0sw0w8o0g4wcw84ocwsgok');

			//print_r($this->application->add());
		//}
	}
}
