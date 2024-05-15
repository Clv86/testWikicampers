<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VehicleController extends AbstractController
{
    #[Route('/vehicle', name: 'vehicle.index', methods: ['GET'])]
    public function index(VehicleRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $vehicles = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/vehicle/index.html.twig', [
            'vehicles' => $vehicles
        ]);
    }

    #[Route('/vehicle/nouveau', 'vehicle.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ) : Response {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $vehicle = $form->getData();

            $manager->persist($vehicle);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'Véhicule créé !'
            );
            return $this->redirectToRoute('vehicle.index');
        }
        return $this->render('pages/vehicle/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
