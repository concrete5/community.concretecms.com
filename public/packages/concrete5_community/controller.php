<?php

namespace Concrete\Package\Concrete5Community;

use Concrete\Core\Database\EntityManager\Provider\ProviderAggregateInterface;
use Concrete\Core\Database\EntityManager\Provider\ProviderInterface;
use Concrete\Core\Database\EntityManager\Provider\StandardPackageProvider;
use Concrete\Core\Filesystem\ElementManager;
use Concrete\Core\Package\Package;
use Concrete\Core\Page\Theme\ThemeRouteCollection;
use Concrete\Core\Routing\Router;
use Concrete5\Community\RouteList;
use Concrete5\Community\ServiceProvider;

class Controller extends Package implements ProviderAggregateInterface
{

    protected $pkgHandle = 'concrete5_community';
    protected $appVersionRequired = '8.3';
    protected $pkgVersion = '0.82';
    protected $pkgAutoloaderMapCoreExtensions = true;
    protected $pkgAutoloaderRegistries = array(
        'src' => '\PortlandLabs\Concrete5\Community'
    );

    public function getPackageDescription()
    {
        return t("The concrete5.org community, user portal, karma machine and more.");
    }

    public function getPackageName()
    {
        return t("concrete5.org Community");
    }

    public function install()
    {
        parent::install();
        $this->installContentFile('data.xml');
        $this->installContentFile('content.xml');
    }

    public function upgrade()
    {
        parent::upgrade();
        $this->installContentFile('data.xml');
    }

    public function on_start()
    {
        $collection = $this->app->make(ThemeRouteCollection::class);
        /**
         * @var $collection ThemeRouteCollection
         */
        $collection->setThemeByRoute('/account/*', 'concrete5', 'account.php');
        $collection->setThemeByRoute('/login', 'concrete5');
        $collection->setThemeByRoute('/register', 'concrete5');

        // Set up service provider
        $this->app->make(ServiceProvider::class)->register();
    }

    /**
     * @return ProviderInterface
     */
    public function getEntityManagerProvider()
    {
        return new StandardPackageProvider($this->app, $this, [
            '/src/Entity' => 'Concrete5\\Community\\Entity\\'
        ]);
    }
}
