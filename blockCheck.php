<?php

require_once("DiscordClient.class.php");

/*
 * This file saves the latest confirmed block count in a txt file and checks a mining pool JSON API for updates
 * If there is an update it alerts Discord by messaging a channel (defined by the webhook) 
 *
 * @param string $jsonMiningApi The URL of the mining pools JSON API
 * @param string $lastConfirmedBlockCountFilePath The filepath of the writeable txt file used to save the latest confirmed blocks
 * @param string $discordWebhook The url of the webhook made in Discord
 * @param string $discordBotName The username that appears in the channel when a message is made
 * @param string $discordNewBlockMessage What you want the discord bot message to display
 *
 */

$jsonMiningApi = ''; //E.g. http://hry-mining.co/api/stats
$lastConfirmedBlockCountFilePath = __DIR__ . '/lastConfirmedBlockCount.txt';
$discordWebhook = '';
$discordBotName = 'Nascowe';
$discordNewBlockMessage = 'New Block Confirmed!';

$ch = curl_init($jsonMiningApi);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$jsonApiText = curl_exec($ch);
$jsonApiObj = json_decode($jsonApiText);

//get the confirmed block count from the Api Object
$currentConfirmedBlocks = (int) $jsonApiObj->pools->garlicoin->blocks->confirmed;

//get the previous confirmed block count
$lastConfirmedBlockCountFile = fopen($lastConfirmedBlockCountFilePath, "r") or die("Unable to open file!");
$lastConfirmedBlockCount = (int) fgets($lastConfirmedBlockCountFile);
fclose($lastConfirmedBlockCountFile);

if (!is_integer($lastConfirmedBlockCount)) {
    $lastConfirmedBlockCountFile = fopen($lastConfirmedBlockCountFilePath, "w") or die("Unable to open file!");
    fwrite($lastConfirmedBlockCountFile, $currentConfirmedBlocks);
    fclose($lastConfirmedBlockCountFile);
    $lastConfirmedBlockCount = $currentConfirmedBlocks;
}

if ($currentConfirmedBlocks > $lastConfirmedBlockCount) {
    //there is a new confirmed block. Alert Discord
    $discord = new DiscordClient();
    $discord->name($discordBotName);
    $discord->send($discordNewBlockMessage);
    
    //Update lastConfirmedBlockCount.txt with the current confirmed block count
    $lastConfirmedBlockCountFile = fopen($lastConfirmedBlockCountFilePath, "w") or die("Unable to open file!");
    fwrite($lastConfirmedBlockCountFile, $currentConfirmedBlocks);
    fclose($lastConfirmedBlockCountFile);
}
?>
