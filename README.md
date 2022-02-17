# Blog Scoutes et Guides de France
![Symfony](https://img.shields.io/badge/symfony-%23000000.svg?style=for-the-badge&logo=symfony&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![PHPStorm](http://img.shields.io/badge/-PHPStorm-181717?style=for-the-badge&logo=phpstorm&logoColor=white)


Blog pour un groupe, une unité d'un groupe SGDF.

## Auteur

* [Baptiste Buvron](https://github.com/BaptisteBuvron)

## Démarrer avec le projet

1 ) Création fichier .env.local
Mettre les informations de sa base de donnée dans le fichier .env.local

2 ) Composer

```bash
composer install
```

3) Ckeditor
```bash
php bin/console ckeditor:install
php bin/console assets:install public
php bin/console assets:install --symlink
```

4) ElFinder
```bash
symfony console elfinder:install
```

5 ) Création de la base de données

```bash
php bin/console doctrine:database:create
```

6 ) Faire les migrations de la base de données

```bash
php bin/console doctrine:migrations:migrate
```


7 ) Lancer le serveur de développement

```bash
php -S localhost:8000 -t public/
```
