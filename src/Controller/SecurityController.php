<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/auth', name: 'security_controller')]
class SecurityController extends AbstractController
{
    #[Route('/register', name: 'register', methods: 'POST')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHaser, EntityManagerInterface $em) : Response {
        if(empty($email = $request->request->get('email')) || empty($password = $request->request->get('password'))){
            return new JsonResponse(['error' => 1, 'message' => 'Email and password are required']);
        }
        $user = new User();
        $user->setEmail($email);
        $hashedPassword = $passwordHaser->hashPassword(
            $user,
            $password
        );
        $user->setPassword($hashedPassword);
        $em->persist($user);
        $em->flush();
        return new Response(null,Response::HTTP_OK);
    }
}
