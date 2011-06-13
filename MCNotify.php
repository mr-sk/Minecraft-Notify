<?php
// Minecraft notification script
// Idea by mach aka Brossi
// Coded by sk aka mr_sk

$loggedInUsers = array();
$mcServerLog   = '~minecraft/server.log';

do
{
  $output    = exec("tail $mcServerLog");
  $outputSet = explode(' ', $output);
  if ('logged' == @ $outputSet[5] && 'in' == @ $outputSet[6])
  {
    $username = $outputSet[3];
    // Safe to assume someone logged in
    if (!isset($loggedInUsers[$username])) 
    { 
      // This is a new user (Not currently logged in)
      // So dispatch an email. 
      $loggedInUsers[$username] = $username; 
      $subject = sprintf("Logged in: %s", join(',', $loggedInUsers));
      $cmd     = sprintf('echo "psssssss B0000M!" | mail -s "%s" your@mail.com', $subject);
      exec($cmd);
    }
  }

  if ('lost' == $outputSet[4] && 'connection:' == $outputSet[5])
  {
    $username = $outputSet[3];
    unset($loggedInUsers[$username]);
  }

  sleep(2);
} while (1);