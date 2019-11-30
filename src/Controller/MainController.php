<?php

namespace App\Controller;

use App\Entity\Travel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
    public function reservation(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(DevisCourseType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $travel = new Travel();


            return $this->render('main/reservation.html.twig', [
                'form' => $form->createView(),
            ]);
        } 

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
