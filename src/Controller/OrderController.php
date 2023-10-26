<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Book;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(PersistenceManagerRegistry $doctrine): Response
    {
        // Retrieve all orders from the database
        $orders = $doctrine->getRepository(Order::class)->findAll();

        return $this->render('order/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/order/create', name: 'create_order')]
    public function createOrder(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            $this->addFlash('success', 'Order created successfully');

            return $this->redirectToRoute('app_order'); // Replace with your order listing route
        }

        return $this->render('order/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
