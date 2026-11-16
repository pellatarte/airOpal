# AirOpale — dépôt de départ

La météo et la qualité de l'air sur la Côte d'Opale. Projet fil rouge de la R3.01
(BUT2 apprentis), à partir de la séance 7.

## Démarrer

Depuis ce dossier (celui qui contient `docker-compose.yml`) :

```bash
docker compose up -d --build
```

Puis ouvrez <http://localhost:8080>. La toute première page prend **deux à trois minutes** :
Symfony construit son cache. Ne rechargez pas, attendez. Les suivantes sont rapides.

| Adresse | Quoi |
|---|---|
| <http://localhost:8080> | AirOpale |
| <http://localhost:8081> | Adminer — serveur `db`, utilisateur `airopale`, mot de passe `airopale`, base `airopale` |

> **Le port 8080 est déjà pris ?** C'est sans doute SkillSwap qui tourne encore. Dans le dossier de
> SkillSwap : `docker compose down`, puis relancez AirOpale.

## Ce qui est déjà là

- Symfony 7.4 et tous les paquets du module, **`vendor/` compris** : aucun `composer install` à faire.
- La base MySQL, **vide** : ce sont vos migrations qui créeront les tables.
- `src/Controller/AccueilController.php` et `templates/` : la page d'accueil et le gabarit commun.
- `src/Meteo/CodeMeteo.php` : la traduction des codes météo en libellés.
- `src/Controller/FausseApiController.php` : une fausse API Open-Meteo, pour travailler sans réseau.

## Les commandes

Toutes les commandes PHP se lancent **dans le conteneur** :

```bash
docker compose exec web php bin/console           # la liste des commandes de Symfony
docker compose exec web php bin/console debug:router
docker compose logs -f web                         # les erreurs d'Apache et de PHP
docker compose down -v                             # tout arrêter ET vider la base
```

## Sans réseau

Créez un fichier `.env.local` à côté de `.env`, avec ces deux lignes :

```
METEO_URL=http://localhost/fausse-api
AIR_URL=http://localhost/fausse-api
```

Votre code n'a pas à changer : seule l'adresse de l'API change.
