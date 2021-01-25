<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends AbstractController
{
    /**
     * @param UserRepository $userRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/user", name="user")
     */
    public function index(UserRepository $userRepository)
    {
        return $this->render('user/index.html.twig', [
           'users' => $userRepository->findAll()
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="user_edit")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_REDACTOR')")
     */
    public function edit(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, User $user)
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user');
    }


}