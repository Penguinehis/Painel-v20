#!/bin/bash
#Scripiter Penguin
#

# Color Codes

#Black        0;30     Dark Gray     1;30
#Red          0;31     Light Red     1;31
#Green        0;32     Light Green   1;32
#Brown/Orange 0;33     Yellow        1;33
#Blue         0;34     Light Blue    1;34
#Purple       0;35     Light Purple  1;35
#Cyan         0;36     Light Cyan    1;36
#Light Gray   0;37     White         1;37

menu()
{
black='\033[0;30m'
red='\033[0;31m'
green='\033[0;32m'
browno='\033[0;33m'
blue='\033[0;34m'
purple='\033[0;35m'
cyan='\033[0;36m'
lightgray='\033[0;37m'
darkgray='\033[1;30m'
lightred='\033[1;31m'
lightgreen='\033[1;32m'
yellow='\033[1;33m'
lightblue='\033[1;34m'
lightpurple='\033[1;35m'
lightcyan='\033[1;36m'
white='\033[1;37m'
port2=$(lsof -i -P -n | grep LISTEN | grep httpd | sed -n -e '1{s/^.*://p}')
clear
tput setaf 7 ; tput setab 4 ; tput bold ; printf '%30s%s%-10s\n' "Painel Web V20 Centos 7 Installer" ; tput sgr0 ; echo ""
tput setaf 7 ; tput setab 4 ; tput bold ; printf "${red}Portas abertas: " ; echo $port2 | sed -n 's_([^ ]*__p' ; tput sgr0 ; echo ""
tput setaf 2 ; tput bold ; printf '%s' "|1|"; tput setaf 6 ; printf '%s' " Instalar" ; tput setaf 4 ; printf '%s' " = " ; tput setaf 7 ; echo "Instalar o Painel WEB" ; tput sgr0 ;
tput setaf 2 ; tput bold ; printf '%s' "|0|"; tput setaf 6 ; printf '%s' " Sair" ; tput setaf 4 ; printf '%s' " = " ; tput setaf 7 ; echo "So sai O.o" ; tput sgr0 ;
echo ""
tput setaf 7 ; tput setab 4 ; tput bold ; printf '%30s%s%-10s\n' "Digite a opcao desejada" ; tput sgr0 ; echo ""
read  opcao

case $opcao in
	1) install ;;
	0) voltar ;;
esac
}

install()
{
printf "${cuan}Digite a porta desejada para o painel web, ${red}Porta: ${white}"
read port
if [ -z "$port" ]; then
echo "Porta vazia"
sleep 2
install
else
yum install https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm -y 
yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm -y 
yum install yum-utils -y 
yum-config-manager --enable remi-php56
yum install httpd php php-mcrypt php-cli php-ssh2 php-gd php-curl php-mysql php-ldap php-zip php-fileinfo mariadb-server mariadb libssh2-devel libssh2 zip unzip wget gcc make -y 
yum install nano -y 
service httpd reload
if [[ "$port" == "80" ]]; then
firewall-cmd --permanent --zone=public --add-service=http,
firewall-cmd --permanent --zone=public --add-service=https
firewall-cmd --reload
fi
clear
printf "${green} Vamos configurar o Mysql"
echo ""
printf "${green} Para isso o script ira iniciar mariadb em modo de seguranca"
echo ""
printf "${green} por favor ao colocar a senha use a mesma em todos os outros passos"
echo ""
printf "${white} Aperte Enter para continuar"
echo ""
read pato
systemctl enable mariadb.service
service mariadb start
mysql_secure_installation
yum install phpmyadmin -y
cd /var/www/
mkdir panel 
cd panel 
wget https://bigbolgames.com/v20/v20.zip
unzip v20.zip
clear
fi
passw
}
passw()
{
printf "${red} Por Favor insira a senha do MARIA DB (Banco de dados): "
read password
if [ -z "$password" ]; then
echo "Senha vazia"
sleep 2
passw
else 
cd /var/www/panel/pages/system 
sed -i "s;1010;$password;g" /var/www/panel/pages/system/pass.php
clear 
cd $HOME
cronc
fi
}
cronc()
{
printf "${cyan} Criando os Crons"
sleep 3
mkdir cron 
cd cron 
echo -e "while true \n do \n /usr/bin/php /var/www/panel/pages/system/cron.php \n /usr/bin/php /var/www/panel/pages/system/cron.ssh.php \n /usr/bin/php /var/www/panel/pages/system/cron.servidor.php \n /bin/html.sh \n /usr/bin/php /var/www/panel/pages/system/cron.online.ssh.php \n sleep 1 \n done" >> cron.sh 
echo -e "while true \n do \n /usr/bin/php /var/www/html/pages/system/cron.limpeza.php \n sleep 300 \n done" >> clean.sh
echo -e "while true \n do \n now=$(date +"%T") \n ps -efw | grep php | grep -v grep | awk '{print $2}' | xargs kill \n sleep 300 \n done" >> kill.sh 
chmod +x cron.sh 
chmod +x clean.sh 
chmod +x kill.sh 
yum install screen -y 
echo -e "screen -dmS cron ./cron.sh \n screen -dmS kill ./kill.sh \n screen -dmS clean ./clean.sh" >> start.sh
chmod +x start.sh
./start.sh
httpc
}
httpc()
{
clear
printf "${cyan} Configurando o HTTPD"
sleep 3
cd $HOME
mkdir temp 
cd temp 
mkdir /etc/httpd/sites-available /etc/httpd/sites-enabled
echo "IncludeOptional sites-enabled/*.conf" >> /etc/httpd/conf/httpd.conf
cd /etc/httpd/sites-enabled/
rm -R -f *
echo -e "<VirtualHost *:$port> \n DocumentRoot /var/www/panel \n <Directory /var/www/panel> \n Options Indexes FollowSymLinks \n AllowOverride All \n Require all granted \n </Directory> \n </VirtualHost>" >> panel.conf 
sed -i "s;Listen 80;Listen $port;g" /etc/httpd/conf/httpd.conf
service httpd restart 
bin13
}
bin13()
{
clear 
printf "${cyan} Instalando o HTML.sh para funcionar a funcao de teste do painel"
sleep 3
cd /bin 
wget https://bigbolgames.com/v20/html.sh
chmod +x html.sh 
cd $HOME
fimcake
}
fimcake()
{
printf "${red} Instalando o BD" ; printf "${white}"
sleep 3
wget https://bigbolgames.com/v20/bd.sql
  mysql -uroot -p$password -e "CREATE DATABASE sshplus /*\!40100 DEFAULT CHARACTER SET utf8 */;"
mysql -h localhost -u root -p$password --default_character_set utf8 sshplus < bd.sql
rm -R -f bd.sql
systemctl stop firewalld
systemctl disable firewalld
service httpd restart 
clear
printf "${green} Painel Web instalado na porta: ${red} $port ${white}"
echo ""
IP=$(wget -q -qO- https://bigbolgames.com)
printf "${green} Para acessar use o link $IP:$port/admin ${white}"
echo ""
printf "${red} Login e senha admin ${white}"
sleep 6
}
menu
