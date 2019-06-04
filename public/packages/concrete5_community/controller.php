<?php

namespace Concrete\Package\Concrete5Community;

use Concrete\Core\Package\Package;

class Controller extends Package
{

    protected $pkgHandle = 'concrete5_community';
    protected $appVersionRequired = '8.3';
    protected $pkgVersion = '0.80';
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
        
    }
}