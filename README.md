php bin/console  doctrine:schema:update --force
php bin/console  doctrine:schema:update --dump-sql

clean le cache de symfony

    php bin/console cache:clear

Generer le SQL de mise à jour de la base

    php bin/console doctrine:schema:update --dump-sql
    php bin/console doctrine:schema:update --force
    