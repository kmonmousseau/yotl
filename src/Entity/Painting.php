<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Painting
 * @author Kevin Monmousseau <k.monmousseau@gmail.com>
 *
 * @ORM\Entity(repositoryClass="App\Repository\PaintingRepository")
 */
final class Painting
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=36)
     */
    private $uuid;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $image;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $height;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid instanceof Uuid ? $this->uuid : Uuid::fromString($this->uuid);
    }

    /**
     * @param $uuid
     * @return $this
     */
    public function setUuid($uuid): self
    {
        $this->uuid = $uuid instanceof Uuid ? $uuid : Uuid::fromString($uuid);

        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): Painting
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDate(\DateTime $date): Painting
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setImage(string $image): Painting
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return $this
     */
    public function setWidth(int $width): Painting
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return $this
     */
    public function setHeight(int $height): Painting
    {
        $this->height = $height;

        return $this;
    }
}
