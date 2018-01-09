<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ldo;

use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Ldo\Indicadores;
use Urbem\CoreBundle\Entity\Ldo\TipoIndicadores;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class IndicadoresAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_ldo_indicadores';
    protected $baseRoutePattern = 'financeiro/ldo/indicadores';
    protected $datagridValues = array(
       '_page' => 1,
       '_sort_order' => 'DESC',
       '_sort_by' => 'exercicio'
    );
    protected $exibirMensagemFiltro =  true;
    protected $customRedirectUrl;
    protected $botaoIncluirComParametros = true;
    public $data;
    protected $includeJs = array('/financeiro/javascripts/ldo/configuracao/indicadores.js');

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("show");
        $collection->add('filtro', "filtro");
    }

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'FinanceiroBundle:Ldo\Configuracao\ConfigurarIndicadores:list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $params = $this->getForm()->all();

        if (!preg_match("/^[0-9]{4}$/", $params['exercicio']->getViewData())) {
            $this->validateIndicadores($errorElement, 'exercicio', 'label.tipoIndicadores.validacoes.anoInvalido', ['varExercicio' => $params['exercicio']->getViewData()]);
        }

        $entity = $this->getDoctrine()->getRepository(Indicadores::class)
            ->findOneBy([
                'exercicio' => $params['exercicio']->getViewData(),
                'codTipoIndicador' => $params['codTipo']->getViewData()
            ]);

        if (!empty($entity)) {
            $this->validateIndicadores($errorElement, 'fkLdoTipoIndicadores', 'label.tipoIndicadores.validacoes.tipoExercicioExiste', []);
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param $input
     * @param $message
     * @param array $params
     */
    protected function validateIndicadores(ErrorElement $errorElement, $input, $message, $params = [])
    {
        $error = $this->getContainer()->get('translator')->transChoice($message, 0, $params, 'messages');
        $errorElement->with($input)->addViolation($error)->end();
    }

    /**
     * @return null|string
     */
    public function getNomTipoIndicador()
    {
        if ($this->getPersistentParameter('id')) {
            return $this->getDoctrine()->getRepository(TipoIndicadores::class)->findOneByCodTipoIndicador($this->getPersistentParameter('id'));
        } else {
            return null;
        }
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'id' => $this->getRequest()->get('id')
        );
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->getPersistentParameter('id')) {
            $query->andWhere('1 = 0');
        } else {
            $query->where('o.codTipoIndicador = :codTipoIndicador');
            $query->setParameter('codTipoIndicador', $this->getPersistentParameter('id'));
        }
        return $query;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->customHeader = 'FinanceiroBundle:Sonata\Ldo\Indicadores\CRUD:header.html.twig';

        $this->setBreadCrumb();

        $this->data = $this->request->query->get('filter')['fkLdoTipoIndicadores']['value'];

        $this->getConfigurationPool()->getContainer()->get('session')->getFlashBag()->set('customRedirectUrl', $this->request->getRequestUri());

        $listMapper
            ->add(
                'exercicio',
                null,
                array(
                    'label' => 'label.indicadores.exercicio'
                )
            )
            ->add(
                'indice',
                'decimal',
                array(
                    'label' => 'label.indicadores.indice',
                )
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formOptions = array();

        $formOptions['exercicio'] = array(
            'label' => 'label.indicadores.exercicio',
            'mapped' => false
        );

        $formOptions['fkLdoTipoIndicadores'] = array(
            'label' => 'label.indicadores.codTipoIndicador',
            'class' => TipoIndicadores::class,
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters',
                'disabled' => true,
            ),
        );

        $formOptions['indice'] = array(
            'label' => 'label.indicadores.indice',
            'grouping' => false,
            'attr' => array(
                'class' => 'money '
            )
        );

        $formMapper
            ->with('label.indicadores.dadosConfiguracaoInicialLDO')
                ->add(
                    'codTipo',
                    'hidden',
                    array(
                        'data' => $id,
                        'mapped' => false,
                    )
                )
                ->add(
                    'fkLdoTipoIndicadores',
                    'entity',
                    $formOptions['fkLdoTipoIndicadores']
                )
                ->add(
                    'exercicio',
                    'number',
                    $formOptions['exercicio']
                )
                ->add(
                    'indice',
                    'number',
                    $formOptions['indice']
                )
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $params = $this->getForm()->all();
        $fkLdoTipoIndicadores = $this->getDoctrine()->getRepository(TipoIndicadores::class)
            ->findOneByCodTipoIndicador($params['codTipo']->getViewData());

        $object->setFkLdoTipoIndicadores($fkLdoTipoIndicadores);
        $object->setExercicio($params['exercicio']->getViewData());
        $object->setIndice(str_replace(',', '.', $params['indice']->getViewData()));
    }

    /**
     * @param mixed $object
     * @return mixed|string
     */
    public function toString($object)
    {
        return $object->getFkLdoTipoIndicadores()
            ? $object
            : $this->getTranslator()->trans('label.indicadores.indicadoresInicial');
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $url = $this->getConfigurationPool()->getContainer()->get('session')->getFlashBag()->get('customRedirectUrl')[0];
        $this->getDoctrine()->clear();

        (new RedirectResponse($url))->send();
    }

    /**
     * @param mixed $object
     */
    public function postRemove($object)
    {
        $url = $this->getConfigurationPool()->getContainer()->get('session')->getFlashBag()->get('customRedirectUrl')[0];
        $this->getDoctrine()->clear();

        (new RedirectResponse($url))->send();
    }
}
