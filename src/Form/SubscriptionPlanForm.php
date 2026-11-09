<?php

namespace Wexample\SymfonySubscriptionDs\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Wexample\SymfonyForms\Form\AbstractForm;
use Wexample\SymfonyForms\Form\Type\SelectInputType;

/**
 * An account put on a plan from now, among the application's.
 */
class SubscriptionPlanForm extends AbstractForm
{
    public const string FIELD_PLAN = 'plan';

    public const string OPTION_PLANS = 'plans';

    public static bool $ajax = true;

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setRequired(self::OPTION_PLANS);
        $resolver->setAllowedTypes(self::OPTION_PLANS, 'array');
    }

    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder->add(self::FIELD_PLAN, SelectInputType::class, [
            self::FIELD_OPTION_NAME_LABEL => true,
            self::FIELD_OPTION_NAME_REQUIRED => true,
            self::FIELD_OPTION_NAME_MAPPED => false,
            'choices' => array_combine($options[self::OPTION_PLANS], $options[self::OPTION_PLANS]),
            'auto_translate_choices' => false,
            'choice_translation_domain' => false,
        ]);
        $this->builderAddSubmit($builder);
    }
}
