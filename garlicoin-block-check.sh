#!/bin/bash
loop=0
while [ $loop -lt 12 ]; do
  loop=$(($loop+1))
 /usr/local/bin/php -q /usr/home/nathan/pims/public/garlicoin/block-check.php
 /bin/sleep 5
 loop=$(($loop+1))
done
