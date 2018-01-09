<?php

namespace Urbem\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Yaml\Yaml;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Model\Administracao\ModuloModel;
use Urbem\CoreBundle\Model\ServerModel;

class ServerController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modulesAction(Request $request)
    {
        $response = 'connection refused';
        if ($this->checkToken($request) && $request->get('modules')) {
            $response = $this->processModules($request);
        }

        return new JsonResponse([
            'response' => ($response)
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function managementAccessAction(Request $request)
    {
        $response = 'connection refused';
        $database = $user = null;
        if ($this->checkToken($request) && !empty($request->request->get('csrf'))) {
            $serverModel = new ServerModel($this->container);

            $em = $this->get('doctrine.orm.entity_manager');
            $database = $em->getConnection()->getDatabase();
            $user = $serverModel::DEFAULT_USERNAME;

            $response = $serverModel->updatePasswordRemoteAccess($request->request->get('csrf')) ?
                "success" : "fail";
        }

        return new JsonResponse([
            'response' => $response, 'database' => $database, 'user' => $user
        ]);
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function checkToken(Request $request)
    {
        if ($request->getMethod() == 'POST' && $request->headers->get('tk-blade') == $this->getParameter('token-api-blade')) {
            return true;
        }

        return false;
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function processModules(Request $request)
    {
        $modules = $request->get('modules');
        $modulesList = [];

        foreach ($modules as $module => $actived) {
            // list($module, $actived) = explode(":", $module);
            $modulesList[$module] = filter_var($actived, FILTER_VALIDATE_BOOLEAN);
        }

        $array = [
            'parameters' => [
                'modules' => $modulesList
            ]
        ];
        $yaml = Yaml::dump($array);
        $module = new ModuloModel($this->get('doctrine.orm.entity_manager'));
        $module->saveMenuModule($modulesList);

        if (file_put_contents($this->get('kernel')->getRootDir() . "/config/common/modules.yml", $yaml)) {
            return 'Módulos processados com sucesso!!!';
        }

        return 'fail load modules';
    }
}
