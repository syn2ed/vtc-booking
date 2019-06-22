<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\DevisCourseType;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/reservation", name="reservation")
     */
    public function reservation()
    {
        $form = $this->createForm(DevisCourseType::class);

        return $this->render('main/reservation.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/prestations", name="prestations")
     */
    public function prestations()
    {
        return $this->render('main/prestations.html.twig', [
        ]);
    }
}
