<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Manga;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        $url = $routeBuilder->setController(ProductCrudController::class)->generateUrl();

           return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Alliance Manga');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour sur le site', 'fas fa-home', 'home');
        yield MenuItem::linkToCrud('Produits', 'fas fa-map-marker-alt', Product::class);
        yield MenuItem::linkToCrud('Licences', 'fas fa-map-marker-alt', Manga::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-map-marker-alt', User::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-map-marker-alt', Comment::class);
    }
}
