<?php
/**
 * Test suite for PHP_CompatInfo
 *
 * PHP version 5
 *
 * @category PHP
 * @package  PHP_CompatInfo
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version  CVS: $Id: AllTests.php,v 1.4 2008/07/22 20:27:11 farell Exp $
 * @link     http://pear.php.net/package/PHP_CompatInfo
 * @since    File available since Release 1.6.0
 */

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'PHP_CompatInfo_AllTests::main');
}

require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

chdir(dirname(__FILE__));

require_once 'PEAR/Config.php';
require_once 'PHP_CompatInfo_TestSuite_Standard.php';
require_once 'PHP_CompatInfo_TestSuite_Bugs.php';

/**
 * Class for running all test suites for PHP_CompatInfo package.
 *
 * @category PHP
 * @package  PHP_CompatInfo
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/PHP_CompatInfo
 * @since    File available since Release 1.6.0
 */

class PHP_CompatInfo_AllTests
{
    /**
     * Runs the test suite.
     *
     * @return void
     */
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    /**
     * Check if a package is installed
     *
     * Simple function to check if a package is installed under user
     * or system PEAR installation. Minimal version and channel info are supported.
     *
     * @param string $name        Package name
     * @param string $version     (optional) The minimal version
     *                            that should be installed
     * @param string $channel     (optional) The package channel distribution
     * @param string $user_file   (optional) file to read PEAR user-defined
     *                            options from
     * @param string $system_file (optional) file to read PEAR system-wide
     *                            defaults from
     *
     * @static
     * @return bool
     * @since  PEAR_Info version 1.6.0 (2005-01-03)
     * @see    PEAR_Info::packageInstalled()
     */
    public static function packageInstalled($name, $version = null, $channel = null,
        $user_file = '', $system_file = '')
    {
        $config =& PEAR_Config::singleton($user_file, $system_file);
        $reg    =& $config->getRegistry();

        if (is_null($version)) {
            return $reg->packageExists($name, $channel);
        } else {
            $info = &$reg->getPackage($name, $channel);
            if (is_object($info)) {
                $installed['version'] = $info->getVersion();
            } else {
                $installed = $info;
            }
            return version_compare($version, $installed['version'], '<=');
        }
    }
}

if (PHPUnit_MAIN_METHOD == 'PHP_CompatInfo_AllTests::main') {
    PHP_CompatInfo_AllTests::main();
}
?>