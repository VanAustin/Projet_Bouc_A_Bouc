# PROJET BOUC A BOUC

## Installation pour consulter le projet en local

- Clonez ce repo dans un répertoire accessible par votre localhost
- Créez vous un utilisateur avec sa base de données et les droits associés sur phpmyadmin ou votre gestionnaire MySQL
- Rendez vous dans ce dossier avec votre ligne de commande
- `composer install`
- Suivez les indications et rentrez les informations concernant votre base de données fraîchement créée
- `php bin/console doctrine:schema:validate`
- Si le mapping est ok `php bin/console doctrine:migrations:migrate`
- `php bin/console doctrine:fixtures:load`
- `php bin/console cache:clear --env=prod`
- `php bin/console cache:clear --env=dev`
- Vous pouvez vous rendre sur votre navigateur à l'adresse de votre dossier (repo) et accéder au dossier web ou au mode dev en rajoutant /app_dev.php à votre URL

NB :
- Si des problèmes d'écriture pendant l'installation à cause du cache de Symfony => `sudo chmod -R 777 var`
- N'hésitez pas à faire une issue pour quoi que ce soit

Users :
- ben / password (admin)
- oclcok / password (user)
- django / password (user)
