<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class VideoController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(VideoRepository $videoRepository, PaginatorInterface $paginator, Request $request): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();

        $videos = $paginator->paginate(
            $videoRepository->queryVisible($user),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('video/index.html.twig', [
            'videos' => $videos,
        ]);
    }

    #[Route('/search', name: 'app_video_search')]
    #[IsGranted('ROLE_USER')]
    public function search(VideoRepository $videoRepository, PaginatorInterface $paginator, Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $term = trim($request->query->getString('q'));

        $videos = $paginator->paginate(
            $videoRepository->querySearch($term, $user),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('video/search.html.twig', [
            'videos' => $videos,
            'term' => $term,
        ]);
    }

    #[Route('/video/create', name: 'app_video_create')]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->isVerified()) {
            $this->addFlash('danger', 'flash.verified_only');

            return $this->redirectToRoute('app_home');
        }

        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $video->setUser($user);
            $em->persist($video);
            $em->flush();

            $this->addFlash('success', 'flash.video_created');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('video/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/video/{id}', name: 'app_video_show', requirements: ['id' => '\d+'])]
    public function show(Video $video): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();

        // Les vidéos premium ne sont pas accessibles (même via URL)
        // aux visiteurs et aux utilisateurs non vérifiés.
        if ($video->isPremiumVideo() && (!$user || !$user->isVerified())) {
            $this->addFlash('danger', 'flash.premium_denied');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('video/show.html.twig', [
            'video' => $video,
        ]);
    }

    #[Route('/video/{id}/edit', name: 'app_video_edit', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Video $video, Request $request, EntityManagerInterface $em): Response
    {
        if ($video->getUser() !== $this->getUser()) {
            $this->addFlash('danger', 'flash.owner_only');

            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'flash.video_updated');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('video/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/video/{id}/delete', name: 'app_video_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Video $video, Request $request, EntityManagerInterface $em): Response
    {
        if ($video->getUser() !== $this->getUser()) {
            $this->addFlash('danger', 'flash.owner_only');

            return $this->redirectToRoute('app_home');
        }

        if ($this->isCsrfTokenValid('delete' . $video->getId(), $request->request->get('_token'))) {
            $em->remove($video);
            $em->flush();
            $this->addFlash('success', 'flash.video_deleted');
        }

        return $this->redirectToRoute('app_home');
    }
}
