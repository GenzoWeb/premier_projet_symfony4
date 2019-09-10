<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/superAdmin")
 */
class AdminRoleManagementController extends AbstractController
{
    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/role", name="admin.role.user")
     */
    public function userManagement()
    {
        $users = $this->repo->findAll();

        return $this->render('admin/user/role.user.html.twig', [
            'users' => $users,
            'current_menu' => 'users'
        ]);

       
    }

    /**
     * @Route("/role/{id}", name="admin.user.edit")
     */
    public function userEdit(User $user, Request $request, ObjectManager $manager)
    {
        if( $user->getRoles()[0] == "ROLE_ADMIN")
        {
            $choice1 = "ROLE_USER";
            $choice2 = "ROLE_SUPER_ADMIN";
        }
        if( $user->getRoles()[0] == "ROLE_USER")
        {
            $choice1 = "ROLE_ADMIN";
            $choice2 = "ROLE_SUPER_ADMIN";
        }
        if( $user->getRoles()[0] == "ROLE_SUPER_ADMIN")
        {
            $choice1 = "ROLE_USER";
            $choice2 = "ROLE_ADMIN";
        }
        
        if($request->request->count() > 0)
        {
            if($request->request->get('roles') == "ROLE_USER" || $request->request->get('roles') == "ROLE_ADMIN" || $request->request->get('roles') == "ROLE_SUPER_ADMIN")
            {
                $user->setRoles([$request->request->get('roles')]);
                
                $manager->flush();
                $this->addflash('success', $user->getUsername() . ' a été modifié avec succés');
                return $this->redirectToRoute('admin.role.user');
            }
        }

        return $this->render('admin/user/edit.user.html.twig', [
            'user' => $user,
            'choice1' => $choice1,
            'choice2' => $choice2,
            'current_menu' => 'users'
        ]);

       
    }
}