<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiEventController extends AbstractController
{
    private array $events = [
        1 => [
            'id' => 1,
            'title' => 'Concert Jazz',
            'location' => 'Paris',
            'date' => '2025-06-15 20:00:00',
            'isPublic' => true,
        ],
        2 => [
            'id' => 2,
            'title' => 'Atelier Peinture',
            'location' => 'Lyon',
            'date' => '2025-07-10 14:00:00',
            'isPublic' => false,
        ],
        3 => [
            'id' => 3,
            'title' => 'Conférence Tech',
            'location' => 'Marseille',
            'date' => '2025-06-30 09:30:00',
            'isPublic' => true,
        ],
    ];

    #[Route('/api/events', name: 'api_events_list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $location = $request->query->get('location');
        $filtered = $this->events;

        if ($location) {
            $filtered = array_filter($filtered, fn($event) => $event['location'] === $location);
        }

        return $this->json(array_values($filtered));
    }

    #[Route('/api/events/public', name: 'api_events_public', methods: ['GET'])]
    public function listPublic(): JsonResponse
    {
        $public = array_filter($this->events, fn($event) => $event['isPublic']);
        return $this->json(array_values($public));
    }

    #[Route('/api/events/{id}', name: 'api_events_detail', methods: ['GET'])]
    public function detail(int $id): JsonResponse
    {
        if (!isset($this->events[$id])) {
            return $this->json(['error' => 'Événement non trouvé'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($this->events[$id]);
    }

    #[Route('/api/events', name: 'api_events_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['title'], $data['location'], $data['date'], $data['isPublic'])) {
            return $this->json(['error' => 'Données incomplètes'], Response::HTTP_BAD_REQUEST);
        }

        $newId = max(array_keys($this->events)) + 1;

        $newEvent = [
            'id' => $newId,
            'title' => $data['title'],
            'location' => $data['location'],
            'date' => $data['date'],
            'isPublic' => (bool)$data['isPublic'],
        ];

        $this->events[$newId] = $newEvent;

        return $this->json($newEvent, Response::HTTP_CREATED);
    }

    #[Route('/api/events/{id}', name: 'api_events_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        if (!isset($this->events[$id])) {
            return $this->json(['error' => 'Événement non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        foreach (['title', 'location', 'date', 'isPublic'] as $field) {
            if (isset($data[$field])) {
                $this->events[$id][$field] = $data[$field];
            }
        }

        return $this->json($this->events[$id]);
    }

    #[Route('/api/events/{id}', name: 'api_events_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        if (!isset($this->events[$id])) {
            return $this->json(['error' => 'Événement non trouvé'], Response::HTTP_NOT_FOUND);
        }

        unset($this->events[$id]);

        return $this->json(['message' => "Événement $id supprimé avec succès."]);
    }
}
