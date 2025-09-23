<?php

namespace Kaliop\IbexaMigrationBundle\Core\Process;

use Symfony\Component\Process\Process as BaseProcess;

/**
 * Allow to force Symfony Process objects to trust that php has been compiled with --enable-sigchild even when the
 * options used to compile php are not visible to phpinfo, such as on Debian/Ubuntu
 */
class Process extends BaseProcess
{
    static $forceSigchildEnabled = null;

    public static function forceSigchildEnabled($force): void
    {
        self::$forceSigchildEnabled = (bool) $force;
    }

    protected function isSigchildEnabled(): bool
    {
        if (null !== self::$forceSigchildEnabled) {
            return self::$forceSigchildEnabled;
        }

        return parent::isSigchildEnabled();
    }
}
