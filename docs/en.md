# Soauth

The social authentification package for Bow Framework.

## About

This package use the `thephpleague/oauth2-client` [https://github.com/thephpleague/oauth2-client](https://github.com/thephpleague/oauth2-client) for make a wrapper.

Actualy it support the following provider:

- Facebook
- Gitlab
- Github

## Install

For install this package you must use [composer](https://getcomposer.org). We recommand you to install it in globaly.

```bash
composer require bowphp/soauth
```

### Configuration

After you installation. In you `.env.json`, you must define the provider acces information like this:

#### For facebook:

You can create the new facebook application in [https://developers.facebook.com/](https://developers.facebook.com).

```bash
FACEBACK_CLIENT_ID=client_id
FACEBACK_CLIENT_SECRET=client_secret
FACEBACK_REDIRECT_URI=redirect_uri
```

#### For gitlab:

```bash
GITLAB_CLIENT_ID=client_id
GITLAB_CLIENT_SECRET=client_secret
GITLAB_REDIRECT_URI=redirect_uri
```

#### For github:

```bash
GITHUB_CLIENT_ID=client_id
GITHUB_CLIENT_SECRET=client_secret
GITHUB_REDIRECT_URI=redirect_uri
```

## Usable

For use the package, you must import the package configuration:

```php
return [
	\Bow\Soauth\SoauthConfiguration::class,
	...
];
```

We consider the following controller:

```php
<?php

namespace App\Controller;

use App\Controller\Controller;
use Bow\Soauth\Soauth;

class SoauthController extends Controller
{
	/**
	 * Redirect to the define provider
	 * 
	 * @param string $provider
	 * @return mixed
	 */
	public function redirect($provider)
	{
		return Soauth::redirect($provider, $scope);
	}

	/**
	 * Handle oauth information
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

### Add route

Define the route who will use for call soauth actions:

```php
$app->get('/oauth/:provider/redirect', 'SoauthController::redirect');
$app->get('/oauth/:provider/callback', 'SoauthController::callback');
```

#### Author

**Franck DAKIA** is a Full Stack developer currently based in Africa, Ivory Coast, Abidjan. Passionate about code, and collaborative development, Speaker, Trainer and Member of several communities of developers.

Contact: [dakiafranck@gmail.com](mailto:dakiafranck@gmail.com) - [@franck_dakia](https://twitter.com/franck_dakia)

**Please, if there is a bug on the project please contact me by email or leave me a message on the [slack](https://bowphp.slack.com).**

> Feel free to give your opinion on the quality of the documentation or suggest corrections.
