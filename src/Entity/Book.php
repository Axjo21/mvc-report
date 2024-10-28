<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $ISBN = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;


    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): static
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function setDetails(
        ?string $title = null,
        ?string $author = null, 
        ?string $isbn = null
    ): static
    {
        $this->title = $title;
        $this->author = $author;
        $this->ISBN = $isbn;
        return $this;
    }

    public function getImage(): mixed
    {       
        if($this->image) {
            // Use finfo to detect the MIME type from the binary data
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($this->image);

            // Base64 encode the binary image data
            $imageData = base64_encode($this->image);
            return [
                'imageData' => $imageData,
                'mimeType' => $mimeType
            ];
        }
        return $this->image;
    }


    public function setImageOLD(object | null $imageFile, ?bool $defaultImage = false): void
    {
        if($defaultImage) {
            $defaultImage = '../public/img/book-cover-placeholder.png';
            $imageData = file_get_contents($defaultImage);
            $this->image = $imageData;
            return;
        }

        if ($imageFile && $imageFile->isValid()) {
            $imageMimeType = $imageFile->getMimeType();
            if (!in_array($imageMimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
                throw new \Exception('Unsupported image type: ' . $imageMimeType);
            }
            // Read the binary content of the image file
            $imageData = file_get_contents($imageFile->getPathname());
            $this->image = $imageData;
            return;
        } else {
            $error = $imageFile->getError();
            throw new \Exception('File upload error: ' . $error);
        }
    }

    public function setImage(object | null $imageFile): void
    {
        if ($imageFile && $imageFile->isValid()) {
            $imageMimeType = $imageFile->getMimeType();
            if (!in_array($imageMimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
                throw new \Exception('Unsupported image type: ' . $imageMimeType);
            }
            // Read the binary content of the image file
            $imageData = file_get_contents($imageFile->getPathname());
            $this->image = $imageData;
            return;
        } else if ($imageFile == null) {
            $defaultImage = '../public/img/book-cover-placeholder.png';
            $imageData = file_get_contents($defaultImage);
            $this->image = $imageData;
            var_dump("setting default image!!!!!!!!!!!!!");
            return;
        } else {
            $error = $imageFile->getError();
            throw new \Exception('File upload error: ' . $error);
        }
    }

}
