<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AdminuserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\HeaderBag;


class AuthController extends ApiController
{
    /**
     * @param \Doctrine\ORM\EntityManagerInterface                                  $entityManager
     * @param \Symfony\Component\HttpFoundation\Request                             $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \JsonException
     * @Route("/admin/register", name="register", methods={"POST"})
     */
    public function register(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $request = json_decode($request->getContent(), true, 200, JSON_THROW_ON_ERROR);
        if (!isset($request['username']) || !isset($request['password']) || !isset($request['email']))
        {
            return $this->respondValidationError("Nieprawidłowa nazwa użytkownika hasło lub email");
        }

        $user = new User();

        $user->setEmail($request['email']);
        $user->setUsername($request['username']);
        $user->setPassword($passwordHasher->hashPassword($user,$request['password']));
        $entityManager->persist($user);
        $entityManager->flush();
        return new JsonResponse(sprintf('User %s successfully created', $user->getUsername()));
    }

    /**
     * @param \App\Repository\AdminuserRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return false|string|\Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/admin/delete/user/{id}", name="user_delete", methods={"DELETE"})
     */
    public function deleteUserOne(EntityManagerInterface $entityManager, AdminuserRepository $AdminuserRepository, int $id): Response
    {
        $user = $AdminuserRepository->find($id);
        if($user) {
            $data = [
                'status' => 404,
                'errors' => 'użytkownika nieznaleziony',
            ];
            return new JsonResponse($data, 404);
        }
        else
        {
            $entityManager->remove($user);
            $entityManager->flush();
            $data = [
                'status' => 200,
                'errors' => 'użytkownik usunięty',
            ];
            return new JsonResponse($data, 200);
        }
    }

    /**
     * @Route("/api", methods={"GET"})
     */
    public function handleGetApi(UserInterface $user)
    {
        $data = ['message' => 'Hello from ' . $user->getUsername()];

        return $this->json($data, 200);
    }
}

