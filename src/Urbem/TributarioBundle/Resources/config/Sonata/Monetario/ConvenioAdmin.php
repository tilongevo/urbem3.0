<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Monetario;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio;
use Urbem\CoreBundle\Entity\Monetario\Convenio;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ConvenioAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_monetario_convenio';
    protected $baseRoutePattern = 'tributario/cadastro-monetario/convenio';
    protected $includeJs = ['/tributario/javascripts/monetario/convenio.js'];

    /**
     * @param mixed $object
     */
    public function preRemove($object)
    {
        if ($this->canRemove($object, ['fkMonetarioContaCorrenteConvenios'])) {
            return;
        }

        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.monetarioContaCorrenteConvenio.erroDelecao'));

        $this->modelManager->getEntityManager($this->getClass())->clear();

        return $this->forceRedirect($this->generateObjectUrl('list', $object));
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $em->persist($object);

        $this->syncContaCorrenteConvenios($object);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->syncContaCorrenteConvenios($object);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        if ($object->getCodConvenio()) {
            return;
        }

        $convenio = $em->getRepository(Convenio::class)
            ->findOneBy(
                [
                    'codTipo' => $this->getForm()->get('fkMonetarioTipoConvenio')->getData(),
                    'numConvenio' => $this->getForm()->get('numConvenio')->getData(),
                ]
            );

        if ($convenio) {
            $error = $this->getTranslator()->trans('label.monetarioConvenio.erroConvenio');
            $errorElement->with('numConvenio')->addViolation($error)->end();
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkMonetarioContaCorrenteConvenios.fkMonetarioContaCorrente.fkMonetarioAgencia.fkMonetarioBanco',
                null,
                [
                    'label' => 'label.monetarioContaCorrenteConvenio.codBanco',
                ],
                'entity',
                [
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->orderBy('o.numBanco', 'ASC');

                        return $qb;
                    },
                    'choice_label' => function ($codBanco) {
                        return sprintf('%d - %s', $codBanco->getNumBanco(), $codBanco->getNomBanco());
                    },
                    'attr' => [
                        'class' => 'select2-parameters',
                    ],
                ]
            )
            ->add(
                'fkMonetarioTipoConvenio',
                null,
                [
                    'label' => 'label.monetarioConvenio.codTipo',
                ],
                'entity',
                [
                    'attr' => [
                        'class' => 'select2-parameters',
                    ],
                ]
            )
            ->add('numConvenio', null, ['label' => 'label.monetarioConvenio.numConvenio']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'fkMonetarioTipoConvenio',
                null,
                [
                    'label' => 'label.monetarioConvenio.codTipo',
                ],
                'entity',
                [
                    'attr' => [
                        'class' => 'select2-parameters',
                    ],
                ]
            )
            ->add('numConvenio', null, ['label' => 'label.monetarioConvenio.numConvenio']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $convenio = $this->getSubject();

        $fieldOptions['fkMonetarioTipoConvenio'] = [
            'required' => true,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.monetarioConvenio.codTipo',
        ];

        $fieldOptions['numConvenio'] = [
            'required' => true,
            'label' => 'label.monetarioConvenio.numConvenio',
            'attr' => [
                'class' => 'numeric '
            ],
        ];

        $fieldOptions['taxaBancaria'] = [
            'required' => true,
            'label' => 'label.monetarioConvenio.taxaBancaria',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ],
        ];

        $fieldOptions['contaCorrente'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Monetario/Convenio/conta_corrente_edit.html.twig',
            'data' => [
                'itens' => null,
                'bancos' => null,
            ],
        ];

        $fieldOptions['cedente'] = [
            'required' => true,
            'label' => 'label.monetarioConvenio.cedente',
            'attr' => [
                'class' => 'numeric '
            ],
        ];

        if ($convenio->getCodConvenio() && $contaCorrenteConvenios = $convenio->getFkMonetarioContaCorrenteConvenios()) {
            $fieldOptions['fkMonetarioTipoConvenio']['disabled'] = true;
            $fieldOptions['numConvenio']['disabled'] = true;

            $qb = $this->modelManager
                ->getEntityManager($this->getClass())
                ->getRepository(Banco::class)
                ->createQueryBuilder('bancos')
                ->orderBy('bancos.numBanco', 'ASC');
            $fieldOptions['contaCorrente']['data']['bancos'] = $qb->getQuery()->getResult();
            foreach ($contaCorrenteConvenios as $key => $contaCorrenteConvenio) {
                $banco = $contaCorrenteConvenio->getFkMonetarioContaCorrente()->getFkMonetarioAgencia()->getFkMonetarioBanco();
                $fieldOptions['contaCorrente']['data']['itens'][$key]['agencias'] = $banco->getFkMonetarioAgencias();
                $fieldOptions['contaCorrente']['data']['itens'][$key]['contaCorrentes'] = $contaCorrenteConvenio->getFkMonetarioContaCorrente()->getFkMonetarioAgencia()->getFkMonetarioContaCorrentes();
                $fieldOptions['contaCorrente']['data']['itens'][$key]['contaCorrenteConvenio'] = $contaCorrenteConvenio;
            }
        }

        $formMapper
            ->with('label.monetarioConvenio.dados')
            ->add('fkMonetarioTipoConvenio', null, $fieldOptions['fkMonetarioTipoConvenio'])
            ->add('numConvenio', IntegerType::class, $fieldOptions['numConvenio'])
            ->add('cedente', IntegerType::class, $fieldOptions['cedente'])
            ->add('taxaBancaria', MoneyType::class, $fieldOptions['taxaBancaria'])
            ->end()
            ->with('label.monetarioConvenio.contaCorrente')
            ->add('contaCorrente', 'customField', $fieldOptions['contaCorrente'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $convenio = $this->getSubject();

        $fieldOptions['contaCorrente'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Monetario/Convenio/conta_corrente_show.html.twig',
        ];

        $this->contaCorrenteConvenios = null;
        if ($convenio->getCodConvenio() && $contaCorrenteConvenios = $convenio->getFkMonetarioContaCorrenteConvenios()) {
            $this->contaCorrenteConvenios = $contaCorrenteConvenios;
        }

        $showMapper
            ->with('label.monetarioConvenio.dados')
            ->add('fkMonetarioTipoConvenio', null, ['label' => 'label.monetarioConvenio.codTipo'])
            ->add('numConvenio', null, ['label' => 'label.monetarioConvenio.numConvenio'])
            ->add('taxaBancaria', null, ['label' => 'label.monetarioConvenio.taxaBancaria'])
            ->add('cedente', null, ['label' => 'label.monetarioConvenio.cedente'])
            ->add('contaCorrente', 'customField', $fieldOptions['contaCorrente'])
            ->end();
    }

    /**
     * @param Convenio $object
     * @return void
     */
    protected function syncContaCorrenteConvenios(Convenio $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());


        foreach ($object->getFkMonetarioContaCorrenteConvenios() as $contaCorrenteConvenio) {
            if (!$this->canRemove($contaCorrenteConvenio)) {
                continue;
            }

            $object->removeFkMonetarioContaCorrenteConvenio($contaCorrenteConvenio);
        }

        $em->flush();

        foreach ((array) $this->getRequest()->get('contaCorrentes') as $contaCorrente) {
            $contaCorrenteConvenio = $em->getRepository(ContaCorrenteConvenio::class)->findOneBy([
                'codBanco' => $contaCorrente['codBanco'],
                'codAgencia' => $contaCorrente['codAgencia'],
                'codContaCorrente' => $contaCorrente['codContaCorrente'],
                'codConvenio' => $object->getCodConvenio(),
            ]);

            $contaCorrenteConvenio = $contaCorrenteConvenio ?: new ContaCorrenteConvenio();
            $contaCorrenteConvenio->setCodBanco((int) $contaCorrente['codBanco']);
            $contaCorrenteConvenio->setCodAgencia((int) $contaCorrente['codAgencia']);
            $contaCorrenteConvenio->setCodContaCorrente((int) $contaCorrente['codContaCorrente']);
            $contaCorrenteConvenio->setVariacao((int) $contaCorrente['variacao']);
            $contaCorrenteConvenio->setFkMonetarioConvenio($object);

            $object->addFkMonetarioContaCorrenteConvenio($contaCorrenteConvenio);
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getCodConvenio())
            ? (string) $object
            : $this->getTranslator()->trans('label.monetarioConvenio.modulo');
    }
}
