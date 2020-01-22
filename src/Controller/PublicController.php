<?php

namespace App\Controller;

use App\Entity\Painting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PublicController
 * @author Kevin Monmousseau <k.monmousseau@gmail.com>
 */
final class PublicController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $paintings = $entityManager
            ->getRepository(Painting::class)
            ->findBy([], ['date'=> 'DESC']);

        return $this->render('app/gallery.html.twig', [
            'paintings' => $paintings,
        ]);
    }
}
