<?php

namespace App\Controller;

use App\Entity\Rdv;
use App\Form\RdvType;
use App\Repository\RdvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class RdvController extends AbstractController
{
    #[Route('/rdvs', name: 'rdv_index', methods: ['GET'])]
    public function index(RdvRepository $rdvRepository): Response
    {
        $rdvs = $rdvRepository->findAll();

        return $this->render('rdv/index.html.twig', [
            'rdvs' => $rdvs,
        ]);
    }

    #[Route('/rdv/new', name: 'rdv_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rdv = new Rdv();

        $form = $this->createForm(RdvType::class, $rdv);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rdv);
            $entityManager->flush();

            return $this->redirectToRoute('rdv_index');
        }

        return $this->render('rdv/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/rdv/{id}', name: 'rdv_show', methods: ['GET'])]
    public function show(RdvRepository $rdvRepository, int $id): Response
    {
        $rdv = $rdvRepository->find($id);

        if (!$rdv) {
            throw $this->createNotFoundException('RDV not found');
        }

        return $this->render('rdv/show.html.twig', [
            'rdv' => $rdv,
        ]);
    }

    #[Route('/rdv/{id}/edit', name: 'rdv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, RdvRepository $rdvRepository, int $id): Response
    {
        $rdv = $rdvRepository->find($id);

        if (!$rdv) {
            throw $this->createNotFoundException('RDV not found');
        }

        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('rdv_index');
        }

        return $this->render('rdv/edit.html.twig', [
            'rdv' => $rdv,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/rdv/{id}', name: 'rdv_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, RdvRepository $rdvRepository, int $id): Response
    {
        $rdv = $rdvRepository->find($id);

        if (!$rdv) {
            throw $this->createNotFoundException('RDV not found');
        }

        if ($this->isCsrfTokenValid('delete'.$rdv->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rdv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rdv_index');
    }
}
