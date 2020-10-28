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
     * TODO: move "_" to basic name
     * @Route("/registration", name="_registration")
     */
    // TODO:  $em not use
    // TODO: $servie - what service? naming
    public function registration(EntityManagerInterface $em, Request $request, UserService $service): Response {
        // TODO no new line
        $form = $this->createForm(RegistrationFormType::class);

        $form->handleRequest($request);
        // TODO revert if
        if ($form->isSubmitted() && $form->isValid()) {
            // todo @VAR annotation
            $data = $form->getData();
            $service->createAndPersist($data['user_name'], $data['first_name'], $data['last_name'], $data['password']);;// todo double ;
            // TODO: move 'success' to some constant
            // TODO: read about Enum and create enum FlashTypesEnum
            $this->addFlash('success', 'User: ' . $data['user_name'] . ' Created!✅');
            return $this->redirect($this->generateUrl('front'));// todo return (new line before)
        }

        return $this->render('user/registration.html.twig', [
            'page_title' => 'Registration', //todo remove
            'form' => $form->createView()
        ]);
    }
}
