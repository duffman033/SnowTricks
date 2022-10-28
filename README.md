# SnowTricks
<table>
<tr>
<td>
PHP / Symfony - Développement du site communautaire SnowTricks
</tr>
</table>

## Demo
Voici une démo en direct : [SnowTricks](www.snowtricks.bastienmoreau.com)

## Code Quality
La qualité du code sera validée par Codacy. Vous pouvez accéder au rapport d'inspection en cliquant sur le badge ci-dessous.
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/4120f34dd0f641e1bc481e7f8c3bcda6)](https://www.codacy.com/gh/duffman033/SnowTricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=duffman033/SnowTricks&amp;utm_campaign=Badge_Grade)

## Installation du projet

Cloner le projet sur votre disque dur avec la commande :
```text
https://github.com/duffman033/SnowTricks.git
```

Ensuite, effectuez la commande "composer install" depuis le répertoire du projet cloné, afin d'installer les dépendances back nécessaires :
```text
composer install
```

Puis, "yarn install" pour les dépendances front du projet :
```text
yarn install
```

### Paramétrage et accès à la base de données

Editez le fichier situé à la racine intitulé ".env" afin de remplacer les valeurs de paramétrage de la base de données :

````text
//Exemple : mysql://root:root@localhost:8888/snowtricks
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
````

Effectuez la commande `php bin/console doctrine:database:create` pour créer la base de données :

````text
php bin/console doctrine:database:create
````

Vous pouvez donc recréer la base de données en effectuant la commande suivante :

```text
php bin/console doctrine:migrations:migrate
```

Après avoir crée votre base de données, vous pouvez également injecter un jeu de données en effectuant la commande suivante :

```text
php bin/console doctrine:fixtures:load
```

### Envoi des mails

Si vous souhaitez utiliser un serveur de mail afin d'envoyer des mails, vous pouvez le configurer dans le fichier `.env` à la racine du projet, dans la partie `MAILER_DSN`.
Vouz pouver fous renseigner sur https://symfony.com/doc/current/mailer.html ou auprès de votre gestionnaire de mail.
```text
//Exemple : smtp://votreadresse@mail.fr:password@serveur.smtp
```

### Identifiant de connexion

*   Nom d'utilisateur : admin
*   Mot de passe : adminadmin

### Lancer le projet

*   Pour lancer le serveur de développement, effectuez un `yarn encore dev`.
*   Pour lancer le serveur de symfony, effectuez un `php bin/console server:start`.

### Bravo, le projet est désormais accessible à l'adresse : localhost:8000

## Dev

[![Bastien Moreau](https://avatars1.githubusercontent.com/u/79464283?v=4&s=144)](https://github.com/duffman033)
<br>
[Bastien Moreau ](https://github.com/duffman033)