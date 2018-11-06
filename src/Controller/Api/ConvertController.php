<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Controller\Api;

use App\Service\ExchangeServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConvertController extends AbstractController
{
    /**
     * @Route("/api/convert", methods={"GET"})
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function index(Request $request, ExchangeServiceInterface $service): JsonResponse
    {
        $from = $request->query->get('from');
        $to = $request->query->get('to');
        $amount = (float) $request->query->get('amount');

        $result = $service->exchange($from, $to, $amount);
        return new JsonResponse(['from' => $from, 'to' => $to, 'amount'=> $amount, 'result' => $result]);
    }
}