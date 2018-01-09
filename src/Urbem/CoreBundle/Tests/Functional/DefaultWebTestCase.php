<?php

namespace Urbem\CoreBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\SwCgm;

class DefaultWebTestCase extends WebTestCase
{
    const DEFAULT_EMAIL_USER = "rafael.martines@longevo.com.br";

    /**
     * @var Client
     */
    protected $client = null;

    protected $container = null;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
        $this->client = static::createClient();

        $this->logIn();
    }

    protected function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $entityManager = $this->container->get('doctrine')->getManager();

        $user = $entityManager->getRepository('CoreBundle:Administracao\Usuario')->findOneByEmail(self::DEFAULT_EMAIL_USER);

        // the firewall context (defaults to the firewall name)
        $firewall = 'main';

        $token = new UsernamePasswordToken($user, null, $firewall, array('ROLE_SUPER_ADMIN'));
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());

        $this->client->getCookieJar()->set($cookie);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $entityManager = $this->container->get('doctrine')->getManager();
        $entityManager->getConnection()->close();
    }
}
