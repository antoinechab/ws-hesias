<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    public function __construct(private UserRepository $userRepository)
    {

    }


    #[Route("/{id}/profile",name: "user_get_profile")]
    public function getProfile(){

        return $this->userRepository->findAll();
    }

    #[Route("/{id}/profile/update",name: "user_update_profile")]
    public function updateProfile(User $user, Request $request){
        //todo update here
        return $this->userRepository->findOneBy($user->getId());
    }
}
