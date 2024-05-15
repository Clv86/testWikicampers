<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Form\AvailabilityType;
use App\Form\SearchAvailabilitiesType;
use App\Repository\AvailabilityRepository;
use App\Repository\VehicleRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class AvailabilityController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('availability', name: 'availability.index', methods: ['GET'])]
    public function index(AvailabilityRepository $repository, PaginatorInterface $paginator, Request $request) : Response {
        $availabilities = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/availability/index.html.twig', [
            'availabilities' => $availabilities
        ]);
    }

    #[Route('/availability/search', name: 'availability.search', methods: ['GET', 'POST'])]
    public function search(AvailabilityRepository $availabilityRepository,
        Request $request,
        SessionInterface $session
        ) : Response {

        $form = $this->createForm(SearchAvailabilitiesType::class);
        $form->handleRequest(($request));


        $availabilities = [];
        $vehicles = [];
        $allVehicles = [];
        $number = 0;

        if($form->isSubmitted()){
            $formStartDate = $form->get('start_date')->getData();
            $formEndDate = $form->get('end_date')->getData();
            
            $startDate = new DateTimeImmutable($formStartDate->format('Y-m-d'));
            $endDate = new DateTimeImmutable($formEndDate->format('Y-m-d'));
            
            $qb = $availabilityRepository->findByDateRange($startDate, $endDate);
            $availabilities = $qb->getQuery()->getResult();

            foreach ($availabilities as $availability){
                $vehicle = $availability->getVehicle();
                $vehicles[$vehicle->getId()] = $vehicle;
                $number++;
            }
            
            $allVehicles = array_values($vehicles);
            $vehicleIds = [];
            
            foreach ($allVehicles as $vehicle) {
                $vehicleIds[] = $vehicle->getId();
            }

            $session->set('search_data', [
                'vehicleIds' => $vehicleIds,
                'number' => $number,
            ]);
            return $this->redirectToRoute('availability.results', [
            ]);
            }

        return $this->render('pages/availability/search.html.twig', [
           'form' => $form->createView(),
           'allVehicles' => $allVehicles, //peut-être inutile
           'number' => $number,
        ]);
    }

    #[Route('/availability/results', name: 'availability.results', methods: ['GET'])]
    public function test(PaginatorInterface $paginator, SessionInterface $session, VehicleRepository $repository, Request $request) : Response {
        $searchData = $session->get('search_data', []);
        $vehicleIds = $searchData['vehicleIds'] ?? [];
        $vehicles = $paginator->paginate(
            $repository->findby(['id' => $vehicleIds]),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/availability/results.html.twig', [
         'vehicleIds' => $vehicleIds,
         'vehicles' => $vehicles
        ]);
    }

    #[Route('/availability/nouveau', name: 'availability.new')]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response
    {
        $availability = new Availability();

        $form = $this->createForm(AvailabilityType::class, $availability);

        $form->handleRequest(($request));
        if($form->isSubmitted() && $form->isValid()){
            $availability = $form->getData();

            $manager->persist($availability);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'Disponibilité créée !'
            );
            return $this->redirectToRoute('vehicle.index');
        }

        return $this->render('pages/availability/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/availability/edition/{id}', 'availability.edit', methods: ['GET', 'POST'])]
    public function edit(Availability $availability,
        Request $request,
        EntityManagerInterface $manager
        ): Response
    {
        $form = $this->createForm(AvailabilityType::class, $availability);
        
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $availability = $form->getData();
            
                $manager->persist($availability);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Votre disponibilité a été modifiée !'
                );

                return $this->redirectToRoute('availability.index');
            }
        return $this->render('pages/availability/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/availability/suppression/{id}', 'availability.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Availability $availability) : Response 
    {
        $manager->remove($availability);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre disponibilité a été supprimé !'
        );
        return $this->redirectToRoute('availability.index');
    }
}
