<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(Request $request): JsonResponse
    {
        $content = $request->request->get('key');

        return $this->json([
            'key' => $content,
            'text' => 'That text. We kiss the Stars',
            'message' => 'Welcome to your API controller!',
        ]);
    }
}
