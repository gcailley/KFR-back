cd .. 
echo "START"  > install.log &
pwd >> install.log &
php bin/console cache:clear --env=prod --no-debug  >> install.log &
php bin/console assets:install web  >> install.log &