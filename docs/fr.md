# Soauth

Package d'authentification via les reseaux sociaux pour Bow Framework.

## À propos

Ce package utilise le fichier [`thephpleague/oauth2-client`](https://github.com/thephpleague/oauth2-client) pour faire un wrapper.

Actuellement, il supporte le fournisseur suivant:

- Facebook
- Gitlab
- Github

## Installation

Pour installer ce paquet, vous devez utiliser [composer](https://getcomposer.org). Nous vous recommandons de l'installer globalement.

```bash
composer require bowphp/soauth
```

### Configuration

Après l'installation Dans votre fichier `.env.json`, vous devez définir les informations d’accès au fournisseur comme suit:

#### Pour facebook:

Vous pouvez créer la nouvelle application facebook à l’adresse [https://developers.facebook.com/fr](https://developers.facebook.com/fr).

```bash
FACEBACK_CLIENT_ID=client_id
FACEBACK_CLIENT_SECRET=client_secret
FACEBACK_REDIRECT_URI=redirect_uri
```

#### Pour gitlab:

```bash
GITLAB_CLIENT_ID=client_id
GITLAB_CLIENT_SECRET=client_secret
GITLAB_REDIRECT_URI=redirect_uri
```

#### Pour github:

```bash
GITHUB_CLIENT_ID=client_id
GITHUB_CLIENT_SECRET=client_secret
GITHUB_REDIRECT_URI=redirect_uri
```

## Utilisation

Pour utiliser le package, vous devez importer la configuration du package:

```php
return [
  \Bow\Soauth\SoauthConfiguration::class,
  ...
];
```

Nous considérons le contrôleur suivant:

```php
<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Bow\Soauth\Soauth;

class SoauthController extends Controller
{
  /**
   * Redirection vers le fournisseur define
   * 
   * @param string $provider
   * @return mixed
   */
  public function redirect($provider)
  {
    return Soauth::redirect($provider, $scope);
  }

  /**
   * Gérer les informations oauth
   * 
   * @param string $provider
   * @return mixed
   */
  public function handle($provider)
  {
    $user = Soauth::resource($provider);
  }
}
```

### Ajouter un itinéraire

Définissez la route qui utilisera pour les actions d’appel soauth:

```php
$app->get('/oauth/:provider/redirect', 'SoauthController::redirect');
$app->get('/oauth/:provider/callback', 'SoauthController::handle');
```

#### Auteur

**Franck DAKIA** est un développeur Full Stack basé actuellement en Afrique, Côte d'ivoire, Abidjan. Passioné de code, et développement collaboratif, Speaker, Formateur et Membre de plusieurs communautés de développeurs.

Contact: [dakiafranck@gmail.com](mailto:dakiafranck@gmail.com) - [@franck_dakia](https://twitter.com/franck_dakia)

**SVP s'il y a un bogue sur le projet veuillez me contacter par email ou laissez moi un message sur le [slack](https://bowphp.slack.com).**

> N'hésitez pas à donner votre avis sur la qualité de la documentation ou à suggérer des corrections.
