<?php

namespace Bundle\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BundleAdminBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
