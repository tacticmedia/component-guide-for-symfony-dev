<?php

namespace App\Controller;

use App\Util\Slugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_list')]
    public function list(Request $request): Response
    {
        $page = max(1, (int) $request->get('page', 1));

        return $this->render('product/list.html.twig', ['page' => $page]);
    }

    #[Route('/products/{title}', name: 'product_show')]
    public function show(string $title): Response
    {
        return $this->redirectToRoute('product_list', ['q' => Slugger::slugify($title)]);
    }
}
