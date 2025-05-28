<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/products')]
class ApiProductController extends AbstractController
{

    private array $products = [
        1 => ['id' => 1, 'name'=> 'Clavier', 'price' => 39.99],
        2 => ['id' => 2, 'name'=> 'Souris', 'price' => 19.99],
    ];

    #[Route('', name: 'get_products', methods: ['GET'])]
    public function list(): JsonResponse{
        return new JsonResponse(array_values($this->products), Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'get_product', methods: ['GET'])]
    public function get(int $id): JsonResponse{
        return isset($this->products[$id])
            ? new JsonResponse($this->products[$id], Response::HTTP_OK)
            : new JsonResponse(['error' => 'Produit non trouvé'], Response::HTTP_NOT_FOUND);

    }

    #[Route('', name: 'add_product', methods: ['POST'])]
    public function add(Request $request): JsonResponse{
        $data = json_decode($request -> getContent(), true);
        $data['id'] = rand(100,900);

        return new JsonResponse([
            'message' => 'Produit ajouté',
            'produit' => $data],
            Response::HTTP_CREATED);

    }



    #[Route('/{id}', name: 'delete_product', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse{
        return new JsonResponse([
            'message' => "Produit $id supprimé"
        ], Response::HTTP_NO_CONTENT);
    }

    #[Route('/{id}', name: 'update_product', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse{

        $data = json_decode ($request -> getContent(), true);
        $data['id'] = $id;

        return new JsonResponse([
            'message' => "Produit $id mis à jour",
            'produit' => $data
        ], Response::HTTP_OK);


    }





}
