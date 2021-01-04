while true 
do 
  /usr/bin/php /var/www/html/pages/system/cron.php
 echo "ok 1"
  /usr/bin/php /var/www/html/pages/system/cron.ssh.php
 echo "ok 2"
  /usr/bin/php /var/www/html/pages/system/cron.servidor.php
 echo "ok 3"
  /bin/html.sh
echo "Ok4 "
  /usr/bin/php /var/www/html/pages/system/cron.online.ssh.php
  echo "Ok 5" 
sleep 1
done
