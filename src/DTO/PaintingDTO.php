<?php

namespace App\DTO;

use App\Entity\Painting;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PaintingDTO
 * @author Kevin Monmousseau <k.monmousseau@gmail.com>
 */
final class PaintingDTO
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    public $date;

    /**
     * @var UploadedFile|null
     * @Assert\File(maxSize="5M", mimeTypes={"image/jpeg", "image/png"})
     */
    public $image;

    /**
     * @var string
     */
    public $knownImage;

    /**
     * @var int
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     */
    public $width;

    /**
     * @var int
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     */
    public $height;

    /**
     * @param Painting $painting
     * @return PaintingDTO
     */
    public static function createFromPainting(Painting $painting): PaintingDTO
    {
        $dto = new self();
        $dto->name = $painting->getName();
        $dto->date = $painting->getDate();
        $dto->knownImage = $painting->getImage();
        $dto->width = $painting->getWidth();
        $dto->height = $painting->getHeight();

        return $dto;
    }
}
