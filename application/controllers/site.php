<?php
/*
|---------------------------------------------------------------
| ADMIN - SITE CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/site.php
| System Version: 1.0
|
| Controller that handles the SITE section of the admin system.
|
*/

require_once APPPATH . 'controllers/base/site_base.php';

class Site extends Site_base {

	function Site()
	{
		parent::Site_base();
	}
	
	function chat()
	{
		/* check access */
		$this->auth->check_access();

		/* load chat model */
		$this->load->model('chat_model', 'chat'); // rename $this->chat_model->method_name() to $this->chat->method_name()

		$chat = $this->chat->get_all_settings();
	}
}

/* End of file site.php */
/* Location: ./application/controllers/site.php */