Nova Mibbit Chat Application
============================
Developer: Dustin Lennon<br />
Email: <demonicpagan@gmail.com>

This application is developed under the licenses of Nova and CodeIgniter.

Install Instructions
--------------------
The following application will add a Mibbit chat application to your Nova management system. To install this
application you need to perform the following steps.

1. Upload application/config/chat.php to your application/config folder of your Nova install. Configure the 
MOD in this file. The width and height can be any valid CSS value.

2. Upload application/controllers/chat.php to your application/controllers folder of your Nova install.

3. Add the following line into your app_lang.php for your associated language(s) after the rest of the includes 
and before the Global items.

	`/* include Mibbit Chat Language file */`<br />
	`include_once APPPATH.'language/'.$language.'/chat_lang.php';`

4. Upload application/language/english/chat_lang.php to your application/views/language/english folder of your Nova install.
Translate this page into other languages and upload them to the appropriate language directories. (If you would like your
language included into a future release, please contact me via email.)

5. Upload application/views/_base_override/chat/pages/chat_index.php to your application/views/_base_override/main/pages
folder of your Nova install.

6. Log into your Nova management system and add a Chat menu item so your users can access your Mibbit chat page.
You will use the link of main/chat when you create the menu item.

If you experience any issues please submit a bug report on <http://github.com/rajeltomari/Nova-Mibbit-Chat/issues>.

You can always get the latest source from <http://github.com/rajeltomari/Nova-Mibbit-Chat> as well.