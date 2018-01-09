<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\Pager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Arrecadacao\CalendarioFiscal;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento;
use Urbem\CoreBundle\Model\Arrecadacao\GrupoVencimentoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class CalendarioFiscalAdmin
 * @package Urbem\TributarioBundle\Admin
 */
class CalendarioFiscalAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_calendario_fiscal_calendario';
    protected $baseRoutePattern = 'tributario/arrecadacao/calendario-fiscal/calendario';
    protected $includeJs = array(
        '/tributario/javascripts/arrecadacao/calendario-fiscal.js'
    );

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        /** @var Pager $pager */
        $pager = $this->getDatagrid()->getPager();
        $pager->setCountColumn(array('codGrupo'));

        $datagridMapper
            ->add(
                'codGrupo',
                null,
                [
                    'label' => 'label.calendarioFiscal.grupoCreditos',
                ],
                'entity',
                [
                    'class' => GrupoCredito::class,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkArrecadacaoGrupoCredito.codGrupo', null, array('label' => 'label.codigo'))
            ->add('fkArrecadacaoGrupoCredito.descricao', null, array('label' => 'label.calendarioFiscal.grupoCreditos'))
            ->add('anoExercicio', null, array('label' => 'label.exercicio'))
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

        $fieldOptions = array();

        $fieldOptions['codGrupo'] = array(
            'class' => GrupoCredito::class,
            'label' => 'label.calendarioFiscal.grupoCreditos',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'mapped' => false
        );

        $fieldOptions['valorMinimo'] = array(
            'label' => 'label.calendarioFiscal.valorMinimo',
            'required' => true,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money ',
            ),
        );

        $fieldOptions['valorMinimoLancamento'] = array(
            'label' => 'label.calendarioFiscal.valorMinimoLancamento',
            'required' => true,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            ),
        );

        $fieldOptions['valorMinimoParcela'] = array(
            'label' => 'label.calendarioFiscal.valorMinimoParcela',
            'required' => true,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            ),
        );

        $fieldOptions['descricao'] = array(
            'label' => 'label.descricao',
            'required' => true,
            'mapped' => false
        );

        $fieldOptions['vencimentoValorIntegral'] = array(
            'label' => 'label.calendarioFiscal.vencimentoValorIntegral',
            'required' => true,
            'mapped' => false,
            'format' => 'dd/MM/yyyy',
        );

        $fieldOptions['limiteInicial'] = array(
            'label' => 'label.calendarioFiscal.limiteInicial',
            'required' => true,
            'mapped' => false,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            ),
        );

        $fieldOptions['limiteFinal'] = array(
            'label' => 'label.calendarioFiscal.limiteFinal',
            'required' => true,
            'mapped' => false,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            ),
        );

        $fieldOptions['utilizarCotaUnica'] = array(
            'label' => 'label.calendarioFiscal.utilizarCotaUnica',
            'mapped' => false,
            'expanded' => true,
            'choices' => array(
                'sim' => 1,
                'nao' => 0
            ),
            'data' => 0,
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            )
        );

        $fieldOptions['fkArrecadacaoGrupoVencimentos'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Arrecadacao/CalendarioFiscal/grupoVencimentos.html.twig',
            'data' => array(
                'grupoVencimentos' => array()
            )
        );

        $fieldOptions['seguirDefinicaoVencimentos'] = array(
            'label' => 'label.calendarioFiscal.seguirDefinicaoVencimentos',
            'mapped' => false,
            'required' => false,
            'data' => true
        );

        if ($this->id($this->getSubject())) {
            /** @var CalendarioFiscal $grupoVencimentos */
            $grupoVencimentos = $this->getSubject();

            $fieldOptions['fkArrecadacaoGrupoVencimentos']['data'] = array(
                'grupoVencimentos' => $grupoVencimentos->getFkArrecadacaoGrupoVencimentos()
            );
        }

        $formMapper
            ->with('label.calendarioFiscal.dados')
                ->add('codGrupo', 'entity', $fieldOptions['codGrupo'])
                ->add('valorMinimo', 'money', $fieldOptions['valorMinimo'])
                ->add('valorMinimoLancamento', 'money', $fieldOptions['valorMinimoLancamento'])
                ->add('valorMinimoParcela', 'money', $fieldOptions['valorMinimoParcela'])
            ->end()
            ->with('label.calendarioFiscal.gruposVencimentos')
                ->add('descricao', 'text', $fieldOptions['descricao'])
                ->add('vencimentoValorIntegral', 'sonata_type_date_picker', $fieldOptions['vencimentoValorIntegral'])
                ->add('limiteInicial', 'money', $fieldOptions['limiteInicial'])
                ->add('limiteFinal', 'money', $fieldOptions['limiteFinal'])
                ->add('utilizarCotaUnica', 'choice', $fieldOptions['utilizarCotaUnica'])
                ->add('fkArrecadacaoGrupoVencimentos', 'customField', $fieldOptions['fkArrecadacaoGrupoVencimentos'])
                ->add('seguirDefinicaoVencimentos', 'checkbox', $fieldOptions['seguirDefinicaoVencimentos'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.calendarioFiscal.dados')
                ->add('fkArrecadacaoGrupoCredito', null, array('label' => 'label.calendarioFiscal.grupo'))
                ->add('valorMinimo', 'text', array('label' => 'label.calendarioFiscal.valorMinimo'))
                ->add('valorMinimoLancamento', 'text', array('label' => 'label.calendarioFiscal.valorMinimoLancamento'))
                ->add('valorMinimoParcela', 'text', array('label' => 'label.calendarioFiscal.valorMinimoParcela'))
                ->add(
                    'fkArrecadacaoGrupoVencimentos',
                    'string',
                    array(
                        'label' => 'label.calendarioFiscal.listaGruposVencimentos',
                        'template' => 'TributarioBundle::Arrecadacao/CalendarioFiscal/dadosGrupoVencimentos.html.twig',
                    )
                )
            ->end()
        ;
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $form = $this->getForm();
            $params = $form->all();
            $grupoCredito = $params['codGrupo']->getNormData();

            $object->setFkArrecadacaoGrupoCredito($grupoCredito);

            $this->saveRelationships($object);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager(GrupoVencimento::class);

            $grupoVencimentos = $em->getRepository(GrupoVencimento::class)
                ->findBy([
                    'codGrupo' => $object->getCodGrupo(),
                    'anoExercicio' => $object->getAnoExercicio()
                ]);

            foreach ($grupoVencimentos as $grupoVencimento) {
                $em->remove($grupoVencimento);
            }
            $em->flush();

            $this->saveRelationships($object);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param CalendarioFiscal $object
     */
    private function saveRelationships($object)
    {
        $em = $this->modelManager->getEntityManager(GrupoVencimento::class);
        $grupoVencimentoModel = new GrupoVencimentoModel($em);

        $grupoVencimentos = $this->getRequest()->request->get('grupoVencimentos');
        foreach ($grupoVencimentos as $grupoVenc) {
            list($utilizarCotaUnica, $descricao, $vencimentoValorIntegral, $limiteInicial, $limiteFinal) = explode('__', $grupoVenc);

            $codVencimento = $grupoVencimentoModel->getNextVal($object->getAnoExercicio(), $object->getCodGrupo());

            $vencimentoValorIntegral = \DateTime::createFromFormat('d/m/Y', $vencimentoValorIntegral);

            $grupoVencimento = new GrupoVencimento();
            $grupoVencimento->setCodVencimento($codVencimento);
            $grupoVencimento->setFkArrecadacaoCalendarioFiscal($object);
            $grupoVencimento->setDescricao($descricao);
            $grupoVencimento->setDataVencimentoParcelaUnica($vencimentoValorIntegral);
            $grupoVencimento->setLimiteInicial($limiteInicial);
            $grupoVencimento->setLimiteFinal($limiteFinal);
            $grupoVencimento->setUtilizarUnica((boolean) $utilizarCotaUnica);

            $em->persist($grupoVencimento);
            $em->flush();
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $oldObject = $em->getUnitOfWork()->getOriginalEntityData($object);

        if (!empty($oldObject)) {
            return true;
        }

        $form = $this->getForm();
        $params = $form->all();
        $grupoCredito = $params['codGrupo']->getNormData();

        $calendarioFiscal = $em->getRepository($this->getClass())
            ->findOneBy([
                'codGrupo' => $grupoCredito->getCodGrupo(),
                'anoExercicio' => $grupoCredito->getAnoExercicio(),
            ]);

        if ($calendarioFiscal) {
            $error = $this->getTranslator()->trans('label.calendarioFiscal.error');
            $errorElement->with('codGrupo')->addViolation($error)->end();
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof CalendarioFiscal
            ? $object->getCodGrupo()
            : $this->getTranslator()->trans('label.calendarioFiscal.modulo');
    }
}
