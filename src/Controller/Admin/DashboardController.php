<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Manga;
use App\Entity\Product;
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
        yield MenuItem::linkToRoute('Back to the website', 'fas fa-home', 'home');
        yield MenuItem::linkToCrud('Products', 'fas fa-map-marker-alt', Product::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-map-marker-alt', Category::class);
        yield MenuItem::linkToCrud('Licences', 'fas fa-map-marker-alt', Manga::class);
    }
}
