<?php
declare(strict_types=1);

namespace PHPMailerPGP\Test;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPMailer\PHPMailerPGP\PGPKeyManager;
use PHPMailer\PHPMailerPGP\PGPHelper;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;

/**
 * @author Andreas Wahlen
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
#[CoversTrait(PGPHelper::class)]
#[CoversClass(PGPKeyManager::class)]
#[RequiresPhpExtension('gnupg')]
final class PGPKeyManagerTest extends PGPTestCase
{
    /**
     * @var PGPKeyManager
     */
    private $keyManager;
    
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        
        $gnupg = new \gnupg();
        $gnupg->seterrormode(GNUPG_ERROR_EXCEPTION);
        if ($gnupg->import(file_get_contents(__DIR__.'/public.asc')) === false) {
            echo 'failed to import example key'.PHP_EOL;
        }
    }
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->keyManager = new PGPKeyManager(new class() implements \Psr\Log\LoggerInterface {
            /**
             * @param string|\Stringable $message
             */
            public function emergency($message, array $context = []): void {
                $this->log(\Psr\Log\LogLevel::EMERGENCY, $message, $context);
            }
            
            /**
             * @param string|\Stringable $message
             */
            public function alert($message, array $context = []): void {
                $this->log(\Psr\Log\LogLevel::ALERT, $message, $context);
            }
            
            /**
             * @param string|\Stringable $message
             */
            public function critical($message, array $context = []): void {
                $this->log(\Psr\Log\LogLevel::CRITICAL, $message, $context);
            }
            
            /**
             * @param string|\Stringable $message
             */
            public function error($message, array $context = []): void {
                $this->log(\Psr\Log\LogLevel::ERROR, $message, $context);
            }
            
            /**
             * @param string|\Stringable $message
             */
            public function warning($message, array $context = []): void {
                $this->log(\Psr\Log\LogLevel::WARNING, $message, $context);
            }
            
            /**
             * @param string|\Stringable $message
             */
            public function notice($message, array $context = []): void {
                $this->log(\Psr\Log\LogLevel::NOTICE, $message, $context);
            }
            
            /**
             * @param string|\Stringable $message
             */
            public function info($message, array $context = []): void {
                $this->log(\Psr\Log\LogLevel::INFO, $message, $context);
            }
            
            /**
             * @param string|\Stringable $message
             */
            public function debug($message, array $context = []): void {
                $this->log(\Psr\Log\LogLevel::DEBUG, $message, $context);
            }
            
            /**
             * @param string|\Stringable $message
             */
            public function log($level, $message, array $context = []): void {
                foreach($context as $key => $value){
                    $message = str_replace('{'.$key.'}', var_export($value, true), $message);
                }
                //echo strtoupper($level)."\t".$message.PHP_EOL;
            }
        });
        $this->keyManager->setGPGHome(self::$gnupgHome);
    }
    
    public function testDeleteAndImport(): void
    {
        $this->keyManager->deleteKey('user@example.com', true);
        $this->assertEmpty($this->keyManager->getKeys('user@example.com', 'sign'), 'private key still there');
        $this->assertEmpty($this->keyManager->getKeys('user@example.com', 'encrypt'), 'public key still there');
        
        $this->keyManager->importKeyFile(__DIR__.'/public.asc');
        $this->assertCount(1, $this->keyManager->getKeys('user@example.com', 'sign'), 'private key not found');
        $this->assertCount(1, $this->keyManager->getKeys('user@example.com', 'encrypt'), 'public key not found');
    }
}
