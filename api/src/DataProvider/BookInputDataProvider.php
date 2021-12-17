<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\BookOutput;
use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\Finder\Finder;

class BookInputDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(private BookRepository $bookRepository)
    {
    }


    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $books = $this->bookRepository->findAll();
        $finder = new Finder();
        $finder->files()->in(dirname(__FILE__, 3))->name('file-data-persisted*');
        $iterator = $finder->getIterator();
        $iterator->rewind();
        $firstFile = $iterator->current();
        if ($firstFile){
            $content = json_decode(file_get_contents($firstFile->getPathName()));
            foreach ($books as $book){
                foreach ($content as $ctd){
                    if ($ctd->id === $book->getId()){
                        $book->setCode($ctd->code);
                    }
                }
            }
        }


        return $books;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Book::class === $resourceClass;
    }
}
