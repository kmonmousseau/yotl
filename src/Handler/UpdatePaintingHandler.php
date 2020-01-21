<?php

namespace App\Handler;

use App\DTO\PaintingDTO;
use App\Entity\Painting;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UpdatePaintingHandler
 * @author Kevin Monmousseau <k.monmousseau@gmail.com>
 */
final class UpdatePaintingHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * AddPaintingHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Painting $painting
     * @param PaintingDTO $paintingDTO
     * @todo add image
     */
    public function handle(Painting $painting, PaintingDTO $paintingDTO): void
    {
        $painting
            ->setName($paintingDTO->name)
            ->setDate($paintingDTO->date)
            ->setWidth($paintingDTO->width)
            ->setHeight($paintingDTO->height)
            ->setImage(/*$paintingDTO->image*/'');

        $this->entityManager->persist($painting);
        $this->entityManager->flush();
    }
}
