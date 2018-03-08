<?php 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends Controller
{
	/**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('public/homepage.html.twig');
    }
}