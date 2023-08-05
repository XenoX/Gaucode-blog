## 🧐 Heroku ?! Kézako ?

**Heroku** est une entreprise qui permet de déployer des applications sur le _"cloud"_, de manière simple, rapide et adaptable.

**Heroku** permet d'avoir accès à notre application sur le web, sans configuration, leur plan "_free_" est largement suffisant pour exposer une API ou mettre en ligne un site à très petit trafic, un blog, portfolio ou tes projets d'étude.

## 🚀 Déploiement

Pour ce tuto, je vais prendre l'API NodeJS du projet 5 du parcours "_Développeur Web_" d'_OpenClassrooms_, voici le repository : [https://github.com/OpenClassrooms-Student-Center/JWDP5](https://github.com/OpenClassrooms-Student-Center/JWDP5).

Avant de passer à la suite, tu as besoin d'un compte [GitHub](https://github.com/), car pour plus de simplicité, nous allons passer par GitHub pour mettre notre application sur Heroku.  
Un compte [Heroku](https://heroku.com) est aussi nécessaire 🙂.

Nous avons besoin d'avoir les droits sur le repository que l'on souhaite mettre sur _Heroku_ deux cas de figure : 

- Le repository t'appartient, dans ce cas tu n'as rien à faire
- Le repository ne t'appartient pas, tu vas donc devoir le _forker_ pour l'avoir sur ton profil (bouton _fork_ en haut à droite du repository)

Maintenant on va pouvoir aller sur ton [dashboard Heroku](https://dashboard.heroku.com/apps), tu vas pouvoir créer une application (bouton "_new_" en haut à droite > "_Create new app_").

En _App name_ tu choisis comment tu veux nommer ton application, moi je vais l'appeler xenox-orinoco-api  
En _région_ je mets Europe.

Normalement tu atterris dans l'onglet "_Deploy_", on va rester dessus et se connecter à notre Github, une fois fait, tu peux chercher ton repository et le connecter à ton application Heroku.  

Tu devais avoir quelque chose de similaire : 

![Screenshot Heroku](resources/heroku_1.jpg)

Si tu descends un peu, dans "_Manual deploy_", tu vas pouvoir sélectionner la branche "master" et la déployer, une fois le déploiement effectué, tu vas pouvoir cliquer sur "_Open app_" en haut à droite.  
Normalement tu as un message d'erreur, mais c'est normal, dans notre cas, il faut qu'on ajoute **/api/cameras** à la fin de l'URL pour récupérer nos caméras.

🎉 C'est tout !

Félicitations, ton application est sur Heroku et accessible de partout, magique non ?!

## 🪄 Pas si magique que ça

En fait, quand tu déploies ton application sur Heroku, il va remarquer qu'il y a un fichier _packages.json_ à la racine du projet, donc il va savoir qu'il faut installer Node et NPM et il va installer les dépendances tout seul, comme un grand.  
Il va aussi lancer tout seul un **"npm start"**. 

## ➡️ Aller plus loin

Si tu souhaites mettre des variables d'environnement, il faut aller dans l'onglet _settings_ et dans la rubrique _Config Vars_.

Vu que tu es en plan gratuit, si ton application n'est pas utilisée pendant un certain temps, elle va se mettre en mode sommeil, pas de panique, ta prochaine requête à ton application va la réveiller, 
elle va se reconstruire, c'est pour cela que cette première requête risque de prendre entre cinq et dix secondes.  