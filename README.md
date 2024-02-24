# SnowTricks

SnowTricks est une plateforme communautaire dédiée aux passionnés de snowboard. Ce projet permet aux utilisateurs de partager et d'apprendre des figures (tricks) de snowboard. Développé avec Symfony 6.4, le site offre des fonctionnalités comme la gestion des figures, des commentaires, et un système d'authentification.

## Prérequis

- PHP 8.0 ou supérieur
- Composer
- Symfony CLI
- Serveur MySQL

## Installation

1. **Cloner le projet**

    git clone https://github.com/blvckcoder/P6-Snowtricks
    cd dossier


2. **Installer les dépendances**

    composer install

3. **Configurer l'environnement**

    Dupliquez le fichier `.env` en `.env.local` et modifiez les paramètres de connexion à la base de données (`DATABASE_URL`).

4. **Créer la base de données**

    php bin/console doctrine:database:create

5. **Appliquer les migrations**
    
    php bin/console doctrine:migrations:migrate

6. **Charger les données initiales (fixtures)**

    php bin/console doctrine:fixtures:load


## Utilisation

    Lancez le serveur de développement de Symfony : symfony server:start
    Ouvrez votre navigateur et accédez à `http://localhost:8000` pour voir l'application en action.

## Fonctionnalités

   - **Authentification** : Inscription, connexion, récupération de mot de passe et déconnexion des utilisateurs.
   - **Gestion des figures** : Création, modification, et suppression des figures de snowboard.
   - **Commentaires** : Les utilisateurs peuvent commenter chaque figure.
   - **Responsive design** : Le site est accessible sur tous les appareils.

## Licence

    Ce projet est sous licence MIT. 

## Contact

    Blvckcoder - threads [@blvck.coder](https://www.threads.net/@blvck.coder) - instagram [@blvck.coder](https://www.instagram.com/blvck.coder/) - blvckcoder.com

    Lien du projet : [https://github.com/blvckcoder/P6-Snowtricks](https://github.com/blvckcoder/P6-Snowtricks)
