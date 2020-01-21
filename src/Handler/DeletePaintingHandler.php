<?php

namespace App\Handler;

use App\DTO\PaintingDTO;
use App\Entity\Painting;
use App\Helper\ImageHelper;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DeletePaintingHandler
 * @author Kevin Monmousseau <k.monmousseau@gmail.com>
 */
final class DeletePaintingHandler
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
     * DeletePaintingHandler constructor.
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
     * @todo remove image
     */
    public function handle(Painting $painting): void
    {
        $oldImage = $painting->getImage();
        if (!empty($oldImage)) {
            $this->imageHelper->delete($oldImage);
        }

        $this->entityManager->remove($painting);
        $this->entityManager->flush();
    }
}
