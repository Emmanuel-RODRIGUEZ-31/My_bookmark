<?php

namespace App\Controller;

use App\Entity\Bookmark;
use App\Form\BookmarkType;
use App\Repository\BookmarkRepository;
use App\Repository\TypeRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchBookmarkType;

#[Route('/bookmark', name: 'bookmark_')]
class BookmarkController extends AbstractController
{
    #[Route('/index', name: 'index', methods: ['GET', 'POST'])]
    public function index(Request $request, BookmarkRepository $bookmarkRepository, TypeRepository $typeRepository): Response
    {
        $form = $this->createForm(SearchBookmarkType::class);
        $form->handleRequest($request);
        $message = 'No results';

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            if (strlen($search) === 0) {
                $bookmarks = null;
            }
            else {
                $bookmarks = $bookmarkRepository->findLikeName($search, $this->getUser()->getId());
            }
        } else {
            $bookmarks = null;
        }

        return $this->render('bookmark/index.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_ON_GOING,
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_END,
            ]),
            'bookmarks' => $bookmarkRepository->findByUser($this->getUser()),
            'types' => $typeRepository->findAll(),
            'animeCount' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'type' => 'anime',
                'status' => Bookmark::STATUS_ON_GOING,
            ]),
            'serieCount' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'type' => 'serie',
                'status' => Bookmark::STATUS_ON_GOING,
            ]),
            'mangaCount' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'type' => 'manga',
                'status' => Bookmark::STATUS_ON_GOING,
            ]),
            'bdCount' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'type' => 'bd',
                'status' => Bookmark::STATUS_ON_GOING,
            ]),
            'comicsCount' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'type' => 'comics',
                'status' => Bookmark::STATUS_ON_GOING,
            ]),
            'bookCount' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'type' => 'book',
                'status' => Bookmark::STATUS_ON_GOING,
            ]),
            'form' => $form->createView(),
            'searchResult' => $bookmarks,
            'message' => $message,
        ]);
    }

    #[Route('/anime', name: 'anime', methods: ['GET'])]
    public function anime(BookmarkRepository $bookmarkRepository, TypeRepository $typeRepository): Response
    {
        return $this->render('bookmark/animes.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_ON_GOING,
                'type' => $typeRepository->findOneByName('anime')->getId(),
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_END,
                'type' => $typeRepository->findOneByName('anime')->getId(),
            ]),
        ]);
    }

    #[Route('/serie', name: 'serie', methods: ['GET'])]
    public function serie(BookmarkRepository $bookmarkRepository, TypeRepository $typeRepository): Response
    {
        return $this->render('bookmark/series.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_ON_GOING,
                'type' => $typeRepository->findOneByName('serie')->getId(),
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_END,
                'type' => $typeRepository->findOneByName('serie')->getId(),
            ]),
        ]);
    }

    #[Route('/manga', name: 'manga', methods: ['GET'])]
    public function manga(BookmarkRepository $bookmarkRepository, TypeRepository $typeRepository): Response
    {
        return $this->render('bookmark/mangas.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_ON_GOING,
                'type' => $typeRepository->findOneByName('manga')->getId(),
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_END,
                'type' => $typeRepository->findOneByName('manga')->getId(),
            ]),
        ]);
    }

    #[Route('/bd', name: 'bd', methods: ['GET'])]
    public function bd(BookmarkRepository $bookmarkRepository, TypeRepository $typeRepository): Response
    {
        return $this->render('bookmark/bd.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_ON_GOING,
                'type' => $typeRepository->findOneByName('bd')->getId(),
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_END,
                'type' => $typeRepository->findOneByName('bd')->getId(),
            ]),
        ]);
    }

    #[Route('/comics', name: 'comics', methods: ['GET'])]
    public function comics(BookmarkRepository $bookmarkRepository, TypeRepository $typeRepository): Response
    {
        return $this->render('bookmark/comics.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_ON_GOING,
                'type' => $typeRepository->findOneByName('comics')->getId(),
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_END,
                'type' => $typeRepository->findOneByName('comics')->getId(),
            ]),
        ]);
    }

    #[Route('/book', name: 'book', methods: ['GET'])]
    public function book(BookmarkRepository $bookmarkRepository, TypeRepository $typeRepository): Response
    {
        return $this->render('bookmark/book.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_ON_GOING,
                'type' => $typeRepository->findOneByName('book')->getId(),
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'user' => $this->getUser(),
                'status' => Bookmark::STATUS_END,
                'type' => $typeRepository->findOneByName('book')->getId(),
            ]),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $bookmark = new Bookmark();
        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $bookmark
                ->setStartedAt(new DateTimeImmutable('now'))
                ->setStatus(Bookmark::STATUS_ON_GOING)
                ->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookmark);
            $entityManager->flush();
            
            return $this->redirectToRoute('bookmark_' . $bookmark->getType()->getName(), [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookmark/new.html.twig', [
            'bookmark' => $bookmark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Bookmark $bookmark): Response
    {
        $post = $_POST;

        $bookmark->setBookmark($post['bookmark']);
        $bookmark->setComment($post['comment']);
        $bookmark->setUpdateAt(new DateTimeImmutable('now'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $route = $bookmark->getType()->getName();

        return $this->redirectToRoute('bookmark_' . $route, [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/close', name: 'close', methods: ['GET', 'POST'])]
    public function close(Bookmark $bookmark): Response
    {
        $bookmark->setStatus(Bookmark::STATUS_END);
        $bookmark->setEndedAt(new DateTimeImmutable('now'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        
        $route = $bookmark->getType()->getName();

        return $this->redirectToRoute('bookmark_' . $route, [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['GET', 'POST'])]
    public function delete(Bookmark $bookmark): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($bookmark);
        $entityManager->flush();
        
        $route = $bookmark->getType()->getName();

        return $this->redirectToRoute('bookmark_' . $route, [], Response::HTTP_SEE_OTHER);
    }
}
