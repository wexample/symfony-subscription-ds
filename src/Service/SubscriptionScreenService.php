<?php

namespace Wexample\SymfonySubscriptionDs\Service;

use Wexample\SymfonyHelpers\Entity\Interfaces\UserEntityInterface;
use Wexample\SymfonySubscription\Repository\SubscriptionRepository;
use Wexample\SymfonySubscription\Service\SubscriptionService;

/**
 * An account's subscription as its screens show it: the one running, what is
 * left of it, and every one it has had.
 */
class SubscriptionScreenService
{
    public function __construct(
        private readonly SubscriptionService $subscriptions,
        private readonly SubscriptionRepository $repository,
    ) {
    }

    /**
     * @return array{running: ?array{plan: string, since: \DateTimeImmutable, remaining: ?int}, history: list<array{plan: string, start: \DateTimeImmutable, end: ?\DateTimeImmutable}>}
     */
    public function describe(UserEntityInterface $user): array
    {
        $running = $this->subscriptions->findRunning($user);

        return [
            'running' => $running ? [
                'plan' => $running->getPlan(),
                'since' => $running->getDateStart(),
                'remaining' => $this->subscriptions->getRemaining($running),
            ] : null,
            'history' => array_map(static fn ($subscription) => [
                'plan' => $subscription->getPlan(),
                'start' => $subscription->getDateStart(),
                'end' => $subscription->getDateEnd(),
            ], $this->repository->findOfUser($user)),
        ];
    }
}
