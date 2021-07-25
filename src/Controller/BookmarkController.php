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

#[Route('', name: 'bookmark_')]
class BookmarkController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(BookmarkRepository $bookmarkRepository, TypeRepository $typeRepository): Response
    {
        return $this->render('bookmark/animes.html.twig', [
            'onGoingAnimesBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => 1,
            ]),
            'endedAnimesBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => 1,
            ]),

            'onGoingSeriesBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => 2,
            ]),
            'endedSeriesBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => 2,
            ]),

            'onGoingMangasBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => 3,
            ]),
            'endedMangasBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => 3,
            ]),

            'onGoingBdBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => 4,
            ]),
            'endedBdBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => 4,
            ]),

            'onGoingComicsBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => 5,
            ]),
            'endedComicsBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => 5,
            ]),

            'types' => $typeRepository->findAll(),
        ]);
    }

    #[Route('/anime', name: 'anime', methods: ['GET'])]
    public function anime(BookmarkRepository $bookmarkRepository): Response
    {
        return $this->render('bookmark/animes.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => 1,
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => 1,
            ]),
        ]);
    }

    #[Route('/serie', name: 'serie', methods: ['GET'])]
    public function serie(BookmarkRepository $bookmarkRepository): Response
    {
        return $this->render('bookmark/series.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => 2,
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => 2,
            ]),
        ]);
    }

    #[Route('/manga', name: 'manga', methods: ['GET'])]
    public function manga(BookmarkRepository $bookmarkRepository): Response
    {
        return $this->render('bookmark/mangas.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => 3,
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => 3,
            ]),
        ]);
    }

    #[Route('/bd', name: 'bd', methods: ['GET'])]
    public function bd(BookmarkRepository $bookmarkRepository): Response
    {
        return $this->render('bookmark/bd.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => 4,
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => 4,
            ]),
        ]);
    }

    #[Route('/comics', name: 'comics', methods: ['GET'])]
    public function comics(BookmarkRepository $bookmarkRepository): Response
    {
        return $this->render('bookmark/comics.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => 5,
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => 5,
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
                ->setStatus(Bookmark::STATUS_ON_GOING);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookmark);
            $entityManager->flush();

            return $this->redirectToRoute('bookmark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookmark/new.html.twig', [
            'bookmark' => $bookmark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Bookmark $bookmark): Response
    {
        return $this->render('bookmark/show.html.twig', [
            'bookmark' => $bookmark,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bookmark $bookmark): Response
    {
        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookmark->setUpdateAt(new DateTimeImmutable('now'));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bookmark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookmark/edit.html.twig', [
            'bookmark' => $bookmark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Bookmark $bookmark): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookmark->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bookmark);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bookmark_index', [], Response::HTTP_SEE_OTHER);
    }
}
