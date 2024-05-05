<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Form\ConsultationType;
use App\Repository\ConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ConsultationController extends AbstractController
{
    #[Route('/consultations', name: 'consultation_index', methods: ['GET'])]
    public function index(ConsultationRepository $consultationRepository): Response
    {
        $consultations = $consultationRepository->findAll();

        return $this->render('consultation/index.html.twig', [
            'consultations' => $consultations,
        ]);
    }

    #[Route('/consultation/new', name: 'consultation_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $consultation = new Consultation();

        $form = $this->createForm(ConsultationType::class, $consultation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($consultation);
            $entityManager->flush();

            return $this->redirectToRoute('consultation_index');
        }

        return $this->render('consultation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/consultation/{id}', name: 'consultation_show', methods: ['GET'])]
    public function show(ConsultationRepository $consultationRepository, int $id): Response
    {
        $consultation = $consultationRepository->find($id);

        if (!$consultation) {
            throw $this->createNotFoundException('Consultation not found');
        }

        return $this->render('consultation/show.html.twig', [
            'consultation' => $consultation,
        ]);
    }

    #[Route('/consultation/{id}/edit', name: 'consultation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, ConsultationRepository $consultationRepository, int $id): Response
    {
        $consultation = $consultationRepository->find($id);
    
        if (!$consultation) {
            throw $this->createNotFoundException('Consultation not found');
        }
    
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('consultation_index');
        }
    
        return $this->render('consultation/edit.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/consultation/{id}', name: 'consultation_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, ConsultationRepository $consultationRepository, int $id): Response
    {
        $consultation = $consultationRepository->find($id);
    
        if (!$consultation) {
            throw $this->createNotFoundException('Consultation not found');
        }
    
        if ($this->isCsrfTokenValid('delete'.$consultation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($consultation);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('consultation_index');
    }
}
