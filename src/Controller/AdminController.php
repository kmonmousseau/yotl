<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @Route("/admin", name="admin_")
 * @author Kevin Monmousseau <k.monmousseau@gmail.com>
 */
final class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('base-admin.html.twig');
    }

    /**
     * @Route("/tableaux", name="paintings")
     * @return Response
     */
    public function paintings(): Response
    {
        return $this->render('admin/paintings.html.twig');
    }
}
