<?php

namespace Urbem\CoreBundle\Resources\config\Sonata;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\TranslatorInterface;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Helper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Model\Administracao\GrupoPermissaoModel;
use Urbem\ReportBundle\Service\ReportService;
use \Symfony\Component\HttpFoundation\Response;
// Namespaces que deveriam ser instanciados dinamicamente
use Urbem\CoreBundle\Model\Administracao;
use Urbem\CoreBundle\Model\Administracao\GrupoModel;
use Urbem\CoreBundle\Model\Organograma;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Urbem\CoreBundle\Entity\Administracao\Usuario;

class AbstractSonataAdmin extends AbstractAdmin
{
    const ERROR_REMOVE_DATA = 'Este item não poderá ser removido, pois está relacionado à outro(s) item(s).';

    protected $maxPageLinks = 15;

    protected $maxPerPage = 10;

    public $adminRequestId;

    protected $goBackURL = '';

    /** @TODO modificar para static para levar em conta telas onde duas ou mais admin sao carregadas */
    protected $hasBreadcrumb = false;

    protected $model = null;

    protected $exibirBotaoIncluir = true;

    protected $exibirBotaoEditar = true;

    protected $exibirBotaoExcluir = true;

    protected $exibirBotaoSalvar = true;

    protected $exibirBotaoVoltar = true;

    protected $exibirMensagemFiltro = false;

    protected $botaoIncluirComParametros = false;

    protected $linkAdminCustom = null;

    protected $keyLinkAdminCustom = null;

    protected $defaultObjectId = 'objectId';

    protected $includeJs = [];

    protected $scriptDynamicBlock = null;

    protected $customHeader = null;

    protected $urlReferer = null;

    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Salvar'];

    protected $legendBtnCatalogue = [];

    protected $customBodyTemplate = null;

    protected $exibirBotaoVoltarNoList = false;

    protected $customMessageDelete = false;

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        unset($actions['delete']);

        return $actions;
    }

    public function getGoBackURL()
    {
        return $this->goBackURL;
    }

    public function getExibirBotaoIncluir()
    {
        return $this->exibirBotaoIncluir;
    }

    public function getBotaoIncluirComParametros()
    {
        return $this->botaoIncluirComParametros;
    }

    public function getExibirBotaoEditar()
    {
        return $this->exibirBotaoEditar;
    }

    public function getExibirBotaoExcluir()
    {
        return $this->exibirBotaoExcluir;
    }

    public function getExibirBotaoVoltar()
    {
        return $this->exibirBotaoVoltar;
    }

    public function getLinkAdminCustom()
    {
        return $this->linkAdminCustom;
    }

    public function getKeyLinkAdminCustom()
    {
        return $this->keyLinkAdminCustom;
    }

    public function getIncludeJs()
    {
        return $this->includeJs;
    }

    public function setIncludeJs(array $paths)
    {
        $this->includeJs = $paths;
    }

    public function addToIncludeJs($path)
    {
        $this->includeJs[] = $path;
    }

    public function setScriptDynamicBlock($scriptBlock)
    {
        $this->scriptDynamicBlock = $scriptBlock;
    }

    public function getScriptDynamicBlock()
    {
        return $this->scriptDynamicBlock;
    }

    protected function initModel($objectModel)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $db = $container->get('doctrine')->getManager();

        return new $objectModel($db);
    }

    public function setBreadCrumb($param = [], $routeName = null)
    {
        if ($this->hasBreadcrumb) {
            return null;
        }

        $container = $this->getConfigurationPool()->getContainer();
        $request = $container->get('request_stack')->getCurrentRequest();

        if (false === $request instanceof Request) {
            return null;
        }

        $this->hasBreadcrumb = true;
        $breadcrumb = $container->get("white_october_breadcrumbs");
        $router = $container->get("router");
        $routeName = (is_null($routeName) ? $request->attributes->get('_route') : $routeName);
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /**
         * Técnica paleativa para solução do problema do breadcrumb com collection
         */
        if ($routeName != 'sonata_admin_append_form_element') {
            return Helper\BreadCrumbsHelper::getBreadCrumb(
                $breadcrumb,
                $router,
                $routeName,
                $entityManager,
                $param
            );
        }
    }

    protected function getAdminRequestId()
    {
        $admin = $this->isChild() ? $this->getParent() : $this;

        // Check is composite
        $composite = explode('~', $admin->getRequest()->get('id'));

        if (count($composite) == 1 && !is_null($admin->getRequest()->get('id')) && $admin->getRequest()->get('id') === 0) {
            // throw  new \Exception(Error::INVALID_PARAMETER_ZERO);

            return $this->forceRedirect('/erro-urbem');
        }

        return $this->adminRequestId = $admin->getRequest()->get('id');
    }

    public function preRemove($object)
    {
        if (is_null($this->model)) {
            return true;
        }

        $container = $this->getConfigurationPool()->getContainer();
        if (!$this->initModel($this->model)->canRemove($object)) {
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);

            $this->getDoctrine()->clear();

            (new RedirectResponse($this->request->headers->get('referer')))->send();
        }
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ))
        ;
    }

    public function forceRedirect($url = false)
    {
        $url = ($url) ? $url : "/recursos-humanos/pessoal/servidor/list";
        (new RedirectResponse($url))->send();
    }

    /**
     * Instância o serviço de comunicação com o Birt.
     * @return ReportService
     */
    public function getReportService()
    {
        $container = $this->getConfigurationPool()->getContainer();
        $birtPort = $container->getParameter("port_birt");

        $reportUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]:{$birtPort}";
        if ($container->hasParameter("host_birt") && !empty($container->getParameter("host_birt"))) {
            $reportUrl = $container->getParameter("host_birt") . ":{$birtPort}";
        }

        $paramsDb = [
            $container->getParameter('database_name'),
            $container->getParameter('database_host'),
            $container->getParameter('database_port')
        ];

        return new ReportService("$reportUrl/viewer_440/run?", $paramsDb);
    }

    public function parseContentToPdf($content, $fileName)
    {
        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '.pdf";');
        $response->setContent($content);
        $response->sendHeaders();
        $response->send();
    }

    public function parseNameFile($fileName)
    {
        return $fileName . "_" . date('Ymdhis');
    }

    /**
     * @return string
     */
    public function getDefaultObjectId()
    {
        return $this->defaultObjectId;
    }

    /**
     * @param string $defaultObjectId
     */
    public function setDefaultObjectId($defaultObjectId)
    {
        $this->defaultObjectId = $defaultObjectId;
    }

    /**
     * retorna o ano digitado no momento do login
     * @return string
     */
    public function getExercicio()
    {
        return $this->getConfigurationPool()
        ->getContainer()
        ->get('urbem.session.service')
        ->getExercicio();
    }

    /**
     * @return null|object|Entidade
     */
    public function getEntidade()
    {
        return $this->getConfigurationPool()
            ->getContainer()
            ->get('urbem.entidade')
            ->getEntidade();
    }

    /**
     * {@inheritdoc}
     */
    public function checkAccess($action, $object = null)
    {
        $authorizationChecker = $this->getContainer()->get('security.authorization_checker');

        if (!$authorizationChecker->isGranted("ROLE_SUPER_ADMIN")) {
            $this->getConfigurationPool()->getContainer()->get('urbem.route.access')->checkAccess();
        }

        return true;
    }

    public function checkSelectedDeleteInListCollecion($object, $originField, $fieldSetObject)
    {
        $faixasCollection = $this->getForm()->get($originField);
        $em = $this->modelManager->getEntityManager($this->getClass());

        foreach ($faixasCollection as $faixaForm) {
            if ($faixaForm->get('_delete')->getData()) {
                $em->remove($faixaForm->getData());
                $em->flush();
            } else {
                $faixas = $faixaForm->getData();
                $faixas->$fieldSetObject($object);
            }
        }
    }

    /**
     * Retorna o usuario logado
     *
     * @return Usuario
     */
    public function getCurrentUser()
    {
        return $this->getContainer()->get('security.token_storage')->getToken()->getUser();
    }

    /**
     * @param null $urlReferer
     */
    public function setUrlReferer($urlReferer)
    {
        $this->urlReferer = $urlReferer;
    }

    public function getUrlReferer()
    {
        return $this->urlReferer;
    }

    public function setCustomHeader($template = null)
    {
        $this->customHeader = $template;
    }

    public function getCustomHeader()
    {
        return $this->customHeader;
    }

    public function setLegendButtonSave($icon = 'save', $legend = 'Salvar')
    {
        $this->legendButtonSave = ['icon' => $icon, 'text' => $legend];
    }

    public function getLegendButtonSave()
    {
        return $this->legendButtonSave;
    }

    protected function addlegendBtnCatalogue($iconAndLegend, $keyName = 'defaultButton')
    {
        $this->legendBtnCatalogue[$keyName] = $iconAndLegend;
    }

    public function getlegendBtnCatalogue()
    {
        if (empty($this->legendBtnCatalogue)) {
            $this->addlegendBtnCatalogue(['icon' => 'add_circle', 'text' => 'Adicionar Novo']);
        }

        return $this->legendBtnCatalogue;
    }

    /**
     * @return null
     */
    public function getCustomBodyTemplate()
    {
        return $this->customBodyTemplate;
    }

    /**
     * @param null $customBodyTemplate
     */
    public function setCustomBodyTemplate($customBodyTemplate)
    {
        $this->customBodyTemplate = $customBodyTemplate;
    }

    public function exibirBotaoVoltarNoList()
    {
        return $this->exibirBotaoVoltarNoList;
    }

    public function exibeBotaoSalvar()
    {
        return $this->exibirBotaoSalvar;
    }

    /**
     * Get Container Interface to avoid too many chaining
     * @return null|\Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function getContainer()
    {
        return $this->getConfigurationPool()
            ->getContainer();
    }

    /**
     * Get FlashBagInterface to avoid too many chaining
     * @return \Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface
     */
    protected function getFlashBag()
    {
        return $this
            ->getContainer()
            ->get('session')
            ->getFlashBag();
    }

    /**
     * Get Entity Manager without it's model class
     * @deprecated use getEntityManager
     * @return \Doctrine\ORM\EntityManager|object
     */
    protected function getDoctrine()
    {
        return $this->getEntityManager();
    }

    /**
     * @return EntityManager|EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @param string $url
     * @return Response
     * @throws \Exception
     */
    protected function redirectToUrl($url)
    {
        return (new RedirectResponse($url))->send();
    }

    /**
     * @return bool
     */
    public function getCustomMessageDelete()
    {
        return $this->customMessageDelete;
    }

    /**
     * @return TranslatorInterface|object
     */
    public function getTranslator()
    {
        return $this->getContainer()->get('translator');
    }

    /**
     * @param $route
     * @param array $parameters
     * @param int $referenceType
     * @return Response
     */
    protected function redirectByRoute($route, array $parameters = [], $referenceType = Router::ABSOLUTE_PATH)
    {
        return $this->redirectToUrl($this->getContainer()->get('router')->generate($route, $parameters, $referenceType));
    }

    protected function preSetPostToChoice($field, $default = null, $method = 'POST')
    {
        $request = $this->getRequest();

        if (in_array('POST', [$request->getMethod(), $method])) {
            $formData = $this->getFormPost();
            return array_key_exists($field, $formData) ? [$formData[$field] => $formData[$field]] : $default;
        }

        return $request->get($field, $default);
    }

    public function getFormPost($formSonata = true)
    {
        $request = $this->getRequest();
        $formData = $request->request->all();

        if ($formSonata && array_key_exists($this->getUniqid(), $formData)) {
            return $formData[$this->getUniqid()];
        }
        return $formData;
    }

    /**
     * Get the value of Exibir Mensagem Filtro
     *
     * @return mixed
     */
    public function getExibirMensagemFiltro()
    {
        return $this->exibirMensagemFiltro;
    }

    /**
     * {@inheritdoc}
     */
    public function getNormalizedIdentifier($entity)
    {
        return $this->getObjectKey($entity);
    }

    /**
     * @param $object
     *
     * @return string
     */
    public function getObjectKey($object)
    {
        if (false === is_object($object)) {
            return;
        }

        $values = $this->modelManager->getMetadata(get_class($object))->getIdentifierValues($object);
        $fields = $this->modelManager->getMetadata(get_class($object))->getIdentifierFieldNames($object);
        $fields = array_combine(array_values($fields), array_values($fields));

        if (0 < count(array_diff_key($fields, $values))) {
            return;
        }

        return implode('~', $values);
    }

    /**
     * Retorna a lista de campos unicos para validação da Collection
     * @return array
     */
    public function getUniqueCollectionFields()
    {
        return $this->uniqueCollectionFields;
    }

    /**
     * Retorna a lista de collections para verificar os campos unicos
     * @return array
     */
    public function getCollectionsList()
    {
        return $this->collectionsList;
    }

    /**
     * @param object $object
     * @param array  $ignoreAssociations
     * @return boolean
     */
    protected function canRemove($object, array $ignoreAssociations = [])
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $metadata = $em->getClassMetadata(get_class($object));
        foreach ($metadata->getAssociationMappings() as $associationsName => $associationMapping) {
            if (in_array($associationsName, $ignoreAssociations) || $associationMapping['isOwningSide']) {
                continue;
            }

            $getterMethod = sprintf('get%s', ucfirst($associationsName));

            $associationValue = $object->$getterMethod();
            if ($associationValue instanceof Collection && !$associationValue->isEmpty()) {
                return false;
            }
        }

        return true;
    }
}
