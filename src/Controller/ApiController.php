<?php
namespace App\Controller;

use App\Repository\LogRepository;
use App\Requests\LogRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 
 * @author Omar Makled <omar.makled@gmail.com>
 */
class ApiController extends BaseController
{
  #[Route('/count', methods: ['GET'])]
  public function getCount(LogRequest $logRequest, LogRepository $logRepo): JsonResponse
  {
    if (!$logRequest->isValid($this->query)) {
      return new JsonResponse('bad input parameter', 400);
    }

    return new JsonResponse([
      'counter' => (int) $logRepo->getCount($logRequest->getData()),
    ]);
  }
}
