<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

use App\Repository\PriceRepository;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api', methods:["POST"])]
    public function index(Request $request, PriceRepository $repository): JsonResponse
    {
        $data_json = $request->request->get('data');
        if (empty($data_json)) {
            throw new CustomUserMessageAccountStatusException('data field is required');
        }

        $data = json_decode($data_json);
        $result = 0;

        try {
            $result = $repository->addList($data);
        } catch(\Exception $e){
            throw new CustomUserMessageAccountStatusException($e->getMessage());
        }

        return $this->json($result);
    }
}
