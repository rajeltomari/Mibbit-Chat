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

	function settings()
	{
		/* check access */
		$this->auth->check_access();

		/* load the resources */
		$this->load->model('menu_model');
		$this->load->model('ranks_model', 'ranks');

		/* load mibbit chat settings model */
		$this->load->model('chat_model', 'chat');

		if (isset($_POST['submit']))
		{
			$key_exceptions = array('submit', 'old_sim_type');

			foreach ($_POST as $key => $value)
			{
				if (!in_array($key, $key_exceptions))
				{
					$update_array['setting_value'] = $this->input->xss_clean($value);

					/* run the update query */
					$update = $this->settings->update_setting($key, $update_array);

					if ($key == 'timezone' && $value != $this->timezone)
					{ /* make sure if the timezone has changed that it's updated */
						$this->timezone = $this->settings->get_setting('timezone');
					}
				}
			}

			if ($update > 0)
			{
				$new_type = $this->input->post('sim_type', TRUE);
				$old_type = $this->input->post('old_sim_type', TRUE);

				if ($new_type != $old_type)
				{
					$data_old = array('menu_display' => 'n');
					$data_new = array('menu_display' => 'y');

					$this->menu_model->update_menu_item($data_old, $old_type, 'menu_sim_type');
					$this->menu_model->update_menu_item($data_new, $new_type, 'menu_sim_type');
				}

				$message = sprintf(
					lang('flash_success_plural'),
					ucfirst(lang('labels_site') .' '. lang('labels_settings')),
					lang('actions_updated'),
					''
				);

				$flash['status'] = 'success';
				$flash['message'] = text_output($message);
			}
			else
			{
				$message = sprintf(
					lang('flash_failure_plural'),
					ucfirst(lang('labels_site') .' '. lang('labels_settings')),
					lang('actions_updated'),
					''
				);

				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}

			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
		}

		/* mibbit submit button */
		if (isset($_POST['submit-mibbit']))
		{
			foreach ($_POST as $key => $value)
			{
				if (!in_array($key, $key_exceptions))
				{
					$update_array['setting_value'] = $this->input->xss_clean($value);

					/* run the update query */
					$update = $this->chat->update_setting($key, $update_array);
				}
			}

			if ($update > 0)
			{
				$message = sprintf(
					lang('flash_success_plural'),
					ucfirst(lang('labels_site') .' '. lang('labels_settings')),
					lang('actions_updated'),
					''
				);

				$flash['status'] = 'success';
				$flash['message'] = text_output($message);
			}
			else
			{
				$message = sprintf(
					lang('flash_failure_plural'),
					ucfirst(lang('labels_site') .' '. lang('labels_settings')),
					lang('actions_updated'),
					''
				);

				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}

			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
		}

		/* grab all settings */
		$settings = $this->settings->get_all_settings();

		if ($settings->num_rows() > 0)
		{
			foreach ($settings->result() as $value)
			{
				$setting[$value->setting_key] = $value->setting_value;
			}

			/* submit button */
			$data['button_submit'] = array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))
			);

			$data['images'] = array(
				'help' => array(
					'src' => img_location('help.png', $this->skin, 'admin'),
					'alt' => lang('whats_this')),
				'gear' => array(
					'src' => img_location('gear.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image inline_img_left'),
				'view' => array(
					'src' => img_location('icon-view.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image'),
				'loading' => array(
					'src' => img_location('loading-circle.gif', $this->skin, 'admin'),
					'alt' => lang('actions_loading'),
					'class' => 'image'),
			);

			/*
			|---------------------------------------------------------------
			| SIM
			|---------------------------------------------------------------
			*/

			$data['inputs'] = array(
				'sim_name' => array(
					'name' => 'sim_name',
					'id' => 'sim_name',
					'value' => $setting['sim_name']),
				'sim_year' => array(
					'name' => 'sim_year',
					'id' => 'sim_year',
					'class' => 'medium',
					'value' => $setting['sim_year'])
			);

			/* get the sim types */
			$type = $this->settings->get_sim_types();

			if ($type->num_rows() > 0)
			{
				$data['values']['sim_type'][0] = ucwords(lang('labels_please') .' '.
					lang('actions_choose') .' '. lang('order_one'));

				foreach ($type->result() as $value)
				{
					$data['values']['sim_type'][$value->simtype_id] = ucwords($value->simtype_name);
				}
			}

			/*
			|---------------------------------------------------------------
			| SYSTEM/EMAIL
			|---------------------------------------------------------------
			*/

			$data['inputs'] += array(
				'sys_email_on' => array(
					'name' => 'system_email',
					'id' => 'sys_email_on',
					'value' => 'on',
					'checked' => ($setting['system_email'] == 'on') ? TRUE : FALSE),
				'sys_email_off' => array(
					'name' => 'system_email',
					'id' => 'sys_email_off',
					'value' => 'off',
					'checked' => ($setting['system_email'] == 'off') ? TRUE : FALSE),
				'email_subject' => array(
					'name' => 'email_subject',
					'id' => 'email_subject',
					'value' => $setting['email_subject']),
				'allowed_playing_chars' => array(
					'name' => 'allowed_chars_playing',
					'id' => 'allowed_chars_playing',
					'value' => $setting['allowed_chars_playing'],
					'class' => 'small'),
				'allowed_npcs' => array(
					'name' => 'allowed_chars_npc',
					'id' => 'allowed_chars_npc',
					'value' => $setting['allowed_chars_npc'],
					'class' => 'small'),
				'maintenance_on' => array(
					'name' => 'maintenance',
					'id' => 'maintenance_on',
					'value' => 'on',
					'checked' => ($setting['maintenance'] == 'on') ? TRUE : FALSE),
				'maintenance_off' => array(
					'name' => 'maintenance',
					'id' => 'maintenance_off',
					'value' => 'off',
					'checked' => ($setting['maintenance'] == 'off') ? TRUE : FALSE),
				'dst_y' => array(
					'name' => 'daylight_savings',
					'id' => 'dst_y',
					'value' => 'TRUE',
					'checked' => ($setting['daylight_savings'] == 'TRUE') ? TRUE : FALSE),
				'dst_n' => array(
					'name' => 'daylight_savings',
					'id' => 'dst_n',
					'value' => 'FALSE',
					'checked' => ($setting['daylight_savings'] == 'FALSE') ? TRUE : FALSE),
				'email_name' => array(
					'name' => 'default_email_name',
					'id' => 'default_email_name',
					'value' => $setting['default_email_name']),
				'email_address' => array(
					'name' => 'default_email_address',
					'id' => 'default_email_address',
					'value' => $setting['default_email_address']),
				'online_timespan' => array(
					'name' => 'online_timespan',
					'id' => 'online_timespan',
					'class' => 'small',
					'value' => $setting['online_timespan']),
				'posting_req' => array(
					'name' => 'posting_requirement',
					'value' => $setting['posting_requirement'],
					'class' => 'small'),
			);

			$data['values']['updates'] = array(
				'all' => ucwords(lang('labels_all') .' '. lang('labels_updates')),
				'major' => ucwords(lang('status_major') .' '. lang('labels_updates') .' '. lang('labels_only')) .' (1.0, 2.0, etc.)',
				'minor' => ucwords(lang('status_minor') .' '. lang('labels_updates') .' '. lang('labels_only')) .' (1.1, 1.2, etc.)',
				'update' => ucwords(lang('status_incremental') .' '. lang('labels_updates') .' '. lang('labels_only')) .' (1.0.1, 1.0.2, etc.)',
				'none' => ucwords(lang('labels_no') .' '. lang('labels_updates'))
			);

			$data['values']['date_format'] = array(
				'%D %M %j%S, %Y @ %g:%i%a'	=> 'Mon Jan 1st, 2009 @ 12:01am',
				'%D %M %j, %Y @ %g:%i%a'	=> 'Mon Jan 1, 2009 @ 12:01am',
				'%l %F %j%S, %Y @ %g:%i%a'	=> 'Monday January 1st, 2009 @ 12:01am',
				'%l %F %j, %Y @ %g:%i%a'	=> 'Monday January 1, 2009 @ 12:01am',
				'%m/%d/%Y @ %g:%i%a'		=> '01/01/2009 @ 12:01am',
				'%d %M %Y @ %g:%i%a'		=> '01 Jan 2009 @ 12:01am'
			);

			/* defaults */
			$data['default']['sim_type'] = $setting['sim_type'];
			$data['default']['updates'] = $setting['updates'];
			$data['default']['date_format'] = $setting['date_format'];

			/*
			|---------------------------------------------------------------
			| APPEARANCE
			|---------------------------------------------------------------
			*/

			$skins = $this->sys->get_all_skins();
			$ranks = $this->ranks->get_all_rank_sets();

			if ($skins->num_rows() > 0)
			{
				foreach ($skins->result() as $skin)
				{
					$sections = $this->sys->get_skin_sections($skin->skin_location);

					if ($sections->num_rows() > 0)
					{
						foreach ($sections->result() as $section)
						{
							$data['themes'][$section->skinsec_section][$skin->skin_location] = $skin->skin_name;
						}
					}
				}
			}

			if ($ranks->num_rows() > 0)
			{
				$ext = $this->ranks->get_rankcat($this->options['display_rank'], 'rankcat_location', 'rankcat_extension');

				$data['inputs']['rank'] = array(
					'src' => rank_location($this->options['display_rank'], 'preview', $ext),
					'alt' => ''
				);

				foreach ($ranks->result() as $rank)
				{
					$data['values']['ranks'][$rank->rankcat_location] = $rank->rankcat_name;
				}
			}

			$data['inputs'] += array(
				'list_logs_num' => array(
					'name' => 'list_logs_num',
					'id' => 'list_logs_num',
					'class' => 'small',
					'value' => $setting['list_logs_num']),
				'list_posts_num' => array(
					'name' => 'list_posts_num',
					'id' => 'list_posts_num',
					'class' => 'small',
					'value' => $setting['list_posts_num']),
				'show_news_y' => array(
					'name' => 'show_news',
					'id' => 'show_news_y',
					'value' => 'y',
					'checked' => ($setting['show_news'] == 'y') ? TRUE : FALSE),
				'show_news_n' => array(
					'name' => 'show_news',
					'id' => 'show_news_n',
					'value' => 'n',
					'checked' => ($setting['show_news'] == 'n') ? TRUE : FALSE),
				'use_mission_notes_y' => array(
					'name' => 'use_mission_notes',
					'id' => 'use_mission_notes_y',
					'value' => 'y',
					'checked' => ($setting['use_mission_notes'] == 'y') ? TRUE : FALSE),
				'use_mission_notes_n' => array(
					'name' => 'use_mission_notes',
					'id' => 'use_mission_notes_n',
					'value' => 'n',
					'checked' => ($setting['use_mission_notes'] == 'n') ? TRUE : FALSE),
				'use_sample_post_y' => array(
					'name' => 'use_sample_post',
					'id' => 'use_sample_post_y',
					'value' => 'y',
					'checked' => ($setting['use_sample_post'] == 'y') ? TRUE : FALSE),
				'use_sample_post_n' => array(
					'name' => 'use_sample_post',
					'id' => 'use_sample_post_n',
					'value' => 'n',
					'checked' => ($setting['use_sample_post'] == 'n') ? TRUE : FALSE),
				'post_count_multi' => array(
					'name' => 'post_count_format',
					'id' => 'post_count_multi',
					'value' => 'multiple',
					'checked' => ($setting['post_count_format'] == 'multiple') ? TRUE : FALSE),
				'post_count_single' => array(
					'name' => 'post_count_format',
					'id' => 'post_count_single',
					'value' => 'single',
					'checked' => ($setting['post_count_format'] == 'single') ? TRUE : FALSE),
			);

			$data['default']['skin_main'] = $setting['skin_main'];
			$data['default']['skin_admin'] = $setting['skin_admin'];
			$data['default']['skin_wiki'] = $setting['skin_wiki'];
			$data['default']['skin_login'] = $setting['skin_login'];

			$data['values']['manifest'] = array(
				"" => ucfirst(lang('labels_none')),
				"$('tr.active').show();" => ucwords(lang('status_active') .' '. lang('global_characters') .' '. 
					lang('labels_only')),
				"$('tr.npc').show();" => ucwords(lang('abbr_npcs') .' '. lang('labels_only')),
				"$('tr.open').show();" => ucwords(lang('status_open') .' '. lang('global_positions') .' '. 
					lang('labels_only')),
				"$('tr.past').show();" => ucwords(lang('status_inactive') .' '. lang('global_characters') .' '. 
					lang('labels_only')),
				"$('tr.active').show();,$('tr.npc').show();" => ucwords(lang('status_active') .' '. 					lang('global_characters') .' &amp; '. lang('abbr_npcs')),
				"$('tr.active').show();,$('tr.npc').show();,$('tr.open').show();" => ucwords(lang('status_active') .' '. 
					lang('global_characters') .', '. lang('abbr_npcs') .' &amp; '. lang('status_open') .' '.
					lang('global_positions')),
				"$('tr.npc').show();,$('tr.open').show();" => ucwords(lang('abbr_npcs') .' &amp; '. lang('status_open') .' '.
					lang('global_positions')),
			);

			$data['default']['manifest'] = $setting['manifest_defaults'];
		}

		/*
		|---------------------------------------------------------------
		| USER ITEMS
		|---------------------------------------------------------------
		*/

		/* grab all settings */
		$user = $this->settings->get_all_settings('y');
		
		if ($user->num_rows() > 0)
		{
			foreach ($user->result() as $u)
			{
				$data['user'][] = array(
					'id' => $u->setting_id,
					'key' => $u->setting_key,
					'label' => $u->setting_label,
					'value' => $u->setting_value
				);
			}
		}

		/*
		|---------------------------------------------------------------
		| MIBBIT CHAT ITEMS
		|---------------------------------------------------------------
		*/

		/* grab all settings */
		$chat = $this->chat->get_all_settings();

		if ($chat->num_rows() > 0)
		{
			foreach ($chat->result() as $value)
			{
				$setting[$value->mibbit_key] = $value->mibbit_value;
			}

			/* submit button */
			$data['button_submit_mibbit'] = array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit-mibbit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))
			);

			$data['mchat'] = array(
				'server_name' => array(
					'name' => 'server_name',
					'id' => 'server_name',
					'value' => $setting['server_name']),
				'server_address' => array(
					'name' => 'server_address',
					'id' => 'server_address',
					'value' => $setting['server_address']),
				'server_channel' => array(
					'name' => 'channel',
					'id' => 'channel',
					'value' => $setting['channel']),
				'server_guest' => array(
					'name' => 'guest_prefix',
					'id' => 'guest_prefix',
					'value' => $setting['guest_prefix']),
				'server_widget' => array(
					'name' => 'widgetid',
					'id' => 'widgetid',
					'value' => $setting['widgetid']),
				'server_stats_url' => array(
					'name' => 'stats_page_url',
					'id' => 'stats_page_url',
					'value' => $setting['stats_page_url']),
				'server_height' => array(
					'name' => 'height',
					'id' => 'height',
					'value' => $setting['height']),
				'server_width' => array(
					'name' => 'width',
					'id' => 'width',
					'value' => $setting['width']),
			);
		}

		/* set the header */
		$data['header'] = ucwords(lang('labels_site') .' '. lang('labels_settings'));

		$data['label'] = array(
			'allowed_chars' => ucfirst(lang('labels_number')) .' '. lang('labels_of') .' '. 
				ucwords(lang('labels_allowed') .' '. lang('status_playing') .' '. lang('global_characters')),
			'allowed_npcs' => ucfirst(lang('labels_number')) .' '. lang('labels_of') .' '. 
				ucwords(lang('labels_allowed') .' '. lang('abbr_npcs')),
			'appearance' => ucfirst(lang('labels_appearance')),
			'count_format' => ucwords(lang('global_post') .' '. lang('labels_count') .' '. lang('labels_format')),
			'count_multiple' => ucfirst(lang('labels_multiple')),
			'count_single' => ucfirst(lang('labels_single')),
			'date' => ucwords(lang('labels_date') .' '. lang('labels_format')),
			'days' => lang('time_days'),
			'dst' => ucwords(lang('labels_dst')),
			'edit' => ucfirst(lang('actions_edit')),
			'emailaddress' => ucwords(lang('labels_default') .' '. lang('labels_email_address')),
			'emailname' => ucwords(lang('labels_default') .' '. lang('labels_email') .' '. lang('labels_name')),
			'emailsubject' => ucwords(lang('labels_email') .' '. lang('labels_subject')),
			'general' => ucfirst(lang('labels_general')),
			'header_email' => ucwords(lang('labels_email') .' '. lang('labels_settings')),
			'header_gen' => ucwords(lang('labels_general') .' '. lang('labels_information')),
			'header_options' => ucwords(lang('labels_display') .' '. lang('labels_options')),
			'header_skins' => ucfirst(lang('labels_skins')),
			'header_system' => ucwords(lang('labels_system') .' '. lang('labels_settings')),
			'header_user' => ucwords(lang('labels_user') .'-'. ucfirst(lang('actions_created')) 
				.' '. lang('labels_settings')),
			'header_chat' => ucwords(lang('labels_mibbit') . ' ' . lang('labels_settings')),
			'logs_num' => ucwords(lang('global_personallogs')) .' '. lang('labels_per') .' '. ucfirst(lang('labels_page')),
			'maint' => ucwords(lang('labels_maintanance') .' '. lang('labels_mode')),
			'manageuser' => ucwords(lang('actions_manage') .' '. lang('labels_user') .'-'. ucfirst(lang('actions_created')) 
				.' '. lang('labels_settings') .' '. RARROW),
			'manifest' => ucwords(lang('labels_default') .' '. lang('labels_manifest') .' '. lang('labels_display')),
			'mibbit' => ucfirst(lang('mibbit')),
			'minutes' => lang('time_minutes'),
			'mserver_address' => lang('mserver_address'),
			'mserver_channel' => lang('m_channels'),
			'mserver_guest' => lang('m_guest_pre'),
			'mserver_height' => lang('m_height'),
			'mserver_name' => lang('mserver_name'),
			'mserver_stats_url' => lang('mserver_stats_url'),
			'mserver_width' => lang('m_width'),
			'mserver_widget' => lang('mserver_widget'),
			'name' => ucwords(lang('global_sim') .' '. lang('labels_name')),
			'news_show' => ucwords(lang('actions_show') .' '. lang('global_news')) .' '. lang('labels_on') .' '.
				ucwords(lang('labels_main') .' '. lang('labels_page')),
			'no' => ucfirst(lang('labels_no')),
			'off' => ucfirst(lang('labels_off')),
			'on' => ucfirst(lang('labels_on')),
			'online' => lang('misc_label_online'),
			'posts_num' => ucwords(lang('global_missionposts')) .' '. lang('labels_per') .' '. ucfirst(lang('labels_page')),
			'rank' => ucwords(lang('global_rank') .' '. lang('labels_set')),
			'requirement' => ucwords(lang('labels_posting') .' '. lang('labels_requirements')),
			'sample_post' => ucwords(lang('actions_use') .' '. lang('labels_sample_post')) .' '. lang('labels_on') .' '.
				ucwords(lang('actions_join') .' '. lang('labels_page')),
			'skin_admin' => ucwords(lang('labels_admin') .' '. lang('labels_site')),
			'skin_login' => ucwords(lang('actions_login') .' '. lang('labels_page')),
			'skin_main' => ucwords(lang('labels_main') .' '. lang('labels_site')),
			'skin_wiki' => ucfirst(lang('global_wiki')),
			'sysemail' => ucwords(lang('labels_system') .' '. lang('labels_email')),
			'system' => ucwords(lang('labels_system') .'/'. ucfirst(lang('labels_email'))),
			'timezone' => ucfirst(lang('labels_timezone')),
			'tt_online_timespan' => lang('info_online_timespan'),
			'tt_post_count' => lang('info_post_count_format'),
			'tt_posting_requirement' => lang('info_posting_req'),
			'type' => ucwords(lang('global_sim') .' '. lang('labels_type')),
			'updates' => ucwords(lang('labels_update') .' '. lang('labels_notification')),
			'use_notes' => ucwords(lang('actions_use') .' '. lang('global_mission') .' '. lang('labels_notes')),
			'user' => ucwords(lang('labels_user') .'-'. lang('actions_created') .' '. lang('labels_settings')),
			'year' => ucwords(lang('global_sim') .' '. lang('time_year')),
			'yes' => ucfirst(lang('labels_yes')),
		);

		/* set the js data */
		$js_data['tab'] = $this->uri->segment(3, 0, TRUE);

		/* figure out where the view should be coming from */
		$view_loc = view_location('site_settings', $this->skin, 'admin');
		$js_loc = js_location('site_settings_js', $this->skin, 'admin');

		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);

		/* render the template */
		$this->template->render();
	}
}

/* End of file site.php */
/* Location: ./application/controllers/site.php */