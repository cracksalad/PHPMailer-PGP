<?php
declare(strict_types=1);

namespace PHPMailerPGP\Test;

use PHPUnit\Framework\TestCase;

/**
 * @author Andreas Wahlen
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
class PGPTestCase extends TestCase
{
    /**
     * @var string
     */
    protected static $gnupgHome;
    
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        
        self::$gnupgHome = __DIR__ . '/.gnupg';
        if (!file_exists(self::$gnupgHome)) {
            if (!mkdir(self::$gnupgHome) || !chmod(self::$gnupgHome, 0700)) {
                echo 'unable to create GnuPG home'.PHP_EOL;
            }
        }
        putenv('GNUPGHOME=' . escapeshellcmd(self::$gnupgHome));
    }
    
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        exec('rm -rf '.escapeshellcmd(self::$gnupgHome));
    }
}
