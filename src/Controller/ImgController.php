<?php

namespace App\Controller;

use App\Repository\ImgRepository;
use Faker\Provider\Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductRepository;
use App\Entity\Img;
use Symfony\Bridge\Doctrine\ManagerRegistr;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ImgController extends AbstractController
{
    /**
     * @param ImgRepository $ImgRepository
     *
     * @return JsonResponse
     * @Route("/get/img", name="get_all_img" method={"GET"})
     */
    public function getAllImg(ImgRepository $ImgRepository): JsonResponse
    {
        $data = $ImgRepository->findAll();
        return $this->json($data);
    }

    /**
     * @param \App\Repository\ImgRepository $ImgRepository
     * @param \App\Controller\Uuiidd            $id
     *
     * @return JsonResponse
     * @return("/get/img/{id}", name="get_one_img", methods={"GET"})
     */
    public function getOneImg(int $id, ImgRepository $ImgRepository ): JsonResponse
    {
        $data = $ImgRepository->find($id);
        if ($data) {
            return $this->json($data);
        } else {
            return $this->json(["error" => "nie znaleziono zdjęcia z id: " . $id], 404);
        }
    }

    /**
     * @param Request $Request
     * @param EntityManagerInterface $entityManager
     * @param ImgRepository $ImgRepository
     *
     * @return false|string|\Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     * @Route("/auth/add/img", name="one_add_img", methods={"POST"})
     */
    public function addOneImg(Request $Request, EntityManagerInterface $entityManager, ImgRepository $ImgRepository)
    {
        try
        {
            $request = json_decode($Request->getContent(), true, 200, JSON_THROW_ON_ERROR);

            if(!isset($request) || !isset($request['adresIMG'], $request['nazwa'], $request['opisy']))
            {
                throw new \Exception();

            }

            $encoder = new JsonEncoder();
            //$dateCallback = function ($innerObject, $outerObject, ) {
                //return $innerObject instanceof \DateTime ? $innerObject->format(\DateTime::ISO8601) : '';
            //}
            //$defaultContext = [
                //AbstractNormalizer::CALLBACKS => [
                    //'createdAt' => $dateCallback,
                //],
            //];
            $normalizer = new GetSetMethodNormalizer(null, null, null, null, null, $defaultContext);
            $serializer = new Serializer([$normalizer], [$encoder]);
            $img = new Img();
            $img->setNazwa($request['nazwa']);
            $img->setOpisy($request['opisy']);
            $img->setAdresse($request['adresIMG']);
            $serializer->serialize($img, 'json');
            $entityManager->persist($img);
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
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ImgRepository $ImgRepository
     * @param $id
     *
     * @return false|string|\Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     * @Route("/auth/update/img/{id}", name="all_update_img", methods={"PUT"})
     */
    public function updateAllImg(Request $request, EntityManagerInterface $entityManager, ImgRepository $ImgRepository, int $id): JsonResponse
    {
        $img = $ImgRepository->find($id);
        if (!$img)
        {
            $data = [
                'status' => 404,
                'errors' => 'Produkt nie znaleziony',
            ];

            return new JsonResponse($data,404);
        }

        $request = json_decode($Request->getContent(), true, 200, JSON_THROW_ON_ERROR);

        $img = new Img();
        $img = $entityManager->getRepository(Img::class)->find($id);
        $img->getNazwa($request['nazwa']);
        $img->setOpisy($request['opisy']);
        $img->setAdresIMG($request['adresIMG']);
        $entityManager->flush();
        $data = [
            'status' => 200,
            'errors' => 'Produkt zaktualizowany z sukcesem',
        ];
        return new JsonResponse($data,200);

    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ImgRepository $ImgRepository
     * @param $id
     *
     * @return false|string|\Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     * @Route("/auth/update/nazwa/img/{id}", name="nazwa_update_img", methods={"PUT"})
     */
    public function updateNazwaImg(Request $request, EntityManagerInterface $entityManager, ImgRepository $ImgRepository, int $id): JsonResponse
    {
        try
        {
            $img = $ImgRepository->find($id);
            if (!$img)
            {
                $data = [
                    'status' => 404,
                    'errors' => 'Produkt nie znaleziony',
                ];

                return new JsonResponse($data,204);
            }

            $request = json_decode($Request->getContent(), true, 200, JSON_THROW_ON_ERROR);
            if(!isset($request) || !isset($request['nazwa']))
            {
                throw new \Exception();
            }

            $img = new Img();
            $img = $entityManager->getRepository(Img::class)->find($id);
            $img->setName($request['nazwa']);
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
         * @param Request $request
         * @param EntityManagerInterface $entityManager
         * @param ImgRepository $ImgRepository
         * @param $id
         *
         * @return false|string|\Symfony\Component\HttpFoundation\JsonResponse
         * @throws \Exception
         * @Route("/auth/update/opisy/img/{id}", name="opisy_update_img", methods={"PUT"})
         */
        public function updateOpisyImg(Request $request, EntityManagerInterface $entityManager, ImgRepository $ImgRepository, int $id): JsonResponse
        {
            try
            {
                $img = $ImgRepository->find($id);
                if(!$img)
                {
                    $data = [
                        'status' => 404,
                        'errors' => 'Produkt nie znaleziony',
                    ];

                    return new JsonResponse($data,204);
                }

                $request = json_decode($Request->getContent(), true, 200, JSON_THROW_ON_ERROR);
                if(!isset($request) || !isset($request['opisy']))
                {
                    throw new \Exception();
                }

                $img = new Img();
                $img = $entityManager->getRepository(Img::class)->find($id);
                $img->setOpis($request['opisy']);
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
}
