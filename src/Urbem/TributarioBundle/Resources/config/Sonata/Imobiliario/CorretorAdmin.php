<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Imobiliario\Corretor;
use Urbem\CoreBundle\Entity\Imobiliario\Corretagem;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Model\Imobiliario\CorretagemModel;
use Urbem\CoreBundle\Entity\SwCgm;

class CorretorAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_corretor';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/corretor';
    protected $isEdit = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('creci', null, ['label' => 'label.imobiliarioCorretagem.creci'])
            ->add(
                'fkSwCgmPessoaFisica.fkSwCgm',
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
                        $query->join("{$rootAlias}.fkSwCgm", "fkSwCgm");

                        $query->where('LOWER(fkSwCgm.nomCgm) LIKE :nomCgm');
                        $query->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value)));

                        $datagrid->setValue($property, 'LIKE', $value);
                    },
                    'placeholder' => $this->trans('label.selecione'),
                    'property' => 'fkSwCgm.nomCgm'
                ],
                [
                    'admin_code' => 'administrativo.admin.sw_cgm_pessoa_fisica'
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
            ->add('fkSwCgmPessoaFisica.fkSwCgm.nom_cgm', 'text', ['label' => 'label.nome'])
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

        $formMapper
            ->with('label.imobiliarioCorretagem.moduloCorretor')
            ->add(
                'fkImobiliarioCorretagem.creci',
                null,
                [
                    'label' => 'label.imobiliarioCorretagem.creci',
                    'required' => true,
                    'mapped' => false,
                    'data' => $creci,
                    'disabled' => $disabled
                ]
            )
            ->add(
                'fkSwCgmPessoaFisica',
                'sonata_type_model_autocomplete',
                [
                    'label'  => 'label.cgm',
                    'property' => 'nomCgm',
                    'placeholder' => $this->trans('label.selecione'),
                    'callback' => function ($admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();
                        $queryBuilder = $datagrid->getQuery();
                        $queryBuilder
                            ->join(SwCgm::class, 'swcgm', 'WITH', $queryBuilder->getRootAlias() . '.numcgm = swcgm.numcgm')
                            ->andWhere('LOWER(swcgm.nomCgm) LIKE :nomCgm')
                            ->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value)))
                        ;
                        $datagrid->setValue($property, null, $value);
                    }
                ],
                [
                    'admin_code' => 'administrativo.admin.sw_cgm_pessoa_fisica'
                ]
            )
            ->end()
        ;
    }

     /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $corretagem = new Corretagem();
        $corretagem->setCreci($this->getForm()->get('fkImobiliarioCorretagem__creci')->getData());

        $em->persist($corretagem);
        $em->flush();

        $object->setCreci($this->getForm()->get('fkImobiliarioCorretagem__creci')->getData());
        $em->persist($object);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('numcgm', null, ['label' => 'label.cgm'])
            ->add('creci', null, ['label' => 'label.imobiliarioCorretagem.creci'])
            ->add('fkSwCgmPessoaFisica.fkSwCgm.nom_cgm', null, ['label' => 'label.nome'])
        ;
    }

    /**
    * @param mixed $object
    * @return string
    */
    public function toString($object)
    {
        return ($object->getNumCgm())
            ? (string) $object
            : $this->getTranslator()->trans('label.imobiliarioCorretagem.moduloCorretor');
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $creci = $this->getForm()->get('fkImobiliarioCorretagem__creci')->getData();
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
            $errorElement->with('fkImobiliarioCorretagem__creci')->addViolation($error)->end();
        }
    }
}
