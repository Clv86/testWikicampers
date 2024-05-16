# testWikicampers - Site de gestion de tarifs et disponibilités de véhicules de location

Ce projet répond au test que vous avez envoyé dans le cadre de ma candidature au poste d'alternant en développement web à Wikicampers.
Le site conçu sert à gérer les disponibilités de locations de véhicules, et à rechercher les véhicules disponibles à une date ciblé et obtenir leur prix.

J'ai utilisé uniquement le framework Symfony dans le cadre de ce test que j'ai ainsi pu découvrir. Le style n'étant pas le sujet du test et par souci de gain de temps, j'ai uniquement utilisé les templates twigs ainsi qu'un thème bootstrap.

La page d'accueil propose un accès par des Call-to-action aux différentes fonctions implémentées. Même si le test ne le demandait pas, j'ai rajouté une page liste des véhicules afin d'avoir facilement de la visibilité sur les objets créés lors du développement. Les pages principales sont aussi accessibles dans la barre de navigation.

Pour faciliter les tests, j'ai ajouté un fixture générant automatiqument 50 véhicules (voir la partie configuration).

L'application est prévue pour être tester en local.

## Améliorations

Par manque de temps, je n'ai pas implémenté les deux points bonus, ni certains détails qui renderaient le modèle actuel plus optimisé :
- Dans l'entité Availability, j'ai donné à status une valeur string plutôt que boolean, facilitant l'ajout plus tard au site d'autres options que "Disponible" ou "Non Disponible". Cependant, dans l'envoi du formulaire pour ajouter une disponibilité, j'ai mis un input 'Disponible' qui peut porter à confusion car l'ajout d'une disponibilité sous-entend déjà que l'objet est disponible.
- Dans ce même formulaire pour ajouter une disponibilité, on choisit le véhicule en fonction de son id. Il serait plus judicieux d'avoir une input plus claire où on choisirait le véhicule en fonction de "id - marque - modèle', en utilisant un query pour récupérer le véhicule à partir de son id de liaison, comme cela a été fait pour afficher les prix dans le tableau de la liste des véhicules disponibles.
- Au fixture générant des véhicules pourrait s'ajouter un fixture générant des disponibilités pour faciliter les tests.
  
# Configuration

## Installation

Pour lancer symfony, il est nécessaire d'installer : 

## Fixtures
