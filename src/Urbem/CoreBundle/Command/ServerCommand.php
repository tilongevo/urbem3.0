<?php

namespace Urbem\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\ServerModel;
use Urbem\CoreBundle\Services\ApiService;

class ServerCommand extends ContainerAwareCommand
{
    const FILE_ACTIVED = "/actived";

    protected $env;

    protected function configure()
    {
        parent::configure();
        $this
            ->setName('server:urbem:active-project')
            ->setDescription('Active project URBEM in new server')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');
        $filesystem = $container->get('filesystem');
        $pathStorage = $container->getParameter('file_storage');
        $fileActived = sprintf("%s%s", $pathStorage, self::FILE_ACTIVED);

        if (!file_exists($pathStorage)) {
            $filesystem->mkdir($pathStorage, 0777);
        }

        if (!file_exists($fileActived)) {
            $serverModel = new ServerModel($container);
            $urlBlade = $serverModel->getUrlBlade();

            // Parametro de identificacao do servidor
            $instanceId = $serverModel->executeEc2("--instance-id");
            $publicIp = $serverModel->executeEc2("--public-ipv4");

            $headerApi = [
                'tk-blade' => $container->getParameter("token-api-blade")
            ];
            $parameters = [
                'instanceId' => $instanceId,
                'publicIp' => $publicIp,
                'state' => 'running',
            ];

            $response = $this->sendDataRemoteServer($urlBlade, $headerApi, $parameters);
            if (!isset($response['errorCode']) && $response['response'] == 'sincronizado') {
                $prefectureName = $response['prefecture_name'];
                $prefectureCnpj = $response['prefecture_cnpj'];

                $modulo = $em->getRepository('CoreBundle:Administracao\Modulo')->findOneByCodModulo(Modulo::MODULO_ADMINISTRATIVO);

                $configuracao = new Configuracao();
                $configuracao->setExercicio(sprintf('%s', date('Y')));
                $configuracao->setFkAdministracaoModulo($modulo);
                $configuracao->setParametro('mensagem');
                $configuracao->setValor($prefectureName);

                $configuracaoModel = new ConfiguracaoModel($em);
                $configuracaoModel->setInitialConfig($configuracao);

                // Sempre existirá um usuário suporte para novas instalações
                // Instalações antigas terá processo executado através de Migrations
                $userDefault = $em->getRepository(Usuario::class)->findOneByUsername("suporte");
                if (!empty($userDefault)) {
                    $userDefault->setPassword($container->get('security.password_encoder')->encodePassword($userDefault, $prefectureCnpj));
                    $em->persist($userDefault);
                    $em->flush($userDefault);
                }

                // cria token dizendo que processo já foi sincronizado
                file_put_contents($fileActived, print_r($response, true));
                $output->writeln("Projeto ativado com sucesso -> {$urlBlade}");
            }

            return;
        }
        //$output->writeln("Projeto já ativado");
    }

    /**
     * @param $url
     * @param $headerApi
     * @param $parameters
     * @return array|mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function sendDataRemoteServer($url, $headerApi, $parameters)
    {
        try {
            $api = new ApiService();
            $res = $api->post($url, $headerApi, $parameters);

            $res = json_decode(
                $res['content'],
                true
            );

            return $res;
        } catch (\Exception $e) {
            return [
                'errorCode' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }
}
