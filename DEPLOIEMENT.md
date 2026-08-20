# Déploiement sur AlwaysData

Guide pas à pas pour mettre **Vidéo Center** en ligne sur [alwaysdata.com](https://www.alwaysdata.com).

> Dans ce guide, remplace `MONCOMPTE` par le nom de ton compte AlwaysData
> (par exemple `trinitas`). Ton site sera accessible sur `https://MONCOMPTE.alwaysdata.net`.

## 1. Créer le compte

1. Va sur <https://www.alwaysdata.com/fr/inscription/> et crée un compte **gratuit** (100 Mo).
2. Le nom de compte choisi devient ton sous-domaine : `MONCOMPTE.alwaysdata.net`.

## 2. Créer la base de données MySQL

1. Dans l'administration AlwaysData : **Bases de données → MySQL → Ajouter une base**.
   - Nom : `MONCOMPTE_video_center_db` (AlwaysData préfixe toujours par le nom du compte).
2. **Bases de données → MySQL → Utilisateurs → Ajouter un utilisateur** :
   - note bien le mot de passe, il servira dans `DATABASE_URL`.
   - donne-lui tous les droits sur la base.
3. Ouvre **phpMyAdmin** (lien dans la même page), sélectionne la base,
   onglet **Importer**, et importe le fichier `video_center_trinitas_db.sql`
   qui est à la racine de ce projet. ✅ La base contient déjà les 4 utilisateurs
   et les 20 vidéos demandés.

## 3. Configurer le site web

Dans **Web → Sites**, modifie le site par défaut (ou crée-en un) :

- **Adresses** : `MONCOMPTE.alwaysdata.net`
- **Type** : PHP
- **Répertoire racine** : `/www/projet_video_center_trinitas/public`
  (⚠️ bien pointer sur `public`, jamais sur la racine du projet)
- **Version de PHP** : 8.3

## 4. Envoyer le code

### Option A — via Git (recommandé)

1. Active le SSH : **Accès distant → SSH → modifier l'utilisateur** → coche « Mot de passe ».
2. Connecte-toi :
   ```bash
   ssh MONCOMPTE@ssh-MONCOMPTE.alwaysdata.net
   cd www
   git clone https://github.com/TON_COMPTE_GITHUB/projet_video_center_trinitas.git
   ```

### Option B — via SFTP (FileZilla)

- Hôte : `ftp-MONCOMPTE.alwaysdata.net` — identifiants du compte.
- Envoie tout le projet dans `/www/projet_video_center_trinitas/`
  **sauf** les dossiers `var/`, `vendor/` et le fichier `.env.local`.

## 5. Configurer l'environnement de production

En SSH, à la racine du projet, crée le fichier `.env.local` :

```bash
cd ~/www/projet_video_center_trinitas
cat > .env.local << 'EOF'
APP_ENV=prod
APP_DEBUG=0
APP_SECRET=CHANGE_MOI_avec_une_longue_chaine_aleatoire
DATABASE_URL="mysql://UTILISATEUR_MYSQL:MOT_DE_PASSE@mysql-MONCOMPTE.alwaysdata.net:3306/MONCOMPTE_video_center_db?serverVersion=10.11.2-MariaDB"
MAILER_DSN="smtp://a78f04058a1199:af96ac10c1a791@sandbox.smtp.mailtrap.io:2525"
EOF
```

> La version exacte de MariaDB est affichée dans l'admin AlwaysData
> (Bases de données → MySQL). Adapte `serverVersion` si besoin.

## 6. Installer les dépendances et finaliser

Toujours en SSH :

```bash
composer install --no-dev --optimize-autoloader
php bin/console cache:clear
```

Si tu n'as pas importé le dump SQL à l'étape 2, exécute les migrations à la place :

```bash
php bin/console doctrine:migrations:migrate --no-interaction
```

## 7. Vérifier

- `https://MONCOMPTE.alwaysdata.net` → l'accueil affiche les vidéos non premium.
- Connexion avec `trinitas@cfitech.be` / `password123` → les 20 vidéos sont visibles.
- Inscription d'un nouveau compte → l'email de vérification arrive dans Mailtrap.
- Upload d'une photo de profil → vérifier que `public/uploads/profiles/` est accessible en écriture
  (normalement oui par défaut sur AlwaysData).

## Dépannage

| Problème | Solution |
|---|---|
| Erreur 500 dès l'accueil | Regarde `var/log/prod.log`, vérifie `DATABASE_URL` |
| Page blanche / CSS absent | Vérifie que la racine du site pointe sur `public` |
| Emails non envoyés | Vérifie `MAILER_DSN` dans `.env.local` sur le serveur |
| « Access denied » MySQL | L'utilisateur MySQL n'a pas les droits sur la base |
