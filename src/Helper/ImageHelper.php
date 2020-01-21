<?php

namespace App\Helper;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ImageHelper
 * @author Kevin Monmousseau <k.monmousseau@gmail.com>
 */
final class ImageHelper
{
    public const PAINTING_TYPE = 0;

    /**
     * @var string
     */
    private $publicDirectory;

    /**
     * @var string
     */
    private $defaultUploadsDirectory;

    /**
     * @var string[]
     */
    private $directories;

    /**
     * ImageHelper constructor.
     * @param string $publicDirectory
     * @param string $defaultUploadsDirectory
     * @param string[] $directories
     */
    public function __construct(
        string $publicDirectory,
        string $defaultUploadsDirectory,
        array $directories
    ) {
        $this->publicDirectory = $publicDirectory;
        $this->defaultUploadsDirectory = $defaultUploadsDirectory;
        $this->directories = $directories;
    }

    /**
     * @param int $type
     * @return string
     */
    private function getDirectory(int $type)
    {
        return $this->directories[$type] ?? $this->defaultUploadsDirectory;
    }

    /**
     * @param int $type
     * @param UploadedFile|null $uploadedFile
     * @param string|null $name
     * @return array
     */
    public function upload(int $type, ?UploadedFile $uploadedFile, string $name = null): array
    {
        if (!$uploadedFile) {
            return [null, null];
        }
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $name ?? $originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

        $directory = $this->getDirectory($type);
        try {
            $uploadedFile->move(
                $this->publicDirectory.$directory,
                $newFilename
            );
        } catch (FileException $e) {
            throw $e;
        }

        return [$newFilename, $directory];
    }

    /**
     * @param string $path
     */
    public function delete(string $path): void
    {
        $filesystem = new Filesystem();
        $filesystem->remove($this->publicDirectory.$path);
    }
}
