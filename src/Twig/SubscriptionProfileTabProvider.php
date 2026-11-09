<?php

namespace Wexample\SymfonySubscriptionDs\Twig;

use Symfony\Contracts\Translation\TranslatorInterface;
use Wexample\SymfonySubscriptionDs\Controller\Pages\SubscriptionController;
use Wexample\SymfonyUserDs\Interface\ProfileTabProviderInterface;

/**
 * The subscription as a tab of the signed-in account's profile.
 */
class SubscriptionProfileTabProvider implements ProfileTabProviderInterface
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function getProfileTabs(): array
    {
        return [[
            'label' => $this->translator->trans(SubscriptionAccountTabProvider::LABEL),
            'route' => SubscriptionController::ROUTE_PROFILE,
            'icon' => SubscriptionAccountTabProvider::ICON,
        ]];
    }
}
