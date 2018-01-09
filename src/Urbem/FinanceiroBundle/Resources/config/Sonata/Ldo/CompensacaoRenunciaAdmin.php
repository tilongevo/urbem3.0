<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ldo;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CompensacaoRenunciaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_ldo_renuncia_receita';
    protected $baseRoutePattern = 'financeiro/ldo/renuncia-receita';
    protected $includeJs = array(
        '/financeiro/javascripts/ldo/renuncia-receita.js'
    );

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("show");
        $collection->add('get_exercicio_ldo', 'get-exercicio-ldo', array(), array(), array(), '', array(), array('POST'));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkLdoLdo.fkPpaPpa',
                null,
                array(
                    'label' => 'label.compensacaoRenuncia.codPpa'
                ),
                null,
                array(
                    'placeholder' => 'label.selecione'
                )
            )
            ->add(
                'ldoAno',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.compensacaoRenuncia.ano',
                    'callback' => array($this, 'getSearchFilter')
                ),
                'choice',
                array(
                    'choices' => array(
                        'exercicio1' => 1,
                        'exercicio2' => 2,
                        'exercicio3' => 3,
                        'exercicio4' => 4
                    ),
                    'attr' => array(
                        'class' => 'select2-parameters',
                    ),
                    'placeholder' => 'label.selecione'
                )
            )
        ;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        if ($filter['ldoAno']['value'] != '') {
            $queryBuilder->andWhere("{$alias}.ano = :ano");
            $queryBuilder->setParameter("ano", $filter['ldoAno']['value']);
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'descricaoPpa',
                null,
                array(
                    'label' => 'label.compensacaoRenuncia.codPpa',
                )
            )
            ->add(
                'exercicioLdo',
                null,
                array(
                    'label' => 'label.compensacaoRenuncia.ano',
                )
            )
            ->add(
                'tributo',
                null,
                array(
                    'label' => 'label.compensacaoRenuncia.tributo',
                )
            )
            ->add(
                'modalidade',
                null,
                array(
                    'label' => 'label.compensacaoRenuncia.modalidade',
                )
            )
            ->add(
                'setoresProgramas',
                null,
                array(
                    'label' => 'label.compensacaoRenuncia.setoresProgramas',
                )
            )
            ->add(
                'valorAnoLdo',
                'currency',
                array(
                    'label' => 'label.compensacaoRenuncia.valorAnoLdo',
                    'currency' => 'BRL'
                )
            )
            ->add(
                'valorAnoLdo1',
                'currency',
                array(
                    'label' => 'label.compensacaoRenuncia.valorAnoLdo1',
                    'currency' => 'BRL'
                )
            )
            ->add(
                'valorAnoLdo2',
                'currency',
                array(
                    'label' => 'label.compensacaoRenuncia.valorAnoLdo2',
                    'currency' => 'BRL'
                )
            )
            ->add(
                'compensacao',
                null,
                array(
                    'label' => 'label.compensacaoRenuncia.compensacao',
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

        $formOptions['inAnoLdoOriginal'] = array(
            'mapped' => false,
        );

        $formOptions['codPpa'] = array(
            'label' => 'label.compensacaoRenuncia.codPpa',
            'class' => 'CoreBundle:Ppa\Ppa',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );
        $formOptions['ano'] = array(
            'label' => 'label.compensacaoRenuncia.ano',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );
        $formOptions['tributo'] = array(
            'label' => 'label.compensacaoRenuncia.tributo',
        );
        $formOptions['modalidade'] = array(
            'label' => 'label.compensacaoRenuncia.modalidade',
        );
        $formOptions['setoresProgramas'] = array(
            'label' => 'label.compensacaoRenuncia.setoresProgramas',
        );
        $formOptions['valorAnoLdo'] = array(
            'label' => 'label.compensacaoRenuncia.valorAnoLdo',
            'attr' => array(
                'class' => 'mask-monetaria '
            ),
        );
        $formOptions['valorAnoLdo1'] = array(
            'label' => 'label.compensacaoRenuncia.valorAnoLdo1',
            'attr' => array(
                'class' => 'mask-monetaria '
            ),
        );
        $formOptions['valorAnoLdo2'] = array(
            'label' => 'label.compensacaoRenuncia.valorAnoLdo2',
            'attr' => array(
                'class' => 'mask-monetaria '
            ),
        );
        $formOptions['compensacao'] = array(
            'label' => 'label.compensacaoRenuncia.compensacao',
        );

        if ($this->id($this->getSubject())) {
            $compensacaoRenuncia = $this->getSubject();
            $formOptions['codPpa']['choice_attr'] = function ($entidade, $key, $index) use ($compensacaoRenuncia) {
                if ($entidade->getCodPpa() == $compensacaoRenuncia->getCodPpa()) {
                    return ['selected' => 'selected'];
                } else {
                    return ['selected' => false];
                }
            };
            $formOptions['codPpa']['disabled'] = true;
            $formOptions['inAnoLdoOriginal']['data'] = $compensacaoRenuncia->getAno();
            $formOptions['ano']['disabled'] = true;
        }

        $formMapper
            ->with('label.compensacaoRenuncia.dadosCompensacaoRenunciaReceita')
                ->add(
                    'inAnoLdoOriginal',
                    'hidden',
                    $formOptions['inAnoLdoOriginal']
                )
                ->add(
                    'codPpa',
                    'entity',
                    $formOptions['codPpa']
                )
                ->add(
                    'ano',
                    'choice',
                    $formOptions['ano']
                )
                ->add(
                    'tributo',
                    'text',
                    $formOptions['tributo']
                )
                ->add(
                    'modalidade',
                    'text',
                    $formOptions['modalidade']
                )
                ->add(
                    'setoresProgramas',
                    'text',
                    $formOptions['setoresProgramas']
                )
                ->add(
                    'valorAnoLdo',
                    'text',
                    $formOptions['valorAnoLdo']
                )
                ->add(
                    'valorAnoLdo1',
                    'text',
                    $formOptions['valorAnoLdo1']
                )
                ->add(
                    'valorAnoLdo2',
                    'text',
                    $formOptions['valorAnoLdo2']
                )
                ->add(
                    'compensacao',
                    'text',
                    $formOptions['compensacao']
                )
            ->end()
        ;

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $formOptions) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);

                if ($form->has('ano')) {
                    $form->remove('ano');
                }

                if (isset($data['codPpa']) && $data['codPpa'] != "") {
                    $entityManager = $this->modelManager->getEntityManager($this->getClass());
                    $anos = (new \Urbem\CoreBundle\Model\Ldo\CompensacaoRenunciaModel($entityManager))
                    ->getExercicioLdo($data['codPpa'], true);

                    $formOptions['ano']['choices'] = $anos;
                    $formOptions['ano']['auto_initialize'] = false;

                    $codMacro = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'ano',
                        'choice',
                        null,
                        $formOptions['ano']
                    );

                    $form->add($codMacro);
                }
            }
        );

        if ($this->id($this->getSubject())) {
            $formMapper->getFormBuilder()->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($formMapper, $admin, $formOptions) {
                    $form = $event->getForm();
                    $data = $event->getData();
                    $subject = $admin->getSubject($data);

                    if ($form->has('ano')) {
                        $form->remove('ano');
                    }

                    if ($this->getSubject()->getCodPpa() != "") {
                        $entityManager = $this->modelManager->getEntityManager($this->getClass());
                        $anos = (new \Urbem\CoreBundle\Model\Ldo\CompensacaoRenunciaModel($entityManager))
                        ->getExercicioLdo($this->getSubject()->getCodPpa(), true);

                        $formOptions['ano']['choices'] = $anos;
                        $formOptions['ano']['auto_initialize'] = false;
                        $formOptions['ano']['data'] = $this->getSubject()->getAno();

                        $codMacro = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                            'ano',
                            'choice',
                            null,
                            $formOptions['ano']
                        );

                        $form->add($codMacro);
                    }
                }
            );
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if ($object->getValorAnoLdo() <= 0.00) {
            $mensagem = $this->getTranslator()->trans('label.compensacaoRenuncia.erroValor');
            $errorElement->with('valorAnoLdo')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
        }
        if ($object->getValorAnoLdo1() <= 0.00) {
            $mensagem = $this->getTranslator()->trans('label.compensacaoRenuncia.erroValor');
            $errorElement->with('valorAnoLdo1')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
        }
        if ($object->getValorAnoLdo2() <= 0.00) {
            $mensagem = $this->getTranslator()->trans('label.compensacaoRenuncia.erroValor');
            $errorElement->with('valorAnoLdo2')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $ldo = $this->getForm()->get('codPpa')->getData()->getFkLdoLdos()->filter(
            function ($entry) use ($object) {
                if ($entry->getAno() == $object->getAno()) {
                    return $entry;
                }
            }
        )->first();
        $object->setFkLdoLdo($ldo);
        
        $codCompensacao = (new \Urbem\CoreBundle\Model\Ldo\CompensacaoRenunciaModel($entityManager))
            ->getLastCodCompensacao($object->getFkLdoLdo()->getCodPpa(), $object->getFkLdoLdo()->getAno());

        $object->setCodCompensacao($codCompensacao);
    }

    /**
     * @param mixed $object
     * @return mixed|string
     */
    public function toString($object)
    {
        return $object->getCodCompensacao()
            ? $object
            : $this->getTranslator()->trans('label.compensacaoRenuncia.modulo');
    }
}
