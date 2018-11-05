<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Controller;

use App\Service\ExchangeClientInterface;
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
    public function index(Request $request, ExchangeClientInterface $client)
    {
        $rub = (float) $request->query->get('rub');
        $rate = $client->getRate('RUB','PLN');
        $pln = $rub * $rate;

        return new JsonResponse(['rub' => $rub, 'rate' => $rate, 'pln' => $pln]);
    }
}