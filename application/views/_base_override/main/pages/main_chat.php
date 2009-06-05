<?php echo text_output($header, 'h1', 'page_head'); ?>

<center>
	<iframe src='<?php echo $uri; ?>' frameborder='0' style='height: 400px; width: 96%;'>
		Your user agent does not support frames or is currently configured not to display frames.<br />
		However, you may want to open the <a href='<?php echo $uri; ?>' target='_blank'>chat in a new browser window...</a>
	</iframe>
</center>
<br />
You can check out <a href='<?php echo $stats; ?>' target='_blank'>Our Channel's Stats Here</a>.<br />
<font style='font-weight: bold;'>IRC Help</font><br />
New to IRC? Here are some commands to get you started:
<ul>
	<li>/clear Clear the chat output in the channel</li>
	<li>/nick [nick] Change your nickname</li>
	<li>/query (or /msg) [nick] [msg] Open a PM to a user, with an optional message</li>
	<li>/whois [nick] Find out all the manner of things about someone</li>
	<li>/me [text] Emote</li>
	<li>/away [msg] Set your status to away, with an optional message</li>
	<li>/back Set your status to back</li>
</ul>
<br />
If you plan on doing a lot of chatting with us, it'll be best to <a href='http://www.mirc.com/get.html'>click here</a>
to Download a Real IRC Client.