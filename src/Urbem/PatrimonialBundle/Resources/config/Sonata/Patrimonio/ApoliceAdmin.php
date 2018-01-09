<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Patrimonio\Apolice;
use Urbem\CoreBundle\Entity\Patrimonio\ApoliceBem;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\UploadHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ApoliceAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_apolice';
    protected $baseRoutePattern = 'patrimonial/patrimonio/apolice';
    protected $includeJs = [
        '/patrimonial/javascripts/patrimonio/apolice.js',
    ];

    protected $fkPatrimonioApoliceBens = [];

    protected function createFkPatrimonioApoliceBens(Apolice $apolice)
    {
        /** @var $apoliceBem ApoliceBem */
        foreach ($apolice->getFkPatrimonioApoliceBens() as $apoliceBem) {
            if (null == $apoliceBem->getCodApolice()) {
                $this->fkPatrimonioApoliceBens[] = clone $apoliceBem;

                $apolice->removeFkPatrimonioApoliceBens($apoliceBem);
            }
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param Apolice $apolice
     */
    public function validate(ErrorElement $errorElement, $apolice)
    {
        // verifica se a data de início da vigencia é maior ou igual que a data de vencimento
        if ($apolice->getInicioVigencia() > $apolice->getDtVencimento()) {
            $message = $this->trans('apolice.errors.dataVencimentoMaiorQueDataVigencia', [], 'validators');
            $errorElement->with('dtVencimento')->addViolation($message)->end();
        }

        if ($apolice->getDtAssinatura() > $apolice->getInicioVigencia()) {
            $message = $this->trans('apolice.errors.dataAssinaturaMaiorQueVigencia', [], 'validators');
            $errorElement->with('dtAssinatura')->addViolation($message)->end();
        }

        /** @var EntityManager $doctrineServiceManager */
        $doctrineServiceManager = $this->getContainer()->get('doctrine')->getManager();
        $originalEntityData = $doctrineServiceManager->getUnitOfWork()->getOriginalEntityData($apolice);

        $originalEntityDataNumApolice =
            isset($originalEntityData['numApolice']) ? $originalEntityData['numApolice'] : null;
        $originalEntityDataNumcgm =
            isset($originalEntityData['numcgm']) ? $originalEntityData['numcgm'] : null;

        if ($originalEntityDataNumApolice != $apolice->getNumApolice()
            || $originalEntityDataNumcgm != $apolice->getNumcgm()
        ) {
            $apolices = $doctrineServiceManager
                ->getRepository(Apolice::class)
                ->findOneBy([
                    'numApolice' => $apolice->getNumApolice(),
                    'numcgm' => $apolice->getFkSwCgm()->getNumcgm()
                ]);

            if (!empty($apolices)) {
                $message = $this->trans('apolice.errors.jaExisteApoliceParaEstaSeguradora', [], 'validators');
                $errorElement->with('fkSwCgm')->addViolation($message)->end();
            }
        }
    }

    /**
     * @param Apolice $apolice
     */
    public function prePersist($apolice)
    {
        $this->preUpdate($apolice);
    }

    /**
     * @param Apolice $apolice
     */
    public function postPersist($apolice)
    {
        $em = $this->configurationPool->getContainer()->get('doctrine.orm.default_entity_manager');

        $form = $this->getForm();
        $apoliceBens = $form->get('fkPatrimonioApoliceBens')->getData();
        if (!is_null($apoliceBens)) {
            foreach ($apoliceBens as $bem) {
                $apoliceBem = new ApoliceBem();
                $apoliceBem->setFkPatrimonioApolice($apolice);
                $apoliceBem->setFkPatrimonioBem($bem);
                $em->persist($apoliceBem);
            }
            $em->flush();
        }
    }

    /**
     * @param Apolice $apolice
     */
    public function preUpdate($apolice)
    {
        if ($apolice->getNomeArquivo() !== null) {
            $container = $this->getConfigurationPool()->getContainer();
            $apolices = $container->getParameter("patrimonialbundle");

            $upload = new UploadHelper();
            $upload->setPath($apolices['apolice']);
            $upload->setFile($apolice->getNomeArquivo());
            $arquivo = $upload->executeUpload();
            $apolice->setNomeArquivo($arquivo['name']);
        }

        /** @var $apoliceBem ApoliceBem */
        foreach ($apolice->getFkPatrimonioApoliceBens() as $apoliceBem) {
            if (null !== $apoliceBem->getCodApolice()) {
                $apolice->removeFkPatrimonioApoliceBens($apoliceBem);
            }
        }
    }

    /**
     * @param Apolice $apolice
     */
    public function postUpdate($apolice)
    {
        $this->postPersist($apolice);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numApolice', null, ['label' => 'Número Apólice'])
            ->add('contato');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numApolice', 'number', ['label' => 'Número da apólice', 'sortable' => false])
            ->add('fkSwCgm', null, array(
                'label' => 'Seguradora',
                'associated_property' => function ($numcgm) {
                    return $numcgm->getNomCgm();
                }
            ))
            ->add('dtVencimento', 'date', ['label' => 'Data de vencimento', 'sortable' => false])
            ->add('contato', 'text', ['label' => 'Contato', 'sortable' => false])
            ->add('dtAssinatura', 'date', ['label' => 'Data de assinatura', 'sortable' => false])
            ->add('inicioVigencia', 'date', ['label' => 'Data da vigência', 'sortable' => false]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var Apolice $apolice */
        $apolice = $this->getSubject();

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $id = $this->getAdminRequestId();

        $now = new\DateTime();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $route = $this->getRequest()->get('_sonata_name');

        $fieldOptions['swCgm'] = [
            'label' => 'label.apolice.fornecedor',
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repository, $term, Request $request) {
                $queryBuilder = $repository->createQueryBuilder('swCgm');
                $queryBuilder
                    ->join('swCgm.fkSwCgmPessoaJuridica', 'fkSwCgmPessoaJuridica');
                if (!is_numeric($term)) {
                    $queryBuilder->where(
                        $queryBuilder->expr()->like(
                            $queryBuilder->expr()->lower('swCgm.nomCgm'),
                            $queryBuilder->expr()->lower(':term')
                        )
                    )
                        ->setParameter('term', '%'.$term.'%');
                } else {
                    $term = (int) $term;
                    $queryBuilder
                        ->where('swCgm.numcgm = :term')
                        ->setParameter('term', $term);
                }

                $queryBuilder->orderBy('swCgm.nomCgm');
                return $queryBuilder;
            }
        ];

        $fieldOptions['fkPatrimonioApoliceBens'] = [
            'label' => 'Bens',
            'multiple' => true,
            'mapped' => false,
            'required' => false,
            'class' => Bem::class,
            'route' => ['name' => 'patrimonio_carrega_bem']
        ];
        $fieldOptions['nomeArquivo'] = [
            'data_class' => null,
            'required' => false
        ];

        /** @var Apolice $apolice */
        $apolice = $this->getSubject();
        $apoliceBem = [];
        if (!is_null($route)) {
            if (null !== $apolice->getFkPatrimonioApoliceBens()) {
                /** @var ApoliceBem $apoliceBens */
                foreach ($apolice->getFkPatrimonioApoliceBens() as $apoliceBens) {
                    $apoliceBem[] = $apoliceBens->getFkPatrimonioBem();
                }

                $fieldOptions['fkPatrimonioApoliceBens']['data'] = $apoliceBem;
            }
        }

        if ($apolice) {
            if (($apolice->getNomeArquivo() != "") && ($apolice->getNomeArquivo() != null)) {
                $container = $this->getConfigurationPool()->getContainer();
                $normasPath = $container->getParameter("patrimonialbundle");

                $fullPath = $normasPath['apoliceDownload'] . $apolice->getNomeArquivo();

                $fieldOptions['nomeArquivo']['help'] = '<a href="' . $fullPath . '">' . $apolice->getNomeArquivo() . '</a>';
            }
        }


        $formMapper
            ->with('Apólice')
            ->add(
                'numApolice',
                'text',
                [
                    'label' => 'label.apolice.numeroApolice'
                ]
            )
            ->add(
                'fkSwCgm',
                'autocomplete',
                $fieldOptions['swCgm'],
                ['admin_code' => 'core.admin.filter.sw_cgm']
            )
            ->add(
                'inicioVigencia',
                'sonata_type_date_picker',
                [
                    'dp_default_date' => $now->format('d/m/Y'),
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.apolice.inicioVigencia'
                ]
            )
            ->add(
                'dtVencimento',
                'sonata_type_date_picker',
                [
                    'dp_default_date' => $now->format('d/m/Y'),
                    'dp_min_date' => $now->format('d/m/Y'),
                    'dp_use_current' => true,
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.apolice.dtVencimento'
                ]
            )
            ->add(
                'dtAssinatura',
                'sonata_type_date_picker',
                [
                    'dp_default_date' => $now->format('d/m/Y'),
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.apolice.dtAssinatura'
                ]
            )
            ->add(
                'valorApolice',
                null,
                [
                    'label' => 'label.apolice.valorApolice',
                    'attr' => ['class' => 'money '],
                    'required' => false,
                ]
            )
            ->add(
                'valorFranquia',
                null,
                [
                    'label' => 'label.apolice.valorFranquia',
                    'attr' => ['class' => 'money '],
                    'required' => false,
                ]
            )
            ->add(
                'observacoes',
                'textarea',
                [
                    'label' => 'label.apolice.observacoes',
                    'required' => false,
                ]
            )
            ->add(
                'contato',
                'text',
                [
                    'label' => 'label.apolice.contato'
                ]
            )
            ->add(
                'nomeArquivo',
                'file',
                $fieldOptions['nomeArquivo']
            )
            ->end()
            ->with('Bem Segurado')
            ->add(
                'fkPatrimonioApoliceBens',
                'autocomplete',
                $fieldOptions['fkPatrimonioApoliceBens'],
                [
                    'admin_code' => 'app.admin.patrimonial.bem'
                ]
            )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('numApolice', null, ['label' => 'Número da apólice', 'sortable' => false])
            ->add('fkSwCgm', null, array(
                'label' => 'Seguradora',
                'associated_property' => function ($numcgm) {
                    return $numcgm->getNomCgm();
                }
            ))
            ->add('inicioVigencia', null, ['label' => 'label.apolice.inicioVigencia'])
            ->add('dtVencimento', null, ['label' => 'Data de vencimento', 'sortable' => false])
            ->add('dtAssinatura', null, ['label' => 'Data de assinatura', 'sortable' => false])
            ->add('valorApolice', null, ['label' => 'label.apolice.valorApolice'])
            ->add('valorFranquia', null, ['label' => 'label.apolice.valorFranquia'])
            ->add('observacoes', null, ['label' => 'Observações', 'sortable' => false])
            ->add('contato', null, ['label' => 'label.apolice.contato'])
            ->add('nomeArquivo')
            ->add('fkPatrimonioApoliceBens', null, array(
                'associated_property' => function ($apoliceBens) {
                    return $apoliceBens->getFkPatrimonioBem();
                },
                'label' => 'Bens'
            ));
    }
}
