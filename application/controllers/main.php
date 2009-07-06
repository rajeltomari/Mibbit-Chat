<?php
/*
|---------------------------------------------------------------
| MAIN CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/main.php
| System Version: 1.0
|
| Controller that handles the MAIN section of the system.
|
*/

require_once APPPATH . 'controllers/base/main_base.php';

class Main extends Main_base {
	
	function Main()
	{
		parent::Main_base();
	}

	function chat()
	{
		// Adds Mibbit chat to main

		if ($this->session->userdata('player_id') !== FALSE)
		{
			$player = $this->session->userdata('player_id');
			$info = $this->player->get_player_name($player);
			$data['name'] = $info;
		}
		else
		{
			$data['name'] = 'ANONYMOUS';
		}

		if ($data['name'] != "ANONYMOUS")
		{
			$nickname = $this->_is_valid_nickname($data['name']) ? $data['name'] : '';
		}
		else
		{
			$nickname = '';
		}

		if (!$this->_is_valid_nickname($nickname))
		{
			# Replace 'ArcherGuest' with what you want to call your guests. You can also
			# alter the 100,999 to change the range of numbers you want the system to
			# generate a random number from. It's current setting chooses from 100-999.
			$nickname = 'ArcherGuest'.mt_rand(100,999);
		}

		// Input widget id from http://widget.mibbit.com/manager/
		$widgetid = '03e4680ec2241a0e626034fe231f27d7';

		// Other defined variables
		$ircnet = 'KDFSnet'; // Input IRC Network name
		$server = 'fresh.eu.kdfs.net'; // Input irc network address
		$channel = '#USS-Archer'; // Input as #channel or %23channel

		// Establish some replacement variables
		$channel = str_replace("#", "%23", $channel);
		$nickname = str_replace(" ", "_", $nickname);
		$nickname = str_replace(".", "_", $nickname);

		// URI address for widget
		$uri = 'http://widget.mibbit.com/?nick='.$nickname
			.= '&server='.$server
			.= '&channel='.$channel
			.= '&settings='.$widgetid
			.= '&customprompt=Welcome%20to%20'.$ircnet.'%20-%20'.$channel
			.= '&customloading=Please%20wait...%20Loading%20chat&chatOutputShowTimes=true&userListFontSize=12';

		// Header Info
		$data['header'] = $this->settings['sim_name'] . "'s Mibbit " . $this->lang->line('mtitle');
		$data['uri'] = $uri;
		$data['stats'] = 'http://neo.us.kdfs.net/';

		// Labels
		$data['mlabel'] = array(
			'stats_begin' => $this->lang->line('mlabels_stats_begin'),
			'stats_end' => $this->lang->line('mlabels_stats_end'),
			'irc_help' => $this->lang->line('mlabels_help'),
			'irc_new' => $this->lang->line('mlabels_new'),
			'clear' => $this->lang->line('mlabels_clear'),
			'nickname' => $this->lang->line('mlabels_nickname'),
			'query' => $this->lang->line('mlabels_query'),
			'whois' => $this->lang->line('mlabels_whois'),
			'emote' => $this->lang->line('mlabels_emote'),
			'away' => $this->lang->line('mlabels_away'),
			'back' => $this->lang->line('mlabels_back'),
			'real1' => $this->lang->line('mlabels_real1'),
			'click_here' => $this->lang->line('mlabels_click'),
			'real2' => $this->lang->line('mlabels_real2'),
			'iframe' => $this->lang->line('mlabels_iframe'),
			'new_window1' => $this->lang->line('mlabels_new_window1'),
			'new_window2' => $this->lang->line('mlabels_new_window2'),
		);

		// Get view file page location
		$view_loc = view_location('main_chat', $this->skin, 'main');

		// write data to the template
		$this->template->write('title', $this->lang->line('mtitle'));
		$this->template->write_view('content', $view_loc, $data);

		// render the template
		$this->template->render();
	}

	function _is_valid_nickname($nickname = '')
	{
		if ($nickname != '')
		{
			for($i = 0, $maxi = strlen($nickname); $i < $maxi; $i++)
			{
				$code = ord($nickname[$i]);
				if( !(($i > 0 && ( $code == 45 || ($code >= 48 && $code <= 57) )) || ($code >= 65 && $code <= 125)) ) break;
			}
			return ($i == $maxi);
		}
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */