<?php

namespace App\Controller;

use App\Util\HtmlCleaner;
use App\Util\UuidGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class CommentController extends AbstractController
{
    #[Route('/comments', name: 'comment_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $body = HtmlCleaner::cleanComment((string) $request->request->get('body', ''));

        return $this->json(['id' => UuidGenerator::v4(), 'body' => $body], 201);
    }
}
