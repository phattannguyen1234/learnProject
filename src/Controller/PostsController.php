<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostsController extends AbstractController
{
    #[Route('/posts', name: 'app_posts')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PostsController.php',
        ]);
    }

    #[Route('/posts/overview', name: 'app_overview')]
    public function overviewAction(): Response
    {
        return $this->json([
            'num_items' => 2,
            'total' => 10,
        ]);
    }

    
    #[Route('/posts/all', methods: ['GET'], name: 'all_posts')]
    public function getAll(): Response
    {
        return $this->json(
            [
                'method' => 'GET',
                'function' => 'getAll'
            ]
        );
    }

    #[Route('/posts/create', methods: ['POST'], name:'add_posts')]
    public function addItem(): Response
    {
        return $this->json(
            [
                'method' => 'POST',
                'function' => 'add_item'
            ]
        );
    }

    #[Route('/posts/{id}', methods: ['GET'], name: 'post_details')]
    public function detailsPost($id): Response
    {
        return $this->json(
            [
                'method' => 'GET',
                'function' => 'add_item',
                'params' => (int)$id
            ]
        );
    }

    #[Route('/posts/add', methods: ['POST'], name: 'create_post')]
    public function createPost(Request $request): Response
    {
        $id = $request->request->get("id");
        $post = $request->request->get("post");

        return $this->json([
            'method' => 'POST',
            'function' => 'createPost',
            'id' => (int)$id,
            'post' => $post
        ]);
    }
}