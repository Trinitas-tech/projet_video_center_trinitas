# Carnet de commandes — Vidéo Center

Toutes les commandes utilisées pour déboguer, compléter et déployer le projet, dans l'ordre, avec leur utilité.
Site en ligne : <https://trinitasnt.alwaysdata.net>

**Où lancer chaque commande :**

| Badge | Signification |
|---|---|
| 💻 **PC** | Terminal Windows, dans `C:\Cfitech\projet_video_center_trinitas` |
| 🖥️ **Serveur** | Terminal SSH AlwaysData (l'invite affiche `trinitasnt@ssh1`) |
| 🌐 **Admin web** | Interface admin.alwaysdata.com ou phpMyAdmin |

---

## 1. Diagnostic du site

> Objectif : trouver tous les bugs avant de corriger quoi que ce soit.

💻 **État général de l'application**
```bash
php bin/console about
```
Affiche la version de Symfony, de PHP, l'environnement (dev/prod).

💻 **Lister toutes les routes**
```bash
php bin/console debug:router
```
A révélé le **conflit de nom de route** : deux contrôleurs déclaraient `app_home`.

💻 **Valider les templates et les services**
```bash
php bin/console lint:twig templates
php bin/console lint:container
php bin/console lint:yaml translations config
```
Détecte les erreurs de syntaxe Twig, les services mal injectés et les YAML invalides.

💻 **Comparer les entités et la base**
```bash
php bin/console doctrine:schema:validate
php bin/console doctrine:schema:update --dump-sql
```
La première dit si la base est synchronisée avec les entités ; la seconde montre le SQL manquant. C'est ainsi que la **clé étrangère absente** sur `videos.user_id` a été découverte.

💻 **Exécuter du SQL directement**
```bash
php bin/console dbal:run-sql "SELECT TABLE_NAME, ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE()"
```
A révélé la **cause racine** : toutes les tables étaient en MyISAM, moteur qui ignore silencieusement les clés étrangères.

## 2. Réparation de la base locale

> Objectif : corriger les données orphelines et convertir les tables en InnoDB.

💻 **Rattacher les vidéos orphelines et recréer la clé étrangère**
```bash
php bin/console dbal:run-sql "UPDATE video SET user_id = 1 WHERE user_id = 0"
php bin/console dbal:run-sql "ALTER TABLE users ENGINE=InnoDB"
php bin/console dbal:run-sql "ALTER TABLE video ENGINE=InnoDB"
php bin/console dbal:run-sql "ALTER TABLE video ADD CONSTRAINT FK_... FOREIGN KEY (user_id) REFERENCES users (id)"
```
Les vidéos avaient `user_id = 0` : la migration avait échoué à mi-chemin. La config `default_table_options: engine: InnoDB` dans `doctrine.yaml` évite que ça se reproduise.

## 3. Installation des bundles

> Objectif : ajouter les briques exigées par le cahier des charges.

💻 **Bundles de production**
```bash
composer require vich/uploader-bundle knplabs/knp-paginator-bundle symfonycasts/verify-email-bundle symfonycasts/reset-password-bundle
```
Photo de profil (VichUploader), pagination (KnpPaginator), vérification d'email (VerifyEmail), mot de passe oublié (ResetPassword).

💻 **Bundle de développement**
```bash
composer require --dev doctrine/doctrine-fixtures-bundle
```
Permet de générer les données de démo : 4 utilisateurs (dont 1 non vérifié) et 20 vidéos (dont 8 non premium).

## 4. Migrations et fixtures

> Objectif : faire évoluer le schéma (premium, vérifié, photo) et remplir la base.

💻 **Générer puis appliquer les migrations**
```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate --no-interaction
```
`diff` compare les entités à la base et écrit le SQL de mise à jour ; `migrate` l'exécute. Ont servi pour : renommage `video → videos`, colonnes `premium_video`, `is_verified`, `image_name`, table `reset_password_request`.

💻 **Charger les données de démo**
```bash
php bin/console doctrine:fixtures:load --no-interaction
```
⚠️ Vide la base puis insère les comptes et vidéos de `src/DataFixtures/AppFixtures.php`.

## 5. Emails Mailtrap

> Objectif : envoyer réellement les emails de vérification et de réinitialisation.

💻 **Tester la connexion SMTP**
```bash
php bin/console mailer:test destinataire@example.com
```
Envoie un email de test via le `MAILER_DSN` du `.env.local`.

> ⚠️ Le plan gratuit Mailtrap limite à ≈1 email/seconde (« 550 Too many emails per second » = attendre quelques secondes). Dans `messenger.yaml`, les emails sont routés en `sync` : sans cela ils restent en file d'attente (pas de worker sur AlwaysData).

## 6. Export de la base

> Objectif : inclure la base dans le repo (exigence du projet) et l'importer sur le serveur.

💻 **Générer le dump SQL**
```bash
mysqldump -u root video_center_trinitas_db > video_center_trinitas_db.sql
```
⚠️ Il faut ensuite remplacer la collation `utf8mb4_0900_ai_ci` (MySQL 8) par `utf8mb4_general_ci`, car MariaDB (AlwaysData) ne la connaît pas.

## 7. Tests en local

> Objectif : vérifier chaque page et chaque règle d'accès avant de déployer.

💻 **Lancer un serveur de développement**
```bash
php -S 127.0.0.1:8765 -t public
```

💻 **Tester une page comme un navigateur**
```bash
curl.exe -s -o /dev/null -w "%{http_code}" https://trinitasnt.alwaysdata.net
```
Affiche le code HTTP : 200 = OK, 302 = redirection, 404 = introuvable, 500 = erreur serveur.

💻 **Vider le cache**
```bash
php bin/console cache:clear
```
Indispensable après toute modification de configuration.

## 8. Git et GitHub

> Objectif : versionner le code et le publier sur GitHub (exigence du projet).

💻 **Enregistrer les modifications**
```bash
git add -A
git commit -m "Description de la modification"
```
Le prof attend des commits **réguliers** : un par fonctionnalité ou correction.

💻 **Créer le repo GitHub et pousser**
```bash
gh repo create projet_video_center_trinitas --public --source . --push
git push origin master
```

## 9. Déploiement AlwaysData

> Objectif : mettre le site en ligne sur trinitasnt.alwaysdata.net.

🌐 **Préparer l'hébergement (une seule fois)**
1. **Bases de données → MySQL** : créer la base `trinitasnt_video_center_db` + un utilisateur avec tous les droits.
2. **phpMyAdmin** : sélectionner la base dans la colonne de gauche *d'abord*, puis Importer → `video_center_trinitas_db.sql`.
3. **Web → Sites** : type PHP 8.3, répertoire racine `/www/projet_video_center_trinitas/public` (toujours pointer sur `public`).
4. **Accès distant → SSH** : activer l'authentification par mot de passe.

💻 **Se connecter au serveur**
```bash
ssh trinitasnt@ssh-trinitasnt.alwaysdata.net
```
Le mot de passe ne s'affiche pas pendant la frappe — c'est normal. L'invite devient `trinitasnt@ssh1:...$`.

🖥️ **Récupérer le code**
```bash
cd /home/trinitasnt/www
git clone https://github.com/Trinitas-tech/projet_video_center_trinitas.git
```
Chemins absolus obligatoires : le `~` de l'utilisateur SSH ne pointe pas au bon endroit sur ce compte.

🖥️ **Configurer la production**
```bash
cd /home/trinitasnt/www/projet_video_center_trinitas
cat > .env.local << 'EOF'
APP_ENV=prod
APP_DEBUG=0
APP_SECRET=une_longue_chaine_aleatoire
DATABASE_URL="mysql://trinitasnt:MDP@mysql-trinitasnt.alwaysdata.net:3306/trinitasnt_video_center_db?serverVersion=10.11.2-MariaDB"
MAILER_DSN="smtp://xxx:yyy@sandbox.smtp.mailtrap.io:2525"
EOF
```
⚠️ Un `@` dans le mot de passe s'écrit `%40` dans l'URL — et les placeholders doivent **vraiment** être remplacés.

🖥️ **Installer et finaliser**
```bash
composer install --no-dev --optimize-autoloader
php bin/console cache:clear
```
⚠️ `--no-dev` ne doit **jamais** être lancé sur le PC : il casse l'environnement de développement.

🖥️ **Importer la base en ligne de commande (alternative à phpMyAdmin)**
```bash
mysql -h mysql-trinitasnt.alwaysdata.net -u trinitasnt -p trinitasnt_video_center_db < video_center_trinitas_db.sql
```
À lancer **depuis le serveur** : le client MySQL récent de Windows est incompatible avec MariaDB d'AlwaysData (erreur « mysql_native_password »).

> ⚠️ Il a aussi fallu ajouter `public/.htaccess` (réécriture Apache) : sans lui, seule la page d'accueil fonctionnait, toutes les autres URLs renvoyaient un 404.

## 10. Astuce : commander le serveur depuis le PC

💻 **Exécuter une commande à distance**
```bash
ssh trinitasnt@ssh-trinitasnt.alwaysdata.net "cd /home/trinitasnt/www/projet_video_center_trinitas && php bin/console cache:clear"
```
Tout ce qui est entre guillemets s'exécute **sur le serveur**. Plus de confusion entre terminaux.

---

## Le rituel de mise à jour

À refaire à chaque modification du code :

```bash
git add -A
git commit -m "Description de la modification"
git push
ssh trinitasnt@ssh-trinitasnt.alwaysdata.net "cd /home/trinitasnt/www/projet_video_center_trinitas && git pull && php bin/console cache:clear"
```

Sauvegarde → publication GitHub → mise à jour du site en ligne.
Si le site affiche encore l'ancien code : bouton **Redémarrer** du site dans l'admin AlwaysData (vide l'OPcache PHP).

---

*Projet Vidéo Center — Symfony 6.4 · déployé le 20 août 2026 · comptes de démo : `trinitas@cfitech.be` / `password123`*
