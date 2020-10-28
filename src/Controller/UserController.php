<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\User\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserService;

/**
 * @Route("/user", name="user")
 */
class UserController extends AbstractController {
    /**
     * @Route("/registration", name="_registration")
     */
    public function registration(EntityManagerInterface $em, Request $request, UserService $service): Response {

        $form = $this->createForm(RegistrationFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $service->createAndPersist($data['user_name'], $data['first_name'], $data['last_name'], $data['password']);;
            $this->addFlash('success', 'User: ' . $data['user_name'] . ' Created!✅');
            return $this->redirect($this->generateUrl('front'));
        }

        return $this->render('user/registration.html.twig', [
            'page_title' => 'Registration',
            'form' => $form->createView()
        ]);
    }
}
