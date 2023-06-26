<?php

namespace App\Controller;

use Exception;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;
use App\Entity\Product;
use Symfony\Component\Uid\NilUuid;
use Symfony\Component\Uid\Uuid;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistr;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTime;
use Symfony\Component\Form\Extension\Core\Type\Faker;
use Symfony\Component\Form\Extension\Core\Type\DateTimeImmutable;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ProductController extends AbstractController
{

    /**
     * @param ProductRepository $ProductRepository
     *
     * @return JsonResponse
     * @Route("/get/produkty", name="get_all_product", methods={"GET"})
     */
    public function getAll(ProductRepository $ProductRepository): JsonResponse
    {
        $data = $ProductRepository->findAll(); //drobić standardowe wyjście
        return $this->json($data);
    }

    /**
     * @param \App\Repository\ProductRepository $ProductRepository
     * @param \App\Controller\Uuiidd            $id
     *
     * @return JsonResponse
     * @Route("/get/produkt/{id}", name="get_one_product", methods={"GET"})
     */
    public function getOne(int $id, ProductRepository $ProductRepository ): JsonResponse
    {
        $data = $ProductRepository->find($id);
        if ($data) {
            return $this->json($data); //drobić standardowe wyjście
        } else {
            return $this->json(["error" => "Post was not found by id:" . $id], 404);
        }
    }

    /**
     * @param Request $Request
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $ProductRepository
     *
     * @return false|string|\Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     * @Route("/auth/add/produkt", name="one_add", methods={"POST"})
     */
    public function addOne(Request $Request, EntityManagerInterface $entityManager, ProductRepository $ProductProductRepository)
    {
        try
        {
            $request = json_decode($Request->getContent(), true, 200, JSON_THROW_ON_ERROR);

            if(!isset($request) || !isset($request['name' ], $request['content'], $request['grupa']))
            {
                throw new \Exception();
		
            }

            $encoder = new JsonEncoder();
            $dateCallback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
                return $innerObject instanceof \DateTime ? $innerObject->format(\DateTime::ISO8601) : '';
            };
            $defaultContext = [
                AbstractNormalizer::CALLBACKS => [
                    'createdAt' => $dateCallback,
                ],
            ];
            $normalizer = new GetSetMethodNormalizer(null, null, null, null, null, $defaultContext);
            $serializer = new Serializer([$normalizer], [$encoder]);
            $product = new Product();
            $product->setName($request['name']);
            $product->setContent($request['content']);
            $product->setGrupa($request['grupa']);
            $product->setCreatedAt(new \DateTime('now'));
            $product->setUpdatedAt(new \DateTime('now'));
            $serializer->serialize($product, 'json');
            $entityManager->persist($product);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "rekord dodany z powodzeniem",
            ];
            return new JsonResponse($data,200);
        }
        catch (\Exception $e)
        {
            $data = [
                'status' => 422,
                'success' => "Dane niepoprawne",
            ];
	        $Response = new JsonResponse($data,422);
            $Response->send();
        }
    }

    /**
     * @param Request                $Request
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository      $ProductRepository
     * @param $id
     *
     * @return false|string|\Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     * @Route("/auth/update/produkt/{id}", name="all_update", methods={"PUT"})
     */
    public function updateAll(Request $Request, EntityManagerInterface $entityManager, ProductRepository $ProductRepository, int $id): JsonResponse
    {

        $produkt = $ProductRepository->find($id);
        if(!$produkt)
        {
            $data = [
                'status' => 404,
                'errors' => 'Produkt nie znaleziony',
            ];

            return new JsonResponse($data,404);
        }

        $request = json_decode($Request->getContent(), true, 200, JSON_THROW_ON_ERROR);

        $product = new Product();
        $product = $entityManager->getRepository(Product::class)->find($id);
        $product->setName($request['name']);
        $product->setContent($request['content']);
        $product->setGrupa($request['grupa']);
        $product->setUpdatedAt(new \DateTime('now'));
        $entityManager->flush();
        $data = [
            'status' => 200,
            'errors' => 'Produkt zaktualizowany z sukcesem',
        ];
        return new JsonResponse($data,200);

    }

    /**
     * @param Request                $Request
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository      $ProductRepository
     * @param $id
     *
     * @return false|string|\Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     * @Route("/auth/update/content/produkt/{id}", name="content_update", methods={"PUT"})
     */
    public function updateContent(Request $Request, EntityManagerInterface $entityManager, ProductRepository $ProductRepository, int $id): JsonResponse
    {
        try {
            $produkt = $ProductRepository->find($id);
            if(!$produkt)
            {
                $data = [
                    'status' => 404,
                    'errors' => 'Produkt nie znaleziony',
                ];

                return new JsonResponse($data,204);
            }

            $request = json_decode($Request->getContent(), true, 200, JSON_THROW_ON_ERROR);
            if(!isset($request) || !isset($request['content']))
            {
                throw new \Exception();
            }

            $product = new Product();
            $product = $entityManager->getRepository(Product::class)->find($id);
            $product->setContent($request['content']);
            $product->setUpdatedAt(new \DateTime('now'));
            $entityManager->flush();
            $data = [
                'status' => 200,
                'errors' => 'Produkt zaktualizowany z sukcesem',
            ];
            return new JsonResponse($data,200);
        }
        catch (\Exception $e)
        {
            $data = [
                'status' => 422,
                'errors' => 'Nieprawidłowe dane',
            ];
            return new JsonResponse($data,422);
        }
    }

    /**
     * @param Request                $Request
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository      $ProductRepository
     * @param $id
     *
     * @return false|string|\Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     * @Route("/auth/update/name/produkt/{id}", name="name_update", methods={"PUT"})
     */
    public function updateName(Request $Request, EntityManagerInterface $entityManager, ProductRepository $ProductRepository, int $id): JsonResponse
    {
        try
        {
            $produkt = $ProductRepository->find($id);
            if(!$produkt)
            {
                $data = [
                    'status' => 404,
                    'errors' => 'Produkt nie znaleziony',
                ];

                return new JsonResponse($data,204);
            }

            $request = json_decode($Request->getContent(), true, 200, JSON_THROW_ON_ERROR);
            if(!isset($request) || !isset($request['name']))
            {
                throw new \Exception();
            }

            $product = new Product();
            $product = $entityManager->getRepository(Product::class)->find($id);
            $product->setName($request['name']);
            $product->setUpdatedAt(new \DateTime('now'));
            $entityManager->flush();
            $data = [
                'status' => 200,
                'errors' => 'Produkt zaktualizowany z sukcesem',
            ];
            return new JsonResponse($data,200);
        }
        catch (\Exception $e)
        {
            $data = [
                'status' => 422,
                'errors' => 'Nieprawidłowe dane',
            ];
            return new JsonResponse($data,422);
        }
    }

    /**
     * @param Request                $Request
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository      $ProductRepository
     * @param $id
     *
     * @return false|string|\Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     * @Route("/auth/update/grupa/produkt/{id}", name="grupa_update", methods={"PUT"})
     */
    public function updateGrupa(Request $Request, EntityManagerInterface $entityManager, ProductRepository $ProductRepository, int $id): JsonResponse
    {
        try {
            $produkt = $ProductRepository->find($id);
            if(!$produkt)
            {
                $data = [
                    'status' => 404,
                    'errors' => 'Produkt nie znaleziony',
                ];

                return new JsonResponse($data,204);
            }

            $request = json_decode($Request->getContent(), true, 200, JSON_THROW_ON_ERROR);
            if(!isset($request) || !isset($request['grupa']))
            {
                throw new \Exception();
            }
            $product = new Product();
            $product = $entityManager->getRepository(Product::class)->find($id);
            $product->setGrupa($request['grupa']);
            $product->setUpdatedAt(new \DateTime('now'));
            $entityManager->flush();
            $data = [
                'status' => 200,
                'errors' => 'Produkt zaktualizowany z sukcesem',
            ];
            return new JsonResponse($data,200);
        }
        catch (\Exception $e)
        {
            $data = [
                'status' => 422,
                'errors' => 'Nieprawidłowe dane',
            ];
            return new JsonResponse($data,422);
        }
    }

    /**
     * @param ProductRepository $ProductRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return false|string|\Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/auth/delete/produkt/{id}", name="one_delete", methods={"DELETE"})
     */
    public function deleteOne(EntityManagerInterface $entityManager, ProductRepository $ProductRepository, int $id): JsonResponse
    {

        $produkt = $ProductRepository->find($id);
        if(!$produkt)
        {
            $data = [
                'status' => 404,
                'errors' => 'Produkt nie znaleziony',
            ];
            return new JsonResponse($data,204);

        }
        else
        {
            $entityManager->remove($produkt);
            $entityManager->flush();
            $data = [
                'status' => 200,
                'errors' => 'Produkt usunięty',
            ];
            return new JsonResponse($data, 200);
        }
    }
}
