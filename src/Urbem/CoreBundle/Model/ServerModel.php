<?php

namespace Urbem\CoreBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ServerModel
 * @package Urbem\CoreBundle\Model
 */
class ServerModel
{
    const DEFAULT_USERNAME = 'KissezKinoStrong';

    /**
     * @var
     */
    protected $container;

    /**
     * @var
     */
    protected $env;

    /**
     * ServerModel constructor.
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $env = $this->container->getParameter("kernel.environment");
        $this->env = $env;
    }

    /**
     * @return string
     */
    public function getUrlBlade()
    {
        return sprintf("%s/server/project", $this->container->getParameter("url_blade_{$this->env}"));
    }

    /**
     * @param $argument
     * @return string
     */
    public function executeEc2($argument)
    {
        $programEcMetadata = 'ec2-metadata';
        if (in_array($this->env, ['dev', 'homolog'])) {
            $programEcMetadata = 'ec2-metadata-dev';

            return $this->sanitizeResponse(trim(shell_exec(sprintf("%s/../bin/{$programEcMetadata} %s", $this->container->get('kernel')->getRootDir(), $argument))));
        }

        return $this->sanitizeResponse(trim(shell_exec(sprintf("{$programEcMetadata} %s", $argument))));
    }

    /**
     * @param $response
     * @return string
     */
    private function sanitizeResponse($response)
    {
        $res = explode(":", $response);
        if (count($res) > 1) {
            return trim($res[1]);
        }

        return $response;
    }

    /**
     * @param $passwd
     * @return mixed
     */
    public function updatePasswordRemoteAccess($passwd)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $update = sprintf("ALTER USER \"%s\" WITH PASSWORD '%s'", self::DEFAULT_USERNAME, $passwd);

        $conn = $em->getConnection();
        $stmt = $conn->prepare($update);
        return $stmt->execute();
    }
}
