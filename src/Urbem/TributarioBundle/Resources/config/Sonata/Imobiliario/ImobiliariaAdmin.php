<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Entity\Imobiliario\Corretor;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Imobiliario\Corretagem;

class ImobiliariaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_imobiliaria';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/imobiliaria';
    protected $isEdit = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('creci', null, ['label' => 'label.imobiliarioCorretagem.creci'])
            ->add(
                'fkSwCgmPessoaJuridica.fkSwCgm',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.cgm',
                ],
                'sonata_type_model_autocomplete',
                [
                    'attr' => ['class' => 'select2-parameters '],
                    'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();

                        /** @var QueryBuilder|ProxyQueryInterface $query */
                        $query = $datagrid->getQuery();

                        $rootAlias = $query->getRootAlias();
                        $query->join("{$rootAlias}.fkSwCgmPessoaJuridica", "fkSwCgmPessoaJuridica");
                        $query->join("{$rootAlias}.fkSwCgm", "fkSwCgm");

                        $query->where('LOWER(fkSwCgm.nomCgm) LIKE :nomCgm');
                        $query->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value)));

                        $datagrid->setValue($property, 'LIKE', $value);
                    },
                    'placeholder' => $this->trans('label.selecione'),
                    'property' => 'fkSwCgm.nomCgm'
                ],
                [
                    'admin_code' => 'administrativo.admin.sw_cgm_admin_pj'
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
            ->add('numcgm', 'text', ['label' => 'label.cgm'])
            ->add('creci', 'text', ['label' => 'label.imobiliarioCorretagem.creci'])
            ->add('fkImobiliarioCorretor.fkSwCgmPessoaFisica.fkSwCgm.nom_cgm', 'text', ['label' => 'label.nome'])
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

        $creci = null;
        $disabled = false;
        if ($id) {
            $this->isEdit = $disabled = true;
            $creci = $this->getSubject()->getCreci();
        }

        $fieldOptions['fkSwCgmPessoaJuridica'] = array(
            'label' => 'label.cgm',
            'class' => SwCgmPessoaJuridica::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $value, $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkSwCgm', 'cgm');
                $qb->where('LOWER(cgm.nomCgm) LIKE :nomCgm');
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value)));

                return $qb;
            },
            'required' => true,
            'disabled' => $disabled
        );

        $fieldOptions['fkImobiliarioCorretor'] = array(
            'label' => 'label.responsavel',
            'class' => Corretor::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $value, $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join(SwCgmPessoaFisica::class, 'pf', 'WITH', 'o.numcgm = pf.numcgm');
                $qb->join(SwCgm::class, 'swcgm', 'WITH', 'pf.numcgm = swcgm.numcgm');

                $qb->where($qb->expr()->orX(
                    $qb->expr()->like('LOWER(swcgm.nomCgm)', ':nomCgm'),
                    $qb->expr()->eq('o.numcgm', ':numcgm')
                ));
                $qb->setParameters([
                    'nomCgm' => sprintf('%%%s%%', strtolower($value)),
                    'numcgm' => ((int) $value) ? $value: null
                ]);
                return $qb;
            },
            'required' => true,
        );

        $formMapper
            ->with('label.imobiliarioCorretagem.moduloImobiliaria')
                ->add(
                    'creci',
                    null,
                    [
                        'label' => 'label.imobiliarioCorretagem.creci',
                        'required' => true,
                        'data' => $creci,
                        'disabled' => $disabled
                    ]
                )
                ->add(
                    'fkSwCgmPessoaJuridica',
                    'autocomplete',
                    $fieldOptions['fkSwCgmPessoaJuridica']
                )
                ->add(
                    'fkImobiliarioCorretor',
                    'autocomplete',
                    $fieldOptions['fkImobiliarioCorretor']
                )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $imobiliaria = $this->getSubject();

        $showMapper
            ->add('numcgm', null, ['label' => 'label.cgm'])
            ->add('creci', null, ['label' => 'label.imobiliarioCorretagem.creci'])
            ->add(
                'fkImobiliarioCorretor.fkSwCgmPessoaFisica.fkSwCgm',
                null,
                [
                    'label' => 'label.responsavel',
                ]
            )
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $corretagem = new Corretagem();
        $corretagem->setCreci($this->getForm()->get('creci')->getData());

        $em->persist($corretagem);
        $em->flush();

        $object->setCreci($this->getForm()->get('creci')->getData());
        $em->persist($object);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $creci = $this->getForm()->get('creci')->getData();
        $em = $this->modelManager->getEntityManager($this->getClass());
        $corretagem = (new \Urbem\CoreBundle\Model\Imobiliario\CorretagemModel($em))
            ->getCorretagem($creci);

        if ($corretagem && !$this->isEdit) {
            $error = $this->getTranslator()
                ->trans(
                    'label.imobiliarioCorretagem.erroCreci',
                    [
                        '%creci%' => $creci
                    ]
                );
            $errorElement->with('creci')->addViolation($error)->end();
        }
    }

    /**
    * @param mixed $object
    * @return string
    */
    public function toString($object)
    {
        return ($object->getCreci())
            ? (string) $object
            : $this->getTranslator()->trans('label.imobiliarioCorretagem.moduloImobiliaria');
    }
}
