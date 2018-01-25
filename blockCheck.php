<?php

require_once(__DIR__ . "/DiscordClient.class.php");
include(__DIR__ . "/config.php");

//Get the JSON output from the pool server
$ch = curl_init($jsonMiningApi);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$jsonApiText = curl_exec($ch);
$jsonApiObj = json_decode($jsonApiText);

//get the pending and confirmed block count from the JSON Api Object
$currentPendingBlocks = (int) $jsonApiObj->pools->garlicoin->blocks->pending;
$currentConfirmedBlocks = (int) $jsonApiObj->pools->garlicoin->blocks->confirmed;

//get the previous confirmed block count and check it is legit by exploding it into two integers
$lastBlockCountFile = fopen($lastBlockCountFilePath, "r") or die("Unable to open file!");
$fileContentsString = fgets($lastBlockCountFile);
fclose($lastBlockCountFile);
$explodedString = explode("::", $fileContentsString);

if (count($explodedString) != 2) {
    //This is unexpected. There should be two integers in the array. 
    //Start afresh by overwriting lastBlockCount.txt with the current info.
    $lastBlockCountFile = fopen($lastBlockCountFilePath, "w") or die("Unable to open file!");
    fwrite($lastBlockCountFile, $currentPendingBlocks . '::' . $currentConfirmedBlocks);
    fclose($lastBlockCountFile);
    
    $lastPendingBlockCount = $currentPendingBlocks;
    $lastConfirmedBlockCount = $currentConfirmedBlocks;
} else {
    $lastPendingBlockCount = (int) $explodedString[0];
    $lastConfirmedBlockCount = (int) $explodedString[1];
}

if ($currentConfirmedBlocks > $lastConfirmedBlockCount || $currentPendingBlocks > $lastPendingBlockCount) {
    //there is a new pending or confirmed block. Alert Discord appropriately
    if ($currentPendingBlocks > $lastPendingBlockCount) {
        $discord = new DiscordClient($discordWebhook);
        $discord->name($discordBotName);
        $discord->send($discordNewPendingBlockMessage);
    }
    if ($currentConfirmedBlocks > $lastConfirmedBlockCount) {
        $discord = new DiscordClient($discordWebhook);
        $discord->name($discordBotName);
        $discord->send($discordNewConfirmedBlockMessage);
    }
        
    //Update lastBlockCount.txt with the current block counts
    $lastBlockCountFile = fopen($lastBlockCountFilePath, "w") or die("Unable to open file!");
    fwrite($lastBlockCountFile, $currentPendingBlocks . '::' . $currentConfirmedBlocks);
    fclose($lastBlockCountFile);
}
?>
