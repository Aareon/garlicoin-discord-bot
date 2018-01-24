# garlicoin-discord-bot

Instructions:

Required packages: 
* php5 (or above) 
* php-curl

STEP 1

Setup a discord webhook for the channel you want the bot to message into. 

STEP 2

Save the webhook link in Step 1 into the variable string on line 19 in block-check.php (`$discordWebhook = '{{YOUR DISCORD WEBHOOK}}';`).
Put the JSON API URL into the variable string on line 17 (`$jsonMiningApi = '{{YOUR JSON API URL}}';`).
Update `$discordBotName` and `$discordNewBlockMessage` as you see fit.

STEP 3

Run the php file using cron or a similar regular function. We need to setup the file to long-poll the API.

*********************************************
*******FREEBSD Crontab Instructions**********
*********************************************
Use the command `ee /etc/crontab` to open up cron.

Add the following line (make sure to update the filepath to block-check.php):
`*       *       *       *       *       /usr/local/bin/php -q {{file path}}/block-check.php`

Press escape to bring up the menu and exit (make sure to save changes).

Use the command `/etc/rc.d/cron restart` to restart cron.

The file will now run a check every minute.

*********************************************
************Other Nix Distros****************
*********************************************

Other Linux Distro's just need to ensure the pathway to PHP is correct. Generally this just means putting in `php` instead of `/usr/local/bin/php` in the above cron. Sometimes you might need to put in the full path though (usually /usr/local/php).
