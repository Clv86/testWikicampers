# testWikicampers - Site de gestion de tarifs et disponibilités de véhicules de location

Ce projet répond au test envoyé aux candidats au poste d'alternant développeur web à Wikicampers.
Le site conçu sert à gérer les disponibilités de locations de véhicules, et à rechercher les véhicules disponibles à une date ciblée et obtenir leur prix.

J'ai utilisé uniquement le framework Symfony dans le cadre de ce test que j'ai ainsi pu découvrir. Le style n'étant pas le sujet du test et par souci de gain de temps, j'ai uniquement utilisé les templates twig ainsi qu'un thème bootstrap.

La page d'accueil propose un accès par des Call-To-Action aux différentes fonctions implémentées. Même si le test ne le demandait pas, j'ai rajouté une page liste des véhicules afin d'avoir facilement de la visibilité sur les objets créés lors du développement. Les pages principales sont aussi accessibles dans la barre de navigation.

Pour faciliter les tests, j'ai ajouté un fixture générant automatiqument 50 véhicules (voir la partie configuration).

L'application est prévue pour être testée en local.

## Améliorations à prévoir

Par manque de temps, je n'ai pas implémenté les deux points bonus, ni certains détails qui rendraient le modèle actuel plus optimisé :
- Dans l'entité Availability, j'ai donné à status une valeur string plutôt que boolean, facilitant l'ajout plus tard au site d'autres options que "Disponible" ou "Non Disponible". Cependant, dans l'envoi du formulaire pour ajouter une disponibilité, j'ai mis un input 'Disponible' qui peut porter à confusion car l'ajout d'une disponibilité sous-entend déjà que l'objet est disponible.
- Dans ce même formulaire pour ajouter une disponibilité, on choisit le véhicule en fonction de son id. Il serait plus judicieux d'avoir une input plus clair où on choisirait le véhicule en fonction de "id - marque - modèle', en récupérant le véhicule à partir de son id de liaison.
- Au fixture générant des véhicules pourrait s'ajouter un fixture générant des disponibilités pour faciliter les tests.
  
# Configuration

## Installation

Pour lancer ce projet, il est nécessaire d'installer : 
- PHP 8.2 ou plus (avec ces extensions, censées être installées par défaut à partir de php 8 : Ctype, iconv, PCRE, Session, SimpleXML, et Tokenizer)
- Composer
- Symfony CLI

Ces installations sont nécessaires pour l'installation d'un projet symfony. Plus de détails sur l'installation de Symfony ici : https://symfony.com/doc/current/setup.html

Après avoir cloné le projet, dans .env à la racine du projet, renseignez votre adresse de serveur de base de données avec le nom de la base de donnée voulue pour le projet (exemple : "DATABASE_URL="mysql://pseudonyme:motdepasse@127.0.0.1:3306/test_wikicampers?serverVersion=10.11.2-MariaDB&charset=utf8mb4"). 
Plus d'informations sur cette configuration ici : https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url

Installez les dépendances avec la commande : 

'composer install'

Créez la base de données correspondant au projet : 

'php bin/console doctrine:database:create'

Créez les tableaux du projet dans la base de données :

'php bin/console doctrine:migrations:migrate'

Démarrez le serveur avec : 

'symfony server:start'

Le projet est lancé !

## Fixtures

Pour générer les fixtures de véhicules, entrez la commande : 

'php bin/console doctrine:fixtures:load'
