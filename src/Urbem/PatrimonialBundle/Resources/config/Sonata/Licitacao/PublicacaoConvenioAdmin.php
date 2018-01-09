<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ConvenioModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Sonata\AdminBundle\Route\RouteCollection;

use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class PublicacaoConvenioAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class PublicacaoConvenioAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_convenio_publicacao';
    protected $baseRoutePattern = 'patrimonial/licitacao/convenio/publicacao';

    /**
     * @param RouteCollection $routeCollection
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->remove('batch');
        $routeCollection->remove('show');
        $routeCollection->remove('export');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numPublicacao')
            ->add('observacao')
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param Licitacao\PublicacaoConvenio $publicacaoConvenio
     */
    public function validate(ErrorElement $errorElement, $publicacaoConvenio)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $convenioModel = new ConvenioModel($entityManager);
        $convenio = $convenioModel->getOneByExercicioAndNumConvenio(
            $this->getForm()->get('numConvenio')->getData(),
            $this->getForm()->get('exercicio')->getData()
        );

        $redirectVeiculoPublicidadeAlreadyInUse = function (ErrorElement $errorElement) {
            $container = $this->getConfigurationPool()->getContainer();
            $message = $this->trans('publicacao_convenio.errors.whenVeiculoPublicidadeAlreadyInUse', [], 'validators');

            $container->get('session')
                ->getFlashBag()
                ->add('error', $message);

            $errorElement->with('fkLicitacaoVeiculosPublicidade')->addViolation(' ')->end();
            $errorElement->with('dtPublicacao')->addViolation(' ')->end();
        };

        if (is_null($publicacaoConvenio->getFkLicitacaoConvenio())) {
            $veiculoPublicidadeExiste = $convenioModel->veiculoPublicidadeExiste($convenio, $publicacaoConvenio->getFkLicitacaoVeiculosPublicidade(), $publicacaoConvenio->getDtPublicacao());

            if ($veiculoPublicidadeExiste == true) {
                $redirectVeiculoPublicidadeAlreadyInUse($errorElement);
            }
        } else {
            /** @var Licitacao\PublicacaoConvenio $publicacaoConvenioCadastrado */
            $publicacaoConvenioCadastrado = $entityManager
                ->getRepository(Licitacao\PublicacaoConvenio::class)
                ->findOneBy([
                    'numConvenio' => $publicacaoConvenio->getFkLicitacaoConvenio()->getNumConvenio(),
                    'exercicio' => $publicacaoConvenio->getFkLicitacaoConvenio()->getExercicio(),
                    'dtPublicacao' => $publicacaoConvenio->getDtPublicacao()
                ]);

            if (!is_null($publicacaoConvenioCadastrado) && $publicacaoConvenio->getNumcgm() != $publicacaoConvenioCadastrado->getNumcgm()) {
                $veiculoPublicidadeExiste = $convenioModel->veiculoPublicidadeExiste($convenio, $publicacaoConvenio->getFkLicitacaoVeiculosPublicidade(), $publicacaoConvenio->getDtPublicacao());

                if ($veiculoPublicidadeExiste == true) {
                    $redirectVeiculoPublicidadeAlreadyInUse($errorElement);
                }
            }
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $exercicio = $this->getRequest()->get('exercicio');
        $numConvenio = $this->getRequest()->get('num_convenio');

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->get($this->getUniqid());
            $exercicio = $formData['exercicio'];
            $numConvenio = $formData['numConvenio'];
        }

        if (is_null($id)) {
            /** @var Licitacao\Convenio $convenio */
            $convenio = $entityManager
                ->getRepository(Licitacao\Convenio::class)
                ->findOneBy([
                    'numConvenio' => $numConvenio,
                    'exercicio' => $exercicio
                ]);
        } else {
            /** @var Licitacao\PublicacaoConvenio $publicacaoConvenio */
            $publicacaoConvenio = $this->getObject($id);
            /** @var Licitacao\Convenio $convenio */
            $convenio = $publicacaoConvenio->getFkLicitacaoConvenio();
        }

        $formMapperOptions = [];

        $formMapperOptions['numcgm'] = [
            'label' => 'label.convenioAdmin.publicacoes.numcgm',
            'class' => Licitacao\VeiculosPublicidade::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repository, $term, Request $request) {
                $queryBuilder = $repository->createQueryBuilder('vp');
                $queryBuilder
                    ->join('vp.fkSwCgm', 'cgm');
                if (!is_numeric($term)) {
                    $queryBuilder->where(
                        $queryBuilder->expr()->like(
                            $queryBuilder->expr()->lower('cgm.nomCgm'),
                            $queryBuilder->expr()->lower(':term')
                        )
                    )
                        ->setParameter('term', '%'.$term.'%');
                } else {
                    $term = (int) $term;
                    $queryBuilder
                        ->where('cgm.numcgm = :term')
                        ->setParameter('term', $term);
                }

                $queryBuilder->orderBy('cgm.nomCgm');
                return $queryBuilder;
            },
            'json_choice_label' => function (Licitacao\VeiculosPublicidade $veiculosPublicidade) {
                $swCgm = $veiculosPublicidade->getFkSwCgm();
                return $swCgm->getNumcgm() . " - " . $swCgm->getNomCgm();
            }
        ];

        $now = new \DateTime();
        $formMapperOptions['dtPublicacao'] = [
            'dp_default_date' => $now->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'label' => 'label.convenioAdmin.publicacoes.dtPublicacao',
            'required' => true,
        ];

        $formMapperOptions['numPublicacao']['label'] = 'label.convenioAdmin.publicacoes.numPublicacao';
        $formMapperOptions['observacao']['label'] = 'label.convenioAdmin.publicacoes.observacao';

        $formMapper->with('label.convenioAdmin.publicacoes.publicacao');

        if (!is_null($convenio)) {
            $formMapperOptions['numConvenio'] = [
                'data' => $convenio->getNumConvenio()
            ];

            $formMapperOptions['exercicio'] = [
                'data' => $convenio->getExercicio()
            ];

            $formMapper
                ->add('numConvenio', 'hidden', $formMapperOptions['numConvenio'])
                ->add('exercicio', 'hidden', $formMapperOptions['exercicio'])
            ;
        }

        $formMapper
            ->add('fkLicitacaoVeiculosPublicidade', 'autocomplete', $formMapperOptions['numcgm'], ['admin_code' => 'core.admin.veiculos_publicidade'])
            ->add('dtPublicacao', 'datepkpicker', $formMapperOptions['dtPublicacao'])
            ->add('numPublicacao', null, $formMapperOptions['numPublicacao'])
            ->add('observacao', null, $formMapperOptions['observacao'])
        ;

        $formMapper->end();
    }

    /**
     * @param Licitacao\PublicacaoConvenio $publicacaoConvenio
     */
    public function prePersist($publicacaoConvenio)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $numConvenio = $this->getForm()->get('numConvenio')->getData();
        $exercicio = $this->getForm()->get('exercicio')->getData();

        $convenioModel = new ConvenioModel($entityManager);
        $convenio = $convenioModel->getOneByExercicioAndNumConvenio($numConvenio, $exercicio);

        $publicacaoConvenio->setFkLicitacaoConvenio($convenio);
    }

    /**
     * @param Licitacao\PublicacaoConvenio $publicacaoConvenio
     * @param string $message
     *
     * @return RedirectResponse
     */
    protected function redirect(Licitacao\PublicacaoConvenio $publicacaoConvenio)
    {
        $urlId = $this->getObjectKey($publicacaoConvenio->getFkLicitacaoConvenio());
        $this->forceRedirect("/patrimonial/licitacao/convenio/{$urlId}/show");
    }

    /**
     * @param Licitacao\PublicacaoConvenio $publicacaoConvenio
     */
    public function postPersist($publicacaoConvenio)
    {
        $this->redirect($publicacaoConvenio);
    }

    /**
     * @param Licitacao\PublicacaoConvenio $publicacaoConvenio
     */
    public function postUpdate($publicacaoConvenio)
    {
        $this->redirect($publicacaoConvenio);
    }

    /**
     * @param Licitacao\PublicacaoConvenio $publicacaoConvenio
     */
    public function postRemove($publicacaoConvenio)
    {
        $this->redirect($publicacaoConvenio);
    }
}
