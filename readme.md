# projet de planning pour évènement!

Tous les ans, les professeurs du département informatique ont besoin de communiquer aux élèves \
des dates / périodes importées. Jusqu’à aujourd’hui elles étaient transmises de vive voix ou par mail. \
L’agenda universitaire étant restreint juste à l’affichage des cours. Le besoin d’une solution web se présente.

## Installation

Installation des dépendances PHP avec composer :

```shell
composer install
```

Création d'un fichier `.env.local` à partir du fichier `.env` :

```shell
cp .env .env.local
```

Puis modifiez les variables d'environnement du fichier `.env.local` selon votre environnement local.

Mise en place de la base de données :

```shell
composer db
```

## Développement

Lancement du serveur de développement :

```shell
symfony serve
```
