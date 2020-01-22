<?php

namespace App\Handler;

use App\DTO\PaintingDTO;
use App\Entity\Painting;
use App\Helper\ImageHelper;
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
     * @var ImageHelper
     */
    private $imageHelper;

    /**
     * UpdatePaintingHandler constructor.
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
     * @param Painting $painting
     * @param PaintingDTO $paintingDTO
     */
    public function handle(Painting $painting, PaintingDTO $paintingDTO): void
    {
        $painting
            ->setName($paintingDTO->name)
            ->setDate($paintingDTO->date)
            ->setWidth($paintingDTO->width)
            ->setHeight($paintingDTO->height);

        $oldImage = $painting->getImage();
        [$name, $directory] = $this->imageHelper->upload(ImageHelper::PAINTING_TYPE, $paintingDTO->image, $paintingDTO->name);
        if (null !== $name) {
            $painting->setImage($directory.'/'.$name);
            if (!empty($oldImage)) {
                $this->imageHelper->delete($oldImage);
            }
        }

        $this->entityManager->persist($painting);
        $this->entityManager->flush();
    }
}
