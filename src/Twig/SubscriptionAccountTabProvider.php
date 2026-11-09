<?php

namespace Wexample\SymfonySubscriptionDs\Twig;

use Symfony\Contracts\Translation\TranslatorInterface;
use Wexample\SymfonySubscriptionDs\Controller\Pages\SubscriptionController;
use Wexample\SymfonyUserDs\Interface\AccountTabProviderInterface;

/**
 * The subscription as a tab of an account's page in the administration.
 */
class SubscriptionAccountTabProvider implements AccountTabProviderInterface
{
    public const string LABEL = 'WexampleSymfonySubscriptionDsBundle.common.subscription::tab';

    public const string ICON = 'ph:bold/credit-card';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function getAccountTabs(array $account): array
    {
        return [[
            'label' => $this->translator->trans(self::LABEL),
            'route' => SubscriptionController::ROUTE_ACCOUNT,
            'params' => ['id' => $account['id']],
            'icon' => self::ICON,
        ]];
    }
}
