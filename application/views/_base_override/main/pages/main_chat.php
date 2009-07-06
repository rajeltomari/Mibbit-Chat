<?php echo text_output($header, 'h1', 'page_head'); ?>

<center>
	<iframe src='<?php echo $uri; ?>' frameborder='0' style='height: 400px; width: 96%;'>
		<?php echo $mlabel['iframe']; ?>.<br />
		<?php echo $mlabel['new_window1']; ?> <a href='<?php echo $uri; ?>' target='_blank'><?php echo $mlabel['new_window2']; ?>...</a>
	</iframe>
</center>
<br />
<?php echo $mlabel['stats_begin']; ?> <a href='<?php echo $stats; ?>' target='_blank'><?php echo $mlabel['stats_end']; ?></a>.<br />
<font style='font-weight: bold;'><?php echo $mlabel['irc_help']; ?></font><br />
<?php echo $mlabel['irc_new']; ?>:
<ul>
	<li>/clear <?php echo $mlabel['clear']; ?></li>
	<li>/nick [nick] <?php echo $mlabel['nickname']; ?></li>
	<li>/query (or /msg) [nick] [msg] <?php echo $mlabel['query']; ?></li>
	<li>/whois [nick] <?php echo $mlabel['whois']; ?></li>
	<li>/me [text] <?php echo $mlabel['emote']; ?></li>
	<li>/away [msg] <?php echo $mlabel['away']; ?></li>
	<li>/back <?php echo $mlabel['back']; ?></li>
</ul>
<br />
<?php echo $mlabel['real1']; ?> <a href='http://www.mirc.com/get.html'><?php echo $mlabel['click_here']; ?></a>
<?php echo $mlabel['real2']; ?>.