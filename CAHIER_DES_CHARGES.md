# Cahier des charges — Projet « Vidéo Center » (Symfony)

> Synthèse de l'énoncé du projet. Deadline : **30 août 23h59**.

## 1. Structure générale

- Dossier : `C:/cfitech/projet_video_center_prenom`
- Base de données : `video_center_prenom_db`, créée avec Symfony (`doctrine:database:create`)

## 2. Entité Video

Champs obligatoires :

| Champ | Type | Contrainte |
|---|---|---|
| title | string(50) | not null |
| videoLink | string(500) | not null |
| description | text | not null |
| createdAt | datetime | |
| updatedAt | datetime | |
| premiumVideo | boolean | not null |

- La table doit s'appeler **`videos`**.

## 3. Controller VideoController

| Fonction | Route | Nom |
|---|---|---|
| Accueil (liste) | `/` | `app_home` |
| Création | `/video/create` | `app_video_create` |
| Détails | `/video/{id}` | `app_video_show` |
| Édition | `/video/{id}/edit` | `app_video_edit` |
| Suppression | `/video/{id}/delete` | `app_video_delete` |

## 4. Templates Twig

**index.html.twig** — afficher :
- titre limité à 20 caractères
- description limitée à 25 caractères
- vidéo en 300×200
- temps écoulé depuis publication
- nom + prénom de l'auteur

**show.html.twig** — afficher :
- titre complet, vidéo en 640×480, description complète, date de publication
- boutons éditer/supprimer **uniquement si l'utilisateur est le créateur**

**create / edit** — formulaire : titre, description, lien vidéo (YouTube embed), case premiumVideo.

## 5. Formulaire VideoType

- Labels en français : `title` → Titre, `videoLink` → Lien vidéo, `description` → Description
- Validations : titre ≥ 3 caractères, description ≥ 20 caractères
- Mots interdits : *shit*, *callypige*

## 6. Entité User

- email (identifiant), password (hashé)
- firstname string(50), lastname string(50)
- createdAt, updatedAt
- isVerified (boolean)
- image de profil (VichUploader)
- Relation : un utilisateur → plusieurs vidéos ; une vidéo → un seul utilisateur

## 7. Authentification & sécurité

- Non connecté → uniquement les vidéos **non premium**
- Connecté non vérifié → vidéos non premium + accès à son profil
- Connecté vérifié → accès complet + création/édition de vidéos
- Register/Login inaccessibles si déjà connecté
- Vidéos premium inaccessibles **via URL** si non vérifié
- Emailing (Mailtrap) : vérification d'email (lien actif **5 h**), mot de passe oublié

## 8. Recherche + pagination

- Recherche visible uniquement pour les connectés, sur titre + description
- Recherche : **6 vidéos par page**, afficher « X vidéos trouvées »
- Accueil : **9 vidéos par page**

## 9. Page profil

- Prénom, nom, email, date de création, image de profil
- Liste des vidéos créées par l'utilisateur (en grille)

## 10. VichUploader

- Photo de profil obligatoire, photo par défaut à l'inscription
- Modification possible dans le profil

## 11. Multilingue

- Minimum 2 langues, français obligatoire
- Tous les messages, formulaires, mails, labels traduits

## 12. Déploiement

- Déploiement **obligatoire** sur AlwaysData

## 13. Contraintes finales

- Minimum **4 utilisateurs** (dont 1 non vérifié)
- Minimum **20 vidéos** (dont 8 non premium)
- Messages flash : création/modification/enregistrement (vert), confirmation mail + bienvenue (bleu), mauvais login (rouge)
- Confirmation JavaScript avant suppression
- Trait Timestampable pour createdAt/updatedAt
- Responsive obligatoire
- GitHub avec commits réguliers, base de données incluse dans le repo
- **Deadline : 30 août 23h59**
