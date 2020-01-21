<?php

namespace App\Handler;

use App\DTO\PaintingDTO;
use App\Entity\Painting;
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
     * AddPaintingHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Painting $painting
     * @todo remove image
     */
    public function handle(Painting $painting): void
    {
        $this->entityManager->remove($painting);
        $this->entityManager->flush();
    }
}
