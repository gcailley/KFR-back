php bin/console  doctrine:schema:update --force
php bin/console  doctrine:schema:update --dump-sql

clean le cache de symfony

    php bin/console cache:clear

Generer le SQL de mise à jour de la base

    php bin/console doctrine:schema:update --dump-sql
    php bin/console doctrine:schema:update --force
    
#generation database#
/C/xampp7.3.12/mysql/bin
$ cat kfr/mysql256.kungfurezu_main.2020-01-15-18h19.gz | gunzip | ./mysql.exe -u root -p routanglangquan