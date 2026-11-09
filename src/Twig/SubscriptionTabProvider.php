<?php

namespace Wexample\SymfonySubscriptionDs\Twig;

use Symfony\Contracts\Translation\TranslatorInterface;
use Wexample\SymfonySubscriptionDs\Controller\Pages\SubscriptionController;
use Wexample\SymfonyUserDs\Interface\AccountTabProviderInterface;
use Wexample\SymfonyUserDs\Interface\ProfileTabProviderInterface;

/**
 * The subscription as a tab of the profile and of an account's page.
 */
class SubscriptionTabProvider implements ProfileTabProviderInterface, AccountTabProviderInterface
{
    private const string LABEL = 'WexampleSymfonySubscriptionDsBundle.common.subscription::tab';

    private const string ICON = 'ph:bold/credit-card';

    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function getProfileTabs(): array
    {
        return [[
            'label' => $this->translator->trans(self::LABEL),
            'route' => SubscriptionController::ROUTE_PROFILE,
            'icon' => self::ICON,
        ]];
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
