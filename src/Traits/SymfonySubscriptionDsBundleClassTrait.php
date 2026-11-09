<?php

namespace Wexample\SymfonySubscriptionDs\Traits;

use Wexample\SymfonyHelpers\Traits\BundleClassTrait;
use Wexample\SymfonySubscriptionDs\WexampleSymfonySubscriptionDsBundle;

trait SymfonySubscriptionDsBundleClassTrait
{
    use BundleClassTrait;

    public static function getBundleClassName(): string
    {
        return WexampleSymfonySubscriptionDsBundle::class;
    }
}
