## 🧐 Comment stocker des informations ?

Pour gérer le panier utilisateur, on va avoir besoin de stocker des informations côté navigateur (côté client).  
Pour stocker des informations côté client, plusieurs solutions :

- LocalStorage
- SessionStorage
- Cookies
- IndexedDB

_LocalStorage_ et _SessionStorage_ sont assez similaire, seule la portée change, c'est-à-dire que les données dans la _sessionStorage_ seront différentes par onglet, ce n'est pas le cas du _localStorage_.  
Les _cookies_ sont des données à destination du serveur, c'est-à-dire que les _cookies_ sont envoyés dans chaque requête, dans notre cas, nous n'avons pas besoin de communiquer les articles du panier d'un utilisateur à chaque requête.
_IndexedDB_ est une base de données indexée, côté client, elle ne correspond pas à notre besoin, n'hésite pas à te renseigner si tu souhaites plus d'informations.

Comme tu l'as deviné, nous allons partir sur... Le **localStorage** 🎉

## 💾 LocalStorage

Comme l'indique la [documentation MDN du localStorage](https://developer.mozilla.org/fr/docs/Web/API/Window/localStorage), nous récupérons l'objet localStorage juste avec un

```js
localStorage;
```

Pour gérer notre localStorage, nous avons accès à des méthodes : 

```js
localStorage.setItem('monSuperItem', 'azerty'); // AJoute la donnée azerty dans monSuperItem
const monSuperItem = localStorage.getItem('monSuperItem'); // Récupère la valeur de "monSuperItem" (azerty dans notre cas)
localStorage.removeItem('monSuperItem'); // Supprime l'entrée monSuperItem
localStorage.clear(); // Efface tout !
```

> Tu connais maintenant toutes les méthodes nécessaires pour gérer ton panier !

## 🧺 Gérer un "panier"

Qu'est-ce qu'un panier ? Au final, c'est "juste" une liste d'article que l'on a envie d'acheter.  
On a donc besoin de stocker un tableau d'articles dans notre localStorage, seul problème, la clé et la valeur doivent être des chaines de caractères (strings).  
Pour pallier ça, on va stocker notre tableau en JSON, on doit donc le convertir en JSON lors du _setItem_, et le convertir en tableau après le _getItem_.

```js
JSON.stringify(['valeur1', 'valeur2']); // "[\"valeur1\",\"valeur2\"]"
JSON.parse("[\"valeur1\",\"valeur2\"]"); // ['valeur1', 'valeur2']
```

Vu que les articles sont sous forme d'objet, on va stocker un tableau d'objets (un objet = un article).  

### ❓ Comment gérer la quantité ?

Pour gérer la quantité, je te conseille d'ajouter à ton objet article, un attribut "quantity", que tu mets à 1 lorsque tu ajoutes l'article.  
Si l'acheteur ajoute un article qui existe déjà dans le tableau, tu as juste à augmenter cette quantité de 1.  
Si l'acheteur supprime un article qui existe déjà dans le tableau, tu as juste à diminuer la quantité de 1, ou de supprimer l'objet si la quantité est déjà égale à 1.

## ✅ Conclusion

Tu as maintenant toutes les cartes en main, évidemment, le but de cette trilogie d'article n'était pas de faire le projet à ta place, mais plutôt de répondre aux questions et problèmes courants.

Je te conseille d'aller le plus possible lire la documentation, dès que tu découvres une nouvelle méthode, c'est un bon réflexe à avoir.  
Tu peux aussi abuser du console.log() pour bien vérifier ce que tu fais et avancer doucement, mais sûrement 💪

Merci de m'avoir lu 😘

## 📚 Ressources utiles

[Stockage côté client](https://developer.mozilla.org/fr/docs/Learn/JavaScript/Client-side_web_APIs/Client-side_storage)  
[LocalStorage](https://developer.mozilla.org/fr/docs/Web/API/Window/localStorage)  
[JSON stringify](https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Global_Objects/JSON/stringify)  
[JSON parse](https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Global_Objects/JSON/parse)