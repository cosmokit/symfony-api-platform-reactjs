<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony Api Platform Reactjs');
    }


    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Blog'),
            MenuItem::linkToCrud('Blog Posts', 'fa fa-file-text', BlogPost::class),

            MenuItem::section('User'),
            MenuItem::linkToCrud('User', 'fa fa-file-text', User::class),

//            MenuItem::section('Users'),
//            MenuItem::linkToCrud('Comments', 'fa fa-comment', Comment::class),
//            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
        ];
    }
}
