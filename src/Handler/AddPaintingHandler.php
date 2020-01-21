<?php

namespace App\Handler;

use App\DTO\PaintingDTO;
use App\Entity\Painting;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AddPaintingHandler
 * @author Kevin Monmousseau <k.monmousseau@gmail.com>
 */
final class AddPaintingHandler
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
     * @param PaintingDTO $paintingDTO
     * @todo add image
     */
    public function handle(PaintingDTO $paintingDTO): void
    {
        $painting = new Painting();
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
