<?php

namespace App\Controller\Platform;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class _PlatformController extends AbstractController
{
    public function __construct(
        protected RequestStack $requestStack,
    ) {
    }

    public function getPlatformBasicEnviroments()
    {
        return [
            'locale' => $this->requestStack->getCurrentRequest()->getLocale(),
            'request' => $this->requestStack->getCurrentRequest()->query->all(),
        ];
    }
}