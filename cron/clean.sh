while true 
do 
/usr/bin/php /var/www/html/pages/system/cron.limpeza.php

echo "OK $now" >> log2.txt
echo "300 segundos!" 
sleep 300
done

