<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;


use App\Entity\Location;
use App\Entity\Rack;
use App\Entity\Device;
use App\Entity\Reservation;
use App\Entity\DeviceGroup;
use App\Entity\User;
use App\Entity\Project;
use App\Entity\Address;
use App\Entity\Network;

use App\Repository\LocationRepository;

class DashboardController extends AbstractDashboardController
{


    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }


    public function configureAssets(): Assets
    {
        return Assets::new()->addJsFile('https://code.jquery.com/jquery-3.6.0.min.js');
    }




    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        // return $this->redirect($adminUrlGenerator->setController(LocationCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //

        $locations = $this->locationRepository
            ->findAll();



        return $this->render('dashboard.html.twig', [
            'locations' => $locations,
        ]);
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_DETAIL, Action::EDIT, static function (Action $action) {
                return $action->setIcon('fa fa-edit');
            })
            ->update(Crud::PAGE_DETAIL, Action::INDEX, static function (Action $action) {
                return $action->setIcon('fa fa-list');
            })
            ->update(Crud::PAGE_INDEX, Action::NEW, static function (Action $action) {
                return $action->setIcon('fa fa-plus');
            });
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Open ipmi')
            ->setFaviconPath('favicon.svg')
            ->generateRelativeUrls();
            //->renderSidebarMinimized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fas fa-tachometer');
        yield MenuItem::linkToCrud('Reservations', 'fas fa-book', Reservation::class);



        yield MenuItem::section('Assets');
        yield MenuItem::linkToCrud('Racks', 'fas fa-server', Rack::class);
        yield MenuItem::linkToCrud('Devices', 'fas fa-desktop', Device::class);
        yield MenuItem::linkToCrud('Device Group', 'fas fa-object-group', DeviceGroup::class);

        yield MenuItem::section('Networking');
        yield MenuItem::linkToCrud('Networks', 'fas fa-sitemap', Network::class);
        yield MenuItem::linkToCrud('IP Addresses', 'fas fa-arrows-h', Address::class);

        yield MenuItem::section('Administration');
        yield MenuItem::linkToCrud('Projects', 'fas fa-cubes', Project::class);
        yield MenuItem::linkToCrud('Locations', 'fas fa-globe', Location::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getFirstName())
            // use this method if you don't want to display the name of the user
            ->displayUserName(true)

            // you can return an URL with the avatar image
            //->setAvatarUrl('https://...')
            //->setAvatarUrl($user->getProfileImageUrl())
            // use this method if you don't want to display the user image
            //->displayUserAvatar(false)
            // you can also pass an email address to use gravatar's service
            ->setGravatarEmail($user->getEmail())

            // you can use any type of menu item, except submenus
            ->addMenuItems([
                //MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
                //MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
                MenuItem::section(),
                MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }
}
