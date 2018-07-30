Quelques détails sur le projet

Lorsqu'on exécute un fichier, voici dans l'ordre les actions qui sont réalisées

On parse le fichier XML pour récupérer les notions d'albums, titres, et droits.
Des classes représentant ces entités ont été créées

Pour chaque album retrouvé dans le fichier
    créer /  mettre à jour l'album ( à l'aide de son identifiant unique)

Pour chaque titre
    créer / vérifier l'existence d'un titre ( à l'aide de son identifiant unique)
    vérifier que l'album existe puis le lier au titre

Pour chaque droit
    Déterminer si c'est un droit associé à un album ou à un titre
    Créer le droit


Pour faire fonctionner le projet il est nécessaire d'avoir une base mysql à disposition
Et de jouer le fichier sql/rollout.sql

Mes tests ont été réalisés avec une distribution de base Mysql  5.6.41
https://dev.mysql.com/downloads/mysql/5.6.html

La version de PHP utilisée est PHP 5.6.30

Une fois la base et les tables créées , il faut jouer le script
    A la racine du projet faire php console.php

(inutile de passer d'argument dans notre cas car le fichier est passé par défaut en dur dans le code )

Si nous devions traiter d'autres types de fichiers que ceux fournis en annexe pour ce projet, il faudrait créer une nouvelle classe
implémentant l'interface Parser.

Pour répondre à la dernière question du sujet, la problèmatique principale étant de pouvoir fournir rapidement en lecture
l'accés aux donnés enregistrées, il faudrait avoir deux bases de données

- L'une dédiée à l'insertion (normalisée) (celle définie dans ce projet) qui permettrait notamment de vérifier l'intégrité des données,
de pouvoir contrôler la publication des albums etc ...

- L'autre dédiée à la lecture (dénormalisée), alimentée par les données de la première sur validation, qui aurait les indexes et le partitionnement approprié
(par genre, artiste, date etc...)


Quelques pistes pour améliorer ce projet:

- Paralléliser les imports à l'aide d'un broker ( exemple kafka ou RabbitMQ).
Dans notre cas il est envisageable  de paralléliser plusieurs fichiers en même temps (dans la limite des ressources CPU
acceptables disponibles, voir système de pools)

-De la même manière que la factory pour le parseur évoquée plus tôt, on pourrait créer une interface pour le 'Repository'
qui aurait pour but de permettre d'insérer les données vers un autre SGBD (postgres par exemple ou pour faire du noSQL)

-Ajouter des tests unitaires

-'Dockeriser' le projet pour gagner du temps sur les déploiements/installations et harmoniser l'environnement des développeurs.
