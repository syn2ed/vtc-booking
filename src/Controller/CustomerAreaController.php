<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/espace-client")
 */
class CustomerAreaController extends AbstractController
{
    /**
     * @Route("/", name="customerArea_index")
     */
    public function index()
    {
        return $this->render('customerArea/index.html.twig', [
        ]);
    }
}