<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Pessoal\Caged;
use Urbem\CoreBundle\Entity\Pessoal\CasoCausa;
use Urbem\CoreBundle\Entity\Pessoal\CausaAfastamentoMte;
use Urbem\CoreBundle\Entity\Pessoal\CausaRescisao;
use Urbem\CoreBundle\Entity\Pessoal\CausaRescisaoCaged;
use Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Doctrine\ORM\EntityRepository;

class CausaRescisaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_causa_rescisao';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/causa-rescisao';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numCausa', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'delete' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'],
                ]
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numCausa', 'text', ['label' => 'label.codigo'])
            ->add('descricao', 'text', ['label' => 'label.causaRescisao.descricao'])
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

        $fieldOptions = [];

        $fieldOptions['numCausa'] = [
            'label' => 'label.codigo',
            'required' => true
        ];

        $fieldOptions['descricao'] = [
            'label' => 'label.causaRescisao.descricao',
            'required' => true
        ];

        $fieldOptions['fkPessoalMovSefipSaida'] = [
            'class' => MovSefipSaida::class,
            'choice_label' => function ($movSefipSaida) {
                return $movSefipSaida->getFkPessoalSefip()
                ->getNumSefip()
                . " - " .
                $movSefipSaida->getFkPessoalSefip()
                ->getDescricao();
            },
            'placeholder' => 'label.selecione',
            'label' => 'label.causaRescisao.sefip',
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'query_builder' => function (EntityRepository $er) {
                return $er->listaFkPessoalMovSefipSaida();
            },
        ];

        $fieldOptions['codCaged'] = [
            'class' => Caged::class,
            'choice_label' => function ($caged) {
                return $caged->getNumCaged()
                . " - " .
                $caged->getDescricao();
            },
            'placeholder' => 'label.selecione',
            'label' => 'label.causaRescisao.caged',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->andWhere("c.tipo = 'D'");
            }
        ];

        $fieldOptions['fkPessoalCausaAfastamentoMte'] = [
            'class' => CausaAfastamentoMte::class,
            'choice_label' => function ($causaAfastamentoMte) {
                return $causaAfastamentoMte->getCodCausaAfastamento()
                . " - " .
                $causaAfastamentoMte->getNomCausaAfastamento();
            },
            'placeholder' => 'label.selecione',
            'label' => 'label.causaRescisao.causa',
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        if ($this->id($this->getSubject())) {
            $em = $this->getEntityManager();
            $fieldOptions['numCausa']['disabled'] = true;
        }

        $formMapper
            ->with('label.causaRescisao.modulo')
                ->add(
                    'numCausa',
                    'number',
                    $fieldOptions['numCausa']
                )
                ->add(
                    'descricao',
                    'text',
                    $fieldOptions['descricao']
                )
                ->add(
                    'fkPessoalMovSefipSaida',
                    'entity',
                    $fieldOptions['fkPessoalMovSefipSaida']
                )
                ->add(
                    'codCaged',
                    'entity',
                    $fieldOptions['codCaged']
                )
                ->add(
                    'fkPessoalCausaAfastamentoMte',
                    'entity',
                    $fieldOptions['fkPessoalCausaAfastamentoMte']
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
    }

    public function prePersist($object)
    {
        $entityManager = $this->getEntityManager();
        $codCausaRescisao = $entityManager->getRepository(CausaRescisao::class)
        ->getNextCodCausaRescisao();

        $object->setCodCausaRescisao($codCausaRescisao);

        $fkPessoalCaged = $this->getForm()->get('codCaged')->getData();

        if ($fkPessoalCaged) {
            $causaRescisaoCaged = new CausaRescisaoCaged();
            $causaRescisaoCaged->setFkPessoalCausaRescisao($object);
            $causaRescisaoCaged->setFkPessoalCaged($fkPessoalCaged);
        }

        $object->addFkPessoalCausaRescisaoCageds($causaRescisaoCaged);
    }

    public function postPersist($object)
    {
    }

    public function preUpdate($object)
    {
        $id = $this->getAdminRequestId();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $causaRescisao = $em->getRepository(CausaRescisao::class)->find($id);
        foreach ($causaRescisao->getFkPessoalCausaRescisaoCageds() as $caged) {
            $object->removeFkPessoalCausaRescisaoCageds($caged);
        }

        $form = $this->getForm();

        if ($form->get('numCausa')->getData() != null) {
            $causaRescisaoModel = new CausaRescisaoCaged($em);
            $causaRescisao  = $causaRescisaoModel->setFkPessoalCausaRescisao($object);
            $caged = $em->getRepository(Caged::class)
                ->findOneByNumCaged(
                    $form->get('numCausa')
                        ->getData()
                        ->getNumCaged()
                );

            $causaRescisao->setFkPessoalCaged($caged);

            $object->addFkPessoalCausaRescisaoCageds($causaRescisao);
        }
    }

    public function postUpdate($object)
    {
        $this->forceRedirect("/recursos-humanos/pessoal/causa-rescisao/{$object->getCodCausaRescisao()}/show");
    }
}
