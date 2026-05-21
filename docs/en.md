# Soauth

Social authentication for the Bow Framework.

## About

This package wraps [`thephpleague/oauth2-client`](https://github.com/thephpleague/oauth2-client)
behind a simple two-call API. Six providers are preconfigured:

- Facebook
- GitHub
- GitLab
- Google
- Instagram
- LinkedIn

## Install

```bash
composer require bowphp/soauth
```

Requires PHP 8.1+.

## Configuration

Register the configuration provider in your kernel's `configurations()`:

```php
return [
    \Bow\Soauth\SoauthConfiguration::class,
    // ...
];
```

Then declare the credentials for each provider you use in `.env.json`. Only the
providers you actually call need to be configured.

### Facebook

Create a Facebook application at <https://developers.facebook.com>.

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

## Usage

A typical controller has two actions: one that redirects the user to the
provider's consent screen and one that handles the callback.

```php
<?php

namespace App\Controller;

use App\Controller\Controller;
use Bow\Soauth\Soauth;

class SoauthController extends Controller
{
    /**
     * Redirect to the chosen provider's consent screen.
     */
    public function redirect(string $provider)
    {
        // Provider-specific scopes; empty array means "use the provider default".
        $scope = match ($provider) {
            'github'   => ['user:email'],
            'google'   => ['openid', 'email', 'profile'],
            'facebook' => ['email'],
            default    => [],
        };

        return Soauth::redirect($provider, $scope);
    }

    /**
     * Handle the OAuth callback and look up the authenticated user.
     */
    public function handle(string $provider)
    {
        $user = Soauth::resource($provider);

        // $user is a Bow\Soauth\UserResource — getId(), getName(), getEmail(),
        // getPictureUrl(), getNickName(), ... all normalised across providers.
        return view('welcome', ['user' => $user]);
    }
}
```

### Routes

Wire the two actions to a redirect URL and the callback URL configured in
the provider's developer console:

```php
$app->get('/oauth/:provider/redirect', 'SoauthController::redirect');
$app->get('/oauth/:provider/callback', 'SoauthController::handle');
```

## Error handling

Both `Soauth::redirect()` and `Soauth::resource()` throw
`Bow\Soauth\Exception\SoauthException` on failure. The most common causes:

- **Unknown provider** — the name isn't one of the six supported strings.
- **Provider not configured** — credentials weren't loaded into
  `config('soauth.<provider>')`.
- **CSRF state mismatch** — the callback didn't carry back the state we
  stored, or the session expired between redirect and callback.
- **Missing authorisation code** — the callback URL didn't carry a `code`
  query parameter.

Wrap the callback handler in a try/catch and route failures to your login
page with a flash error.

## Author

**Franck DAKIA** — Full Stack developer based in Côte d'Ivoire. Speaker,
trainer, and member of several developer communities.

Contact: [dakiafranck@gmail.com](mailto:dakiafranck@gmail.com) — [@franck_dakia](https://twitter.com/franck_dakia)

If you spot a bug, email me or open an issue on the
[soauth repository](https://github.com/bowphp/soauth).

> Feel free to give your opinion on the documentation or suggest corrections.
