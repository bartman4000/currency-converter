<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Controller\Api;

use App\Service\ExchangeServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConvertController extends AbstractController
{
    /**
     * @Route("/api/convert", methods={"GET"})
     */
    public function index(Request $request, ExchangeServiceInterface $service, LoggerInterface $logger): JsonResponse
    {
        $from = $request->query->get('from');
        $to = $request->query->get('to');
        $amount = (float) $request->query->get('amount');

        try {
            $result = $service->exchange($from, $to, $amount);
        } catch (\Exception $e) {
            $logger->error($e->getMessage());
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }

        return new JsonResponse(['from' => $from, 'to' => $to, 'amount'=> $amount, 'result' => $result]);
    }
}
