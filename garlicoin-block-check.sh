#!/bin/bash
loop=0
while [ $loop -lt 12 ]; do
  loop=$(($loop+1))
 php -q /garlicoin/block-check.php
 sleep 5
 loop=$(($loop+1))
done
