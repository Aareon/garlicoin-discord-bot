# garlicoin-discord-bot

Instructions:

Required packages: 
* php5 (or above) 
* php-curl

STEP 1

Setup a discord webhook for the channel you want the bot to message into. 

STEP 2

Save the webhook link in Step 1 into the variable string on line 16 in config.php (`$discordWebhook = '{{YOUR DISCORD WEBHOOK}}';`).

Put the Mining Pools JSON API URL into the variable string on line 14 (`$jsonMiningApi = '{{YOUR JSON API URL}}';`).

Update `$discordBotName`, `$discordNewPendingBlockMessage` and `$discordNewConfirmedBlockMessage` as you see fit.

STEP 3

Make sure the file lastBlockCount.txt can be written and read by the PHP user/group permissions.

STEP 4

Update the shell script `garlicoin-block-check.sh` to have the correct filepath to batch-check.php and to PHP if needed (should work on most linux distro's).

FreeBSD will need line 5 to be `/usr/local/bin/php -q /usr/home/nathan/pims/public/garlicoin/block-check.php`

STEP 5

Run the shell script every minute using cron.

Add the following line (make sure to update the filepath to block-check.php):
`*       *       *       *       *       {{file/path}}/garlicin-block-check.sh
