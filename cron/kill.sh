while true 
do 
now=$(date +"%T")
ps -efw | grep php | grep -v grep | awk '{print $2}' | xargs kill
echo "OK $now" >> log.txt
echo "300 segundos!" 
sleep 300
done
