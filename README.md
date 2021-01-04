# Painel-v20
<body>
How to install CENTOS 7

First need install lamp Packpage

Use the root user for this!

yum install https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm

yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm

yum install yum-utils

yum-config-manager --enable remi-php55

yum install httpd php php-mcrypt php-cli php-gd php-curl php-mysql php-ldap php-zip php-fileinfo mariadb-server mariadb libssh2-devel libssh2 zip unzip

yum install nano

service httpd reload

sudo firewall-cmd --permanent --zone=public --add-service=http <br>
sudo firewall-cmd --permanent --zone=public --add-service=https<br>
sudo firewall-cmd --reload<br>

yum install phpmyadmin

Now need create a password for the maria db server 

service mariadb start

mysql_secure_installation

Change the password for what you like 

enable the mariadb for a service 

systemctl enable mariadb.service

after this now go to install the panel

cd /var/www/html

Use the following command to clear the folder 

rm -R -F *

Download the .zip arquive for the panel 

wget https://bigbolgames.com/v20/v20.zip

Unzip the arquive

unzip v20.zip

now change the password 

nano pages/system/pass.php

change the 1010 to the password of root Mysql you set in the instalation 

Now in the browser enter in the PhpMyadmin

YourIP/phpmyadmin

enter the user root and password, and create the DB sshplus

now download the DB in you PC for uploud 

https://bigbolgames.com/v20/bd.sql

in the BD sshplus click in import and select the arquive bd.sql you downloaded 

after this now go back to your server for create Crontab SHELL

in root folder create the folder cron

in the folder cron create this scripts .sh

use the nano for this

nano cron.sh

paste this code below:

while true <br>
do <br>
  /usr/bin/php /var/www/html/pages/system/cron.php<br>
 echo "ok 1"<br>
  /usr/bin/php /var/www/html/pages/system/cron.ssh.php<br>
 echo "ok 2"<br>
  /usr/bin/php /var/www/html/pages/system/cron.servidor.php<br>
 echo "ok 3"<br>
  /bin/html.sh<br>
echo "Ok4 "<br>
  /usr/bin/php /var/www/html/pages/system/cron.online.ssh.php<br>
  echo "Ok 5" <br>
sleep 10<br>
done<br>

for save use ctrl + x y

now for the kill (this prevent overflow in php)

nano kill.sh

while true <br>
do <br>
now=$(date +"%T")<br>
ps -efw | grep php | grep -v grep | awk '{print $2}' | xargs kill<br>
echo "OK $now" >> log.txt<br>
echo "300 segundos!" <br>
sleep 300<br>
done<br>

for save use ctrl + x y

now the clean (this remove the history of online for the BD not get much larger)

nano clean.sh

while true <br>
do <br>
/usr/bin/php /var/www/html/pages/system/cron.limpeza.php<br>
echo "OK $now" >> log2.txt<br>
echo "300 segundos!" <br>
sleep 300<br>
done<br>

for save use ctrl + x y

now the start.sh for this need install screen 

yum install screen -y

nano start.sh

screen -dmS cron ./cron.sh<br>
screen -dmS kill ./kill.sh<br>
screen -dmS clean ./clean.sh<br>

for save use ctrl + x y

For enable the test arquives in the server need another script, for this need to do to folder /bin

cd /bin 

now download the script

wget https://bigbolgames.com/v20/html.sh

chmod +x html.sh

Now start all the crons

cd /root/cron

chmod +x *.sh

./start.sh

if you follow all the tutorial correctly the panel is working 100%

if any command get error plis open a issue for i can correct the tutorial 

  <p style="color:#FF0000";>Red paragraph text</p>

</body>
