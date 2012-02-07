Nova Mibbit Chat Application
============================
Developer: Dustin Lennon<br />
Email: <demonicpagan@gmail.com>

This application is developed under the licenses of Nova and CodeIgniter.

Install Instructions
--------------------
The following application will add a Mibbit chat application to your Nova management system. To install this
application you need to perform the following steps.

1. Upload application/config/mibbit.php to your application/config folder of your Nova install. Configure the 
MOD in this file. The width and height can be any valid CSS value.

2. Upload application/controllers/main.php to your application/controllers folder of your Nova install replacing 
the existing one if you haven't already modified this file. If you already have changes in this file, it's best 
that you just take the contents of this file and add it into your existing main.php file.

3. Add the following line into your app_lang.php for your associated language(s) after the rest of the includes 
and before the Global items.

	`/* include Mibbit Chat Language file */`<br />
	`include_once APPPATH .'language/'. $language . '/mibbit_chat_lang.php';`

4. Upload application/language/english/mibbit_chat_lang.php to your 
application/views/language/english folder of your Nova install. Translate this page into other languages and upload
them to the appropriate language directories. (If you would like your language included into a future release, 
please contact me via email.)

5. Upload application/views/_base_override/main/pages/main_chat.php to your
application/views/_base_override/main/pages folder of your Nova install.

6. Log into your Nova management system and add a Chat menu item so your users can access your Mibbit chat page.
You will use the link of main/chat when you create the menu item.

If you experience any issues please submit a bug report on 
<http://github.com/demonicpagan/Nova-Mibbit-Chat-MOD/issues>.

You can always get the latest source from <http://github.com/demonicpagan/Nova-Mibbit-Chat-MOD> as well.

Changelog - Dates are in Epoch time
-----------------------------------
1272511286:

*	Created a more readable README for GitHub.

1271970692:

*	Changed how you configure the plugin removing the need to add a database table and alter the admin page.
*	Configuration of this MOD is done through a config file now. (Suggested by Anodyne Productions)

1271763038:

*	Updated README to add what to do in case RSS External Feeds MOD is currently installed.

1269985580:

*	Updated README to reflect the proper URLs for issue reporting and viewing the project.

1269781457:

*	Made the final alterations on all files.
*	Admin interface completed and appears to be bug free.

1269666000:

*	Modified README to reflect installation changes.
*	Modified main.php to make use of database table and the updated schema from last time this was worked on.
*	Added application/models/chat_model.php to handle database queries
*	Started work on admin page to modify chat settings.

1246910721:

*	Added english language file.
*	Modified main.php to use language file.
*	Modified main_chat.php to use language file.
*	Modified README to provide information about language file.

1244254514:

*	Initial submission to SVN repository.

1244254777:

*	First development of application.

1246918080:

*	Added english language file
*	Modified main.php to use language file.
*	Modified main_chat.php to use language file.
*	Modified README to provide information about language file.
*	Included application/language/english directory and file to SVN

1255440240:

*	Adding admin backend to configure the mibbit chat.

1255440420:

*	Base file to add the admin backend for the mibbit chat.

1255508940:

*	Changed mind as to what section to put the administration under

1255514880:

*	Getting ready to add the admin interface for the Mibbit chat to nova.
*	Added modules and modules/settings_model.php