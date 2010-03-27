<?php
/*
|---------------------------------------------------------------
| CHAT MODEL
|---------------------------------------------------------------
|
| File: models/chat_model.php
| System Version: 1.0
|
| Model used to access the config table and pull the system global
| variables for use by the controllers and views.
|
*/

class Chat_model extends Model {

	function Chat_model()
	{
		parent::Model();

		/* load the db utility library */
		$this->load->dbutil();
	}

	/*
	|---------------------------------------------------------------
	| GET METHODS
	|---------------------------------------------------------------
	*/

	function get_all_settings()
	{
		$this->db->from('mibbit'); // SELECT * FROM `nova_mibbit`
		$this->db->where('id', '0'); // WHERE `id` = '0'

		$query = $this->db->get();

		return $query;
	}
}

/* End of file chat_model.php */
/* Location: ./application/models/chat_model.php */