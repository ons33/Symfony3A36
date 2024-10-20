<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
class BookController extends AbstractController
{
   
    #[Route("/book/get/all",name:'app_book_getall')]
    public function getAllbooks(BookRepository $repo) {
        $books= $repo->findAll();
        return $this->render('book/listbooks.html.twig',['books'=>$books]);
    }

    #[Route('/book/add',name:'app_book_add')]
    public function addbook(EntityManagerInterface $em,AuthorRepository $repo ){
        $book = new Book();
        $book->setTitle('book 1');
        $book->setPublicationDate(new \DateTime());
        $book->setEnabled(true);
        $author= $repo->find(2);
        $book->setAuthor($author);
     


        $em->persist($book);
     

        $em->flush();
        return $this->redirectToRoute('app_book_getall');
    }

    #[Route('/book/update/{id}',name:'app_book_update')]
    public function updatebook(EntityManagerInterface $em,$id
    ,bookRepository $repo){
        $book = $repo->find($id);
        $book->setTitle('book updated');
        $em->flush();
        return $this->redirectToRoute('app_book_getall');
    }

     #[Route('/book/delete/{id}',name:'app_book_delete')]
    public function deletebook(ManagerRegistry $manager,$id
    ,bookRepository $repo){
        $book = $repo->find($id);
        $em=$manager->getManager();
        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute('app_book_getall');
    }
}
