<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Licitacao\Convenio;
use Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoConvenio;
use Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ConvenioModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\RescisaoConvenioModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class RescisaoConvenioAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class RescisaoConvenioAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_rescisao_convenio';
    protected $baseRoutePattern = 'patrimonial/licitacao/convenio/rescisao';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->clearExcept(['create']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $convenioObjectKey = $this->request->get('convenio');

        if (!$this->request->isMethod('GET')) {
            $formData = $this->request->get($this->getUniqid());
            $convenioObjectKey = $formData['convenio'];
        }

        /** @var Convenio $convenio */
        $convenio = $this->modelManager->find(Convenio::class, $convenioObjectKey);

        /** @var RescisaoConvenio $rescisaoConvenio */
        $rescisaoConvenio = $this->getSubject();

        if (!is_null($rescisaoConvenio)) {
            $rescisaoConvenio->setDtRescisao(new \DateTime());
        }

        $formMapperOptions = [];
        $formMapperOptions['convenioInfo'] = [
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle::Sonata/Licitacao/ParticipanteConvenio/CRUD/field_convenioInfo.html.twig',
            'data' => [
                'convenio' => $convenio
            ]
        ];

        $formMapperOptions['convenio'] = [
            'data' => $convenioObjectKey,
            'mapped' => false
        ];

        $formMapperOptions['exercicio'] = [
            'data' => $this->getExercicio()
        ];

        $formMapperOptions['fkSwCgm'] = [
            'label' => 'label.convenioAdmin.rescisaoConvenio.responsavelJuridico',
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repository, $term, Request $request) {
                $queryBuilder = $repository->createQueryBuilder('swCgm');
                $queryBuilder
                    ->join('swCgm.fkSwCgmPessoaFisica', 'fkSwCgmPessoaFisica')
                    ->where(
                        $queryBuilder->expr()->like(
                            $queryBuilder->expr()->lower('swCgm.nomCgm'),
                            $queryBuilder->expr()->lower(':term')
                        )
                    )
                    ->setParameter('term', '%'.$term.'%')
                    ->orderBy('swCgm.nomCgm')
                ;

                return $queryBuilder;
            }
        ];

        $formMapperOptions['dtRescisao'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.convenioAdmin.rescisaoConvenio.dtRescisao'
        ];

        $formMapperOptions['vlrMulta'] = [
            'attr' => ['class' => 'money '],
            'label' => 'label.convenioAdmin.rescisaoConvenio.vlrMulta',
        ];

        $formMapperOptions['vlrIndenizacao'] = [
            'attr' => ['class' => 'money '],
            'label' => 'label.convenioAdmin.rescisaoConvenio.vlrIndenizacao',
        ];

        $formMapper
            ->with('label.convenioAdmin.convenio')
                ->add('convenioInfo', 'customField', $formMapperOptions['convenioInfo'])
            ->end()
            ->with('label.convenioAdmin.rescisaoConvenio.dadosRescisao')
                ->add('convenio', 'hidden', $formMapperOptions['convenio'])
                ->add('exercicio', 'hidden', $formMapperOptions['exercicio'])
                ->add('fkSwCgm', 'autocomplete', $formMapperOptions['fkSwCgm'])
                ->add('dtRescisao', 'sonata_type_date_picker', $formMapperOptions['dtRescisao'])
                ->add('vlrMulta', 'number', $formMapperOptions['vlrMulta'])
                ->add('vlrIndenizacao', 'number', $formMapperOptions['vlrIndenizacao'])
                ->add('motivo')
            ->end()
            ->with('label.convenioAdmin.rescisaoConvenio.veiculoPublicacao')
                ->add('fkLicitacaoPublicacaoRescisaoConvenios', 'sonata_type_collection', [
                    'by_reference' => false,
                    'label' => false
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                ])
            ->end()
        ;

        $admin = $this;
        $formMapper
            ->getFormBuilder()
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $formEvent) use ($admin) {
                $data = $formEvent->getData();

                /** @var RescisaoConvenio $rescisaoConvenio */
                $rescisaoConvenio = $admin->getSubject();

                if (isset($data['convenio'])
                    && !empty($data['convenio'])) {

                    /** @var Convenio $convenio */
                    $convenio = $admin->modelManager->find(Convenio::class, $data['convenio']);
                    $rescisaoConvenio->setFkLicitacaoConvenio($convenio);
                }
            });
    }

    /**
     * @param RescisaoConvenio $rescisaoConvenio
     */
    public function prePersist($rescisaoConvenio)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());
        $rescisaoConvenioModel = new RescisaoConvenioModel($entityManager);
        $numRescisao = $rescisaoConvenioModel->getProximoNumRescisao($rescisaoConvenio->getExercicio(), $rescisaoConvenio->getNumConvenio());

        $rescisaoConvenio->setNumRescisao($numRescisao);

        /** @var PublicacaoRescisaoConvenio $publicacaoRescisaoConvenio */
        foreach ($rescisaoConvenio->getFkLicitacaoPublicacaoRescisaoConvenios() as $publicacaoRescisaoConvenio) {
            $publicacaoRescisaoConvenio->setFkLicitacaoRescisaoConvenio($rescisaoConvenio);
        }
    }


    /**
     * {@inheritdoc}
     */
    public function postPersist($object)
    {
        $this->redirectByRoute('urbem_patrimonial_licitacao_convenio_list');
    }
}
