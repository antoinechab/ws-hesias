<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\DTO\BookInput;
use App\Entity\Book;
use App\Repository\BookRepository;

class BookDataTransfomer implements ContextAwareDataPersisterInterface
{
    public function __construct(private BookRepository $bookRepository)
    {
    }


    public function supports($data, array $context = []): bool
    {
        return $data instanceof Book;
    }

    public function persist($data, array $context = [])
    {
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $this->bookRepository->delete($data);
    }
}
