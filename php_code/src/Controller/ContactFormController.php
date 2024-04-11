<?php

namespace App\Controller;

use App\Entity\ContactForm;
use App\Repository\ContactFormRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactFormController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager)
    {
    }

    #[Route('/contactforms', name: 'contact_form_list', methods: ['GET'])]
    public function getContactForms(ContactFormRepository $repository): JsonResponse
    {
//        xdebug_info();
        return $this->json($repository->findAll());
    }

    #[Route('/contactform/{id}', name: 'contact_form_update', methods: ['PUT', 'PATCH'])]
    public function updateContactForm(Request $request, int $id, ContactFormRepository $repository): JsonResponse
    {
        $contactForm = $repository->find($id);
        if (!$contactForm) {
            return $this->json('No contact form data for id '.$id, 404);
        }

        $params = $request->getPayload()->all();
        if (!$this->validateContactFormData($params)) {
            return $this->json([
                'success' => false,
                'message' => 'Niestety, przy próbie zapisu wystąpiły błędy.',
            ]);
        }

        $contactForm->setName($params['name']);
        $contactForm->setSurName($params['surname']);
        $contactForm->setEmail($params['email']);
        $contactForm->setContents($params['contents']);

        $this->entityManager->persist($contactForm);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Dane z formularza zostały poprawnie zapisane!',
            'id' => $contactForm->getId(),
            'name' => $contactForm->getName(),
            'surname' => $contactForm->getSurname(),
            'email' => $contactForm->getEmail(),
            'contents' => $contactForm->getContents()
        ]);
    }


    #[Route('/contactform/{id}', name: 'contact_form_show', methods: ['GET'])]
    public function getContactForm(ContactForm $contactForm): JsonResponse
    {
        return $this->json($contactForm);
    }

    #[Route('/contactform/{id}', name: 'contact_form_show', methods: ['DELETE'])]
    public function deleteContactForm(Request $request, int $id, ContactFormRepository $repository): JsonResponse
    {
        $contactForm = $repository->find($id);
        if (!$contactForm) {
            return $this->json('No contact form data for id '.$id, 404);
        }

        $this->entityManager->remove($this->entityManager->getReference(ContactForm::class, $id));
        $this->entityManager->flush();

        return $this->json('Deleted a contact form data successfully with id ' . $id);
    }
    #[Route('/contacts', name: 'contacts', methods: ['GET'])]
    public function getContacts(): JsonResponse
    {
        return $this->json([
            'success' => true,
            'message' => 'Endpoint testowy, brak danych.',
        ]);
    }

    #[Route('/contactform', name: 'create_contact_form', methods: ['POST'])]
    public function createContactForm(Request $request): JsonResponse
    {
        $params = $request->getPayload()->all();
        if (!$this->validateContactFormData($params)) {
            return $this->json([
                'success' => false,
                'message' => 'Niestety, przy próbie zapisu wystąpiły błędy.',
            ]);
        }

        $contactForm = $this->saveContactFormData($params);
        return $this->json([
            'message' => 'Dane z formularza zostały poprawnie zapisane!',
            'id' => $contactForm->getId(),
            'name' => $contactForm->getName(), 
            'surname' => $contactForm->getSurname(), 
            'email' => $contactForm->getEmail(), 
            'contents' => $contactForm->getContents()
        ]);
    }

    protected function validateContactFormData(array $params): bool
    {
        if (empty($params)) {
            return false;
        }
        foreach (['name', 'surname', 'email', 'contents'] as $key) {
            if (!array_key_exists('name', $params) || empty($params[$key])) {
                return false;
            }
        }
        if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    protected function saveContactFormData($params) 
    {
        $contactForm = new ContactForm();
        $contactForm->setName($params['name']);
        $contactForm->setSurName($params['surname']);
        $contactForm->setEmail($params['email']);
        $contactForm->setContents($params['contents']);

        $this->entityManager->persist($contactForm);
        $this->entityManager->flush();

        return $contactForm;
    }
}
