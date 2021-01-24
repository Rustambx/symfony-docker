<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     */
    public function edit(Request $request, User $user, RoleRepository $roleRepository)
    {
        $roles = $roleRepository->findAll();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->get('roles');
            $role = $roleRepository->find($data);
            dd($role);
            $user->setRoles($role);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'roles' => $roles,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete()
    {

    }


}