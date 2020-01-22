<?php

namespace App\Handler;

use App\DTO\PaintingDTO;
use App\Entity\Painting;
use App\Helper\ImageHelper;
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
     * @var ImageHelper
     */
    private $imageHelper;

    /**
     * AddPaintingHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param ImageHelper $imageHelper
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ImageHelper $imageHelper
    ) {
        $this->entityManager = $entityManager;
        $this->imageHelper = $imageHelper;
    }

    /**
     * @param PaintingDTO $paintingDTO
     */
    public function handle(PaintingDTO $paintingDTO): void
    {
        $painting = new Painting();
        $painting
            ->setName($paintingDTO->name)
            ->setDate($paintingDTO->date)
            ->setWidth($paintingDTO->width)
            ->setHeight($paintingDTO->height);

        [$name, $directory] = $this->imageHelper->upload(ImageHelper::PAINTING_TYPE, $paintingDTO->image, $paintingDTO->name);
        if (null !== $name) {
            $painting->setImage($directory.'/'.$name);
        }

        $this->entityManager->persist($painting);
        $this->entityManager->flush();
    }
}
