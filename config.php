<?php
/*
 *
 * @param string $jsonMiningApi The URL of the mining pools JSON API
 * @param string $lastConfirmedBlockCountFilePath The filepath of the writeable txt file used to save the latest confirmed blocks
 * @param string $discordWebhook The url of the webhook made in Discord
 * @param string $discordBotName The username that appears in the channel when a message is made
 * @param string $discordNewPendingBlockMessage What you want the discord bot message to display when a new pending block is found
 * @param string $discordNewConfirmedBlockMessage What you want the discord bot message to display when a new confirmed block is made
 *
 */


$jsonMiningApi = 'http://hry-mining.co/api/stats';
$lastBlockCountFilePath = __DIR__ . '/lastBlockCount.txt';
$discordWebhook = '';
$discordBotName = 'Nascowe';
$discordNewPendingBlockMessage = 'Garlic Bread is in the oven! New Pending Block.';
$discordNewConfirmedBlockMessage = 'Garlic Bread is served! Confirmed Block is being paid out!';

?>
