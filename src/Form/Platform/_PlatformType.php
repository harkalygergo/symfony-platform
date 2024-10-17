<?php

namespace App\Form\Platform;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class _PlatformType extends AbstractType
{
    public function __construct(
        protected TranslatorInterface $translator
    ) {
    }
}
