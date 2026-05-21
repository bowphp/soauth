# Soauth

Authentification via réseaux sociaux pour le Bow Framework.

## À propos

Ce package est un wrapper autour de
[`thephpleague/oauth2-client`](https://github.com/thephpleague/oauth2-client),
exposé via une API en deux appels. Six fournisseurs sont préconfigurés :

- Facebook
- GitHub
- GitLab
- Google
- Instagram
- LinkedIn

## Installation

```bash
composer require bowphp/soauth
```

PHP 8.1+ requis.

## Configuration

Enregistrez le service provider dans la méthode `configurations()` de votre
kernel :

```php
return [
    \Bow\Soauth\SoauthConfiguration::class,
    // ...
];
```

Puis déclarez les identifiants de chaque fournisseur que vous utilisez dans
`.env.json`. Seuls les fournisseurs réellement appelés ont besoin d'être
configurés.

### Facebook

Créez une application Facebook sur <https://developers.facebook.com/fr>.

```bash
FACEBOOK_CLIENT_ID=client_id
FACEBOOK_CLIENT_SECRET=client_secret
FACEBOOK_REDIRECT_URI=redirect_uri
```

### GitLab

```bash
GITLAB_CLIENT_ID=client_id
GITLAB_CLIENT_SECRET=client_secret
GITLAB_REDIRECT_URI=redirect_uri
```

### GitHub

```bash
GITHUB_CLIENT_ID=client_id
GITHUB_CLIENT_SECRET=client_secret
GITHUB_REDIRECT_URI=redirect_uri
```

### Google

```bash
GOOGLE_CLIENT_ID=client_id
GOOGLE_CLIENT_SECRET=client_secret
GOOGLE_REDIRECT_URI=redirect_uri
```

### Instagram

```bash
INSTAGRAM_CLIENT_ID=client_id
INSTAGRAM_CLIENT_SECRET=client_secret
INSTAGRAM_REDIRECT_URI=redirect_uri
```

### LinkedIn

```bash
LINKEDIN_CLIENT_ID=client_id
LINKEDIN_CLIENT_SECRET=client_secret
LINKEDIN_REDIRECT_URI=redirect_uri
```

## Utilisation

Un contrôleur typique a deux actions : l'une redirige l'utilisateur vers
l'écran de consentement du fournisseur, l'autre gère le retour
(« callback »).

```php
<?php

namespace App\Controller;

use App\Controller\Controller;
use Bow\Soauth\Soauth;

class SoauthController extends Controller
{
    /**
     * Redirige vers l'écran de consentement du fournisseur choisi.
     */
    public function redirect(string $provider)
    {
        // Scopes spécifiques au fournisseur ; un tableau vide veut dire
        // « utiliser les scopes par défaut du fournisseur ».
        $scope = match ($provider) {
            'github'   => ['user:email'],
            'google'   => ['openid', 'email', 'profile'],
            'facebook' => ['email'],
            default    => [],
        };

        return Soauth::redirect($provider, $scope);
    }

    /**
     * Gère le retour OAuth et récupère l'utilisateur authentifié.
     */
    public function handle(string $provider)
    {
        $user = Soauth::resource($provider);

        // $user est un Bow\Soauth\UserResource — getId(), getName(),
        // getEmail(), getPictureUrl(), getNickName()… sont normalisés
        // entre tous les fournisseurs.
        return view('welcome', ['user' => $user]);
    }
}
```

### Ajouter les routes

Connectez les deux actions à l'URL de redirection et à l'URL de callback
configurée dans la console développeur du fournisseur :

```php
$app->get('/oauth/:provider/redirect', 'SoauthController::redirect');
$app->get('/oauth/:provider/callback', 'SoauthController::handle');
```

## Gestion des erreurs

`Soauth::redirect()` et `Soauth::resource()` lèvent
`Bow\Soauth\Exception\SoauthException` en cas d'échec. Les causes les plus
fréquentes :

- **Fournisseur inconnu** — le nom n'est pas l'un des six pris en charge.
- **Fournisseur non configuré** — les identifiants n'ont pas été chargés
  dans `config('soauth.<fournisseur>')`.
- **État CSRF invalide** — le callback n'a pas renvoyé l'`state` que nous
  avions stocké, ou la session a expiré entre la redirection et le retour.
- **Code d'autorisation manquant** — l'URL de callback ne contient pas le
  paramètre `code`.

Encadrez le handler de callback dans un try/catch et redirigez l'utilisateur
vers votre page de connexion avec un message flash en cas d'erreur.

## Auteur

**Franck DAKIA** — développeur Full Stack basé en Côte d'Ivoire (Abidjan).
Passionné de code, conférencier, formateur, membre de plusieurs communautés
de développeurs.

Contact: [dakiafranck@gmail.com](mailto:dakiafranck@gmail.com) — [@franck_dakia](https://twitter.com/franck_dakia)

Pour signaler un bogue, écrivez-moi par email ou ouvrez une issue sur le
[dépôt soauth](https://github.com/bowphp/soauth).

> N'hésitez pas à donner votre avis sur la documentation ou à suggérer des corrections.
