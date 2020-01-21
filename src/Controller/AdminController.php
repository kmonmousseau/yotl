<?php

namespace App\Controller;

use App\DTO\PaintingDTO;
use App\Entity\Painting;
use App\Form\PaintingType;
use App\Handler\DeletePaintingHandler;
use App\Handler\UpdatePaintingHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Handler\AddPaintingHandler;

/**
 * Class AdminController
 * @Route("/admin", name="admin_")
 * @author Kevin Monmousseau <k.monmousseau@gmail.com>
 */
final class AdminController extends AbstractController
{
    /**
     * @var AddPaintingHandler
     */
    private $addPaintingHandler;

    /**
     * @var UpdatePaintingHandler
     */
    private $updatePaintingHandler;

    /**
     * @var DeletePaintingHandler
     */
    private $deletePaintingHandler;

    public function __construct(
        AddPaintingHandler $addPaintingHandler,
        UpdatePaintingHandler $updatePaintingHandler,
        DeletePaintingHandler $deletePaintingHandler
    ) {
        $this->addPaintingHandler = $addPaintingHandler;
        $this->updatePaintingHandler = $updatePaintingHandler;
        $this->deletePaintingHandler = $deletePaintingHandler;
    }

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
        $entityManager = $this->getDoctrine()->getManager();
        $paintings = $entityManager
            ->getRepository(Painting::class)
            ->findBy([], ['date'=> 'DESC']);

        return $this->render('admin/paintings.html.twig', [
            'paintings' => $paintings
        ]);
    }

    /**
     * @Route("/tableaux/ajouter", name="painting_add")
     * @param Request $request
     * @return Response
     */
    public function addPainting(Request $request): Response
    {
        $form = $this->createForm(PaintingType::class);
        $form->add('save', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $paintingDTO = $form->getData();

            $this->addPaintingHandler->handle($paintingDTO);

            return $this->redirectToRoute('admin_paintings');
        }

        return $this->render('admin/painting-form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tableaux/modifier/{uuid}", name="painting_update")
     * @param Request $request
     * @param string $uuid
     * @return Response
     */
    public function updatePainting(Request $request, string $uuid): Response
    {
        $painting = $this->findPainting($uuid);

        $form = $this->createForm(PaintingType::class, PaintingDTO::createFromPainting($painting));
        $form->add('save', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $paintingDTO = $form->getData();

            $this->updatePaintingHandler->handle($painting, $paintingDTO);

            return $this->redirectToRoute('admin_paintings');
        }

        return $this->render('admin/painting-form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tableaux/supprimer/{uuid}", name="painting_delete")
     * @param string $uuid
     * @return RedirectResponse
     */
    public function deletePainting(string $uuid): RedirectResponse
    {
        $painting = $this->findPainting($uuid);
        $this->deletePaintingHandler->handle($painting);

        return $this->redirectToRoute('admin_paintings');
    }

    /**
     * @param string $uuid
     * @return Painting
     * @throws NotFoundHttpException
     */
    private function findPainting(string $uuid): Painting
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var Painting|null $painting */
        $painting = $entityManager->getRepository(Painting::class)->findOneBy(['uuid' => $uuid]);
        if (null === $painting) {
            throw new NotFoundHttpException();
        }

        return $painting;
    }
}
