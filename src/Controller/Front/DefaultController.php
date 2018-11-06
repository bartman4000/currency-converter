<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $form = $this->createFormBuilder()
            ->add('amount', MoneyType::class, array(
                'currency' => 'RUB',
                'empty_data' => '123'
            ))
            ->add('save', SubmitType::class, array('label' => 'Convert'))
            ->getForm();


        return $this->render('default/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}