<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
class PatientController extends AbstractController
{
    #[Route('/patients', name: 'patient_index', methods: ['GET'])]
    public function index(PatientRepository $patientRepository): Response
    {
        $patients = $patientRepository->findAll();

        return $this->render('patient/index.html.twig', [
            'patients' => $patients,
        ]);
    }

    #[Route('/patient/new', name: 'patient_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $patient = new Patient();

        $form = $this->createForm(PatientType::class, $patient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('patient_index');
        }

        return $this->render('patient/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/patient/{id}', name: 'patient_show', methods: ['GET'])]
    public function show(PatientRepository $patientRepository, int $id): Response
    {
        $patient = $patientRepository->find($id);

        if (!$patient) {
            throw $this->createNotFoundException('Patient not found');
        }

        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/patient/{id}/edit', name: 'patient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, PatientRepository $patientRepository, int $id): Response
    {
        $patient = $patientRepository->find($id);
    
        if (!$patient) {
            throw $this->createNotFoundException('Patient not found');
        }
    
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('patient_index');
        }
    
        return $this->render('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/patient/{id}', name: 'patient_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, PatientRepository $patientRepository, int $id): Response
    {
        $patient = $patientRepository->find($id);
    
        if (!$patient) {
            throw $this->createNotFoundException('Patient not found');
        }
    
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $entityManager->remove($patient);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('patient_index');
    }
    
}
