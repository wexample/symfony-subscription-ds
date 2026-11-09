<?php

namespace Wexample\SymfonySubscriptionDs\Controller\Pages;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Wexample\SymfonyHelpers\Entity\Interfaces\UserEntityInterface;
use Wexample\SymfonyLoader\Controller\AbstractPagesController;
use Wexample\SymfonySubscriptionDs\Service\FormProcessor\SubscriptionPlanFormProcessor;
use Wexample\SymfonySubscriptionDs\Service\SubscriptionScreenService;
use Wexample\SymfonySubscriptionDs\Traits\SymfonySubscriptionDsBundleClassTrait;
use Wexample\SymfonyUserDs\Service\AccountPageService;

/**
 * An account's subscription: a tab of its holder's profile, to read it; a
 * tab of its page in the administration, to put it on another plan.
 */
#[IsGranted('IS_AUTHENTICATED')]
final class SubscriptionController extends AbstractPagesController
{
    use SymfonySubscriptionDsBundleClassTrait;

    public const string ROUTE_PROFILE = 'user_subscription_index';

    public const string ROUTE_ACCOUNT = 'user_accounts_subscription';

    #[Route(path: '/account/subscription', name: self::ROUTE_PROFILE)]
    public function profile(SubscriptionScreenService $screen): Response
    {
        $user = $this->getUser();

        if (! $user instanceof UserEntityInterface) {
            throw $this->createNotFoundException();
        }

        return $this->renderPage('profile', [
            'subscription' => $screen->describe($user),
        ]);
    }

    #[Route(path: '/accounts/{id}/subscription', name: self::ROUTE_ACCOUNT)]
    public function account(
        string $id,
        AccountPageService $accountPage,
        SubscriptionScreenService $screen,
        SubscriptionPlanFormProcessor $planFormProcessor,
    ): Response {
        $account = $accountPage->findAdministered($id);

        if (! $account instanceof UserEntityInterface) {
            throw $this->createNotFoundException();
        }

        return $this->renderPage('account', [
            ...$accountPage->getFrameParameters($account),
            'subscription' => $screen->describe($account),
            'subscription_plan_form' => $planFormProcessor->createForm($account)->createView(),
        ]);
    }
}
