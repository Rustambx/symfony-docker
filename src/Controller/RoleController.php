<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\PostType;
use App\Form\RoleFormType;
use App\Repository\RoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{
    /**
     * @param RoleRepository $roleRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/roles", name="role")
     */
    public function index(RoleRepository $roleRepository)
    {
        return $this->render('role/index.html.twig', [
           'roles' => $roleRepository->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/roles/create", name="role_create")
     */
    public function create(Request $request)
    {
        $role = new Role();
        $form = $this->createForm(RoleFormType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($role);
            $entityManager->flush();

            return $this->redirectToRoute('role');
        }

        return $this->render('role/create.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/role/edit/{id}", name="role_edit")
     */
    public function edit(Request $request, Role $role)
    {
        $form = $this->createForm(RoleFormType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('role');
        }

        return $this->render('role/edit.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/roles/delete/{id}", name="role_delete", methods={"DELETE"})
     */
    public function delete(Request $request,Role $role)
    {
        if ($this->isCsrfTokenValid('delete'.$role->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($role);
            $entityManager->flush();
        }

        return $this->redirectToRoute('role');
    }
}