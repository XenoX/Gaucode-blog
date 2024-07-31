## Domptez le versionning comme un(e) pro 💪

On est d'accord, jongler avec les versions de son code, c'est un peu la croix et la bannière de tout développeur 😫. Entre les fichiers qui s'appellent "final_v2_vraiment_final.txt", les envois par mail et les "Oups, j'ai cassé le code", on a connu plus fun...  Heureusement, il y a **Git**, le super-héros du versionning !  🦸‍♂️🦸‍♀️

### Pourquoi Git ? Parce que la vie est trop courte pour les prises de tête !

Imaginez :

* 🪄 **Remonter le temps** pour retrouver une version antérieure de votre code, sans douleur.
* 👯‍♀️ **Collaborer** facilement avec d'autres développeurs, sans fusionner des fichiers à la main pendant des heures.
* 🚀 **Expérimenter** de nouvelles fonctionnalités sans risquer de tout casser dans votre code principal.

Plutôt cool, non ? 😎

### Prêt(e) à dompter la bête ? C'est parti pour l'installation !

Pas de panique, c'est plus simple qu'il n'y paraît :

Sur **Linux** et **Mac OS**, il y a de grandes chances que Git soit déjà installé, pour vérifier cela, il suffit de taper `git --version` dans le terminal, si il vous répond avec un numéro de version, c'est ok ! 

Sinon :

1. **Téléchargez Git**   
   1.1 Avec votre gestionnaire de paquet préféré (winget, homebrew, pacman, apt, etc.)  
   1.2 sur le site officiel : [https://git-scm.com/downloads](https://git-scm.com/downloads) (choisissez la version correspondant à votre système d'exploitation).
2. **Suivez les instructions d'installation** (généralement, il suffit de cliquer sur "Suivant" 😄).

### Les bases : les commandes magiques pour briller en équipe

Avant de devenir un(e) ninja du versionning, familiarisez-vous avec ces quelques commandes :

* **`git init`** :  Crée un nouveau dépôt Git dans votre dossier. C'est comme planter le décor pour la magie du versionning ✨.
* **`git add .`** :  Ajoute tous les changements de votre code au "staging area", une sorte de sas avant le grand saut.
* **`git commit -m "Message clair et concis (souvent en anglais)"`** :  Prend un instantané de votre code avec un message descriptif. C'est comme un point de sauvegarde dans votre jeu vidéo préféré 💾.
* **`git status`** :  Affiche l'état actuel de votre dépôt, comme un GPS pour votre code 🗺️.
* **`git log`** :  Affiche l'historique des commits, avec leurs messages et auteurs.  C'est comme un journal de bord de votre projet 📖.

**Exemple concret :**

1. Vous venez de terminer une fonctionnalité révolutionnaire dans votre code 🧑‍💻.
2. Vous utilisez  `git add .`  pour ajouter vos changements.
3. Vous immortalisez le tout avec  `git commit -m "Implémentation de la fonctionnalité [Nom de la fonctionnalité]"`.

Et voilà, votre code est sauvegardé et prêt à être partagé (Nous verrons ça prochainement) ! 🎉

### Les branches : explorez de nouvelles dimensions sans (trop de) risques

Imaginez les branches comme des lignes temporelles parallèles dans votre projet. Elles vous permettent de travailler sur différentes fonctionnalités ou corrections de bugs sans impacter la branche principale (souvent appelée `main` ou `master`).

* **`git branch`** :  Affiche la liste des branches.
* **`git branch [nom_de_la_branche]`** : Crée une nouvelle branche.
* **`git checkout [nom_de_la_branche]`** :  Change de branche (comme un voyage dans le temps 🕰️).
* **`git checkout -b [nom_de_la_branche]`** :  Crée une nouvelle branche et change de branche (un raccourci pour éviter de taper les deux commandes précédentes).
* **`git merge [nom_de_la_branche]`** :  Fusionne les modifications d'une branche dans la branche courante (attention aux conflits, on en reparle plus tard 💥).

**Exemple concret :**

1. Vous voulez développer une nouvelle fonctionnalité "Super Feature" sans toucher à votre code principal.
2. Vous créez une nouvelle branche avec  `git branch super-feature`.
3. Vous basculez sur cette nouvelle branche avec  `git checkout super-feature`.
4. Vous développez votre fonctionnalité tranquillement, en faisant des commits réguliers.
5. Une fois la fonctionnalité terminée, vous revenez sur la branche principale avec `git checkout main`.
6. Vous fusionnez les changements de votre branche "Super Feature" avec `git merge super-feature`.

Et voilà, votre fonctionnalité est intégrée à la branche principale, sans avoir pris de risques inutiles ! 😎

###  Git Pro 💪 : Bonnes pratiques pour un historique clair et des collaborations fluides

Dans le monde professionnel (ou non), un historique Git propre et lisible est crucial. Voici quelques bonnes pratiques à adopter :

* **Nommage des branches :**  Optez pour des noms descriptifs et concis, en utilisant des tirets pour séparer les mots et avant le type en amont (ex: `fix/email-typo`, `feature/add-form`).
* **Nommage des commits :**  Commencez par un verbe à l'infinitif et décrivez clairement l'action effectuée (ex:  `Fix security issue`, `Add login button`).
* **Commits atomiques :**  Chaque commit doit représenter un changement logique et minimal. Si vous modifiez plusieurs fonctionnalités à la fois, faites plusieurs commits distincts.
* **Squash avant merge :** Avant de fusionner une branche, nettoyez son historique en fusionnant les commits liés à une même fonctionnalité. Cela rendra l'historique plus lisible et facilitera la résolution de conflits (cf bonus).
* **Branches pour tout :**  Créez une branche pour chaque nouvelle fonctionnalité, correction de bug, ou même pour des tâches d'exploration. Cela vous permettra de travailler de manière isolée et de garder un historique clair.

En suivant ces conseils, vous ferez de votre dépôt Git un havre de paix pour vous et votre équipe 🙏.

### Bonus : les commandes de pro pour flex encore plus ✨

* **`git commit --amend`** :  Modifie le dernier commit (utile si vous avez oublié d'ajouter un fichier ou corrigé une petite coquille dans votre message).
* **`git rebase -i [commit]`**:  Permet de modifier l'historique des commits, par exemple pour fusionner plusieurs commits en un seul (squash).

**Attention:**  L'utilisation de `git rebase` peut s'avérer complexe et il est important de bien comprendre son fonctionnement avant de l'utiliser. N'hésitez pas à consulter la documentation officielle pour plus d'informations.

### En conclusion

Git est un outil puissant qui peut vous simplifier la vie de développeur. N'hésitez pas à expérimenter et à explorer toutes ses fonctionnalités pour en tirer le meilleur parti ! 🚀 

Dans la prochaine partie, vous verrons plus en détails certaines commandes et aussi les _repositories_ distants tel que GitHub et GitLab.