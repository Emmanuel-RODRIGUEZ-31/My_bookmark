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
        return $this->render('bookmark/index.html.twig', [
            'onGoingAnimesBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => $typeRepository->findByName('anime'),
            ]),
            'endedAnimesBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => $typeRepository->findByName('anime'),
            ]),

            'onGoingSeriesBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => $typeRepository->findByName('serie'),
            ]),
            'endedSeriesBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => $typeRepository->findByName('serie'),
            ]),

            'onGoingMangasBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => $typeRepository->findByName('manga'),
            ]),
            'endedMangasBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => $typeRepository->findByName('manga'),
            ]),

            'onGoingBdBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => $typeRepository->findByName('bd'),
            ]),
            'endedBdBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => $typeRepository->findByName('bd'),
            ]),

            'onGoingComicsBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => $typeRepository->findByName('comics'),
            ]),
            'endedComicsBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => $typeRepository->findByName('comics'),
            ]),

            'types' => $typeRepository->findAll(),
        ]);
    }

    #[Route('/anime', name: 'anime', methods: ['GET'])]
    public function anime(BookmarkRepository $bookmarkRepository, TypeRepository $typeRepository): Response
    {
        return $this->render('bookmark/animes.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => $typeRepository->findByName('anime'),
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => $typeRepository->findByName('anime'),
            ]),
        ]);
    }

    #[Route('/serie', name: 'serie', methods: ['GET'])]
    public function serie(BookmarkRepository $bookmarkRepository, TypeRepository $typeRepository): Response
    {
        $type = $typeRepository->findByName('serie');

        return $this->render('bookmark/series.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => $typeRepository->findByName('serie'),
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => $typeRepository->findByName('serie'),
            ]),
        ]);
    }

    #[Route('/manga', name: 'manga', methods: ['GET'])]
    public function manga(BookmarkRepository $bookmarkRepository, TypeRepository $typeRepository): Response
    {
        return $this->render('bookmark/mangas.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => $typeRepository->findByName('manga'),
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => $typeRepository->findByName('manga'),
            ]),
        ]);
    }

    #[Route('/bd', name: 'bd', methods: ['GET'])]
    public function bd(BookmarkRepository $bookmarkRepository, TypeRepository $typeRepository): Response
    {
        return $this->render('bookmark/bd.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => $typeRepository->findByName('bd'),
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => $typeRepository->findByName('bd'),
            ]),
        ]);
    }

    #[Route('/comics', name: 'comics', methods: ['GET'])]
    public function comics(BookmarkRepository $bookmarkRepository, TypeRepository $typeRepository): Response
    {
        return $this->render('bookmark/comics.html.twig', [
            'onGoingBookmarks' => $bookmarkRepository->findBy([
                'status' => 'En cours',
                'type' => $typeRepository->findByName('comics'),
            ]),
            'endedBookmarks' => $bookmarkRepository->findBy([
                'status' => 'Terminé',
                'type' => $typeRepository->findByName('comics'),
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
