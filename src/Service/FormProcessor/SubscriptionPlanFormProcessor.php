<?php

namespace Wexample\SymfonySubscriptionDs\Service\FormProcessor;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Wexample\SymfonyForms\Controller\FormController;
use Wexample\SymfonyForms\Service\FormProcessor\AbstractFormProcessor;
use Wexample\SymfonyHelpers\Entity\Interfaces\UserEntityInterface;
use Wexample\SymfonySubscription\Service\SubscriptionPlanRegistry;
use Wexample\SymfonySubscription\Service\SubscriptionService;
use Wexample\SymfonySubscriptionDs\Controller\Pages\SubscriptionController;
use Wexample\SymfonySubscriptionDs\Form\SubscriptionPlanForm;
use Wexample\SymfonyUserDs\Service\AccountPageService;

/**
 * An account put on a plan by an administrator. Which account travels in the
 * submission url, never in a field; the account's subscription page reloads.
 */
class SubscriptionPlanFormProcessor extends AbstractFormProcessor
{
    private ?UserEntityInterface $account = null;

    public function __construct(
        FormFactoryInterface $formFactory,
        RequestStack $requestStack,
        UrlGeneratorInterface $urlGenerator,
        private readonly AccountPageService $accountPage,
        private readonly SubscriptionService $subscriptions,
        private readonly SubscriptionPlanRegistry $plans,
    ) {
        parent::__construct($formFactory, $requestStack, $urlGenerator);
    }

    /**
     * The account of the submission handled, not of the next one.
     */
    public function reset(): void
    {
        parent::reset();
        $this->account = null;
    }

    public function createForm(
        $data = null,
        array $options = []
    ): FormInterface {
        $this->account = $data;

        return parent::createForm(null, $options + [
            SubscriptionPlanForm::OPTION_PLANS => array_map(static fn ($plan) => $plan->name, $this->plans->all()),
        ]);
    }

    public function getFormActionRoute(): string
    {
        return 'form_' . FormController::ROUTE_ENTITY_FORM_PROCESSOR_SUBMIT;
    }

    public function getFormActionArgs($data): array
    {
        return parent::getFormActionArgs($data) + ['id' => (string) $this->account->getId()];
    }

    public function handleSubmittedRequest(Request $request): UserEntityInterface
    {
        return $this->accountPage->findAdministered((string) $request->attributes->get('id'));
    }

    public function onValid(FormInterface $form)
    {
        $this->subscriptions->subscribe($this->account, (string) $form->get(SubscriptionPlanForm::FIELD_PLAN)->getData());

        $this->setNotification('@form::success.message');
        $this->redirectToRoute(SubscriptionController::ROUTE_ACCOUNT, ['id' => (string) $this->account->getId()]);
    }
}
