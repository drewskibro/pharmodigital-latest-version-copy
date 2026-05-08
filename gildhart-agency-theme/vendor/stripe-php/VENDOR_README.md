# Stripe PHP SDK — Vendor Drop-In

This is the official Stripe PHP SDK, dropped in as-is rather than installed
via Composer. The theme has no Composer setup; this folder is loaded via
`require_once` from `inc/stripe.php`.

## Current version

**v17.5.0** — see `VERSION` file for the canonical answer.

## Source

Official release tarball from
https://github.com/stripe/stripe-php/releases/tag/v17.5.0

## Loading

The SDK is bootstrapped from `gildhart-agency-theme/inc/stripe.php`:

```php
require_once GILDHART_THEME_DIR . '/vendor/stripe-php/init.php';
```

## How to update to a newer version

1. Download the new release tarball:
   `curl -L -o new.tar.gz https://github.com/stripe/stripe-php/archive/refs/tags/vXX.X.X.tar.gz`
2. Delete this entire `stripe-php/` folder
3. Extract the tarball and rename the extracted folder to `stripe-php/`
4. Update the version number above
5. Smoke-test the agent checkout flow before committing

## What we use the SDK for

- `\Stripe\Customer::create()` — create a customer when the form submits
- `\Stripe\Subscription::create()` — create a default-incomplete subscription
- `\Stripe\PaymentIntent::retrieve()` — read PaymentIntent for thank-you page personalisation
- `\Stripe\PaymentIntent::update()` — write metadata to the PI for the thank-you page

We do **not** use:
- Webhooks (Make.com listens to Stripe webhooks directly, no WP-side endpoint)
- OAuth, Connect, Issuing, Treasury, Identity, Climate, Terminal, etc.

The full SDK is included anyway because trimming would break `init.php` (which
hard-codes every require path).
