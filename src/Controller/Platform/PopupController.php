<?php

namespace App\Controller\Platform;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PopupController extends _PlatformController
{
    public function start(Request $request): JsonResponse
    {
        return new JsonResponse([
            'status' => 'success',
            'message' => 'Popup started',
        ]);
    }
}
