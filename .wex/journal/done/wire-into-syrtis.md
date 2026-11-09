# Wire into Syrtis

The package is written; Syrtis does not require it yet in its composer.json, so
its bundle cannot be registered there. Once `wexample/symfony-subscription-ds`
is required:

- `config/bundles.php`: `Wexample\SymfonySubscriptionDs\WexampleSymfonySubscriptionDsBundle::class => ['all' => true]`;
- `config/routes/symfony_user.yaml`: import `@WexampleSymfonySubscriptionDsBundle/Controller/` (attribute);
- the page test kept beside this note (`syrtis-SubscriptionPageTest.php.txt`) as
  `tests/Controller/Pages/SubscriptionPageTest.php`, run.
