<?php

namespace Xgold\Command;

use Composer\Script\Event;


/**
 *
 */
class TestCmd
{




    public static function postPackageInstall(Event $event) {
        echo "debug....";

        $installedPackage = $event->getOperation()->getPackage();

        var_dump($installedPackage);
    }
}
