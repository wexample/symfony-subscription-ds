## An account's subscription

Two tabs, added through symfony-user-ds's tab providers:

- on the signed-in account's profile, `/account/subscription`: the plan running, since when, what is left of it — « unlimited » for a plan with no limit —, and every plan it has been on;
- on an account's page in the administration, `/accounts/{id}/subscription`: the same, and a form putting the account on another plan from now, the running one ended (symfony-subscription's `subscribe()`).

The plans offered are the application's (`wexample_symfony_subscription.plans`), shown by their name.

## Installation

```php
// config/bundles.php
Wexample\SymfonySubscriptionDs\WexampleSymfonySubscriptionDsBundle::class => ['all' => true],
```

```yaml
# config/routes/….yaml
symfony_subscription_ds:
    resource: '@WexampleSymfonySubscriptionDsBundle/Controller/'
    type: attribute
```
