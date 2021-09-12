<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Manga;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
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
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(MangaCrudController::class)->generateUrl());
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img style="width: 140px" src="img/logo/logo_rapport_stage.png" />');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linkToRoute('Retour sur le site', 'fas fa-home',  'account');
        yield MenuItem::section('Nos catégories');
        yield MenuItem::linkToCrud('Licences', 'fab fa-mandalorian', Manga::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-sitemap', Category::class);
        yield MenuItem::section('Nos produits');
        yield MenuItem::linkToCrud('Produits', 'fab fa-product-hunt', Product::class);
        yield MenuItem::section('Gestion des commentaires');
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comments', Comment::class);
        yield MenuItem::section('Gestion des utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user-alt', User::class);
        yield MenuItem::section('Gestion des commandes');
        yield MenuItem::linkToCrud('Commandes', 'fas fa-shopping-basket', Purchase::class);
        yield MenuItem::linkToCrud('Détail des commandes', 'fas fa-folder-open', PurchaseItem::class);
    }
}
