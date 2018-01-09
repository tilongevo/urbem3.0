<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\Entity;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Licitacao\Convenio;
use Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao;
use Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ConvenioModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ParticipanteConvenioModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ParticipanteConvenioAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_convenio_participante';
    protected $baseRoutePattern = 'patrimonial/licitacao/convenio/participante';

    protected $includeJs = [
        '/patrimonial/javascripts/licitacao/convenio-participante.js'
    ];

    protected $exibirBotaoExcluir = false;

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->clearExcept(['create', 'edit', 'delete', 'list']);
    }

    /**
     * @param EntityManager $entityManager
     * @return Convenio
     */
    private function buildAditionalInfoForForm(EntityManager $entityManager)
    {
        $exercicio = $this->getRequest()->get('exercicio');
        $numConvenio = $this->getRequest()->get('num_convenio');

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->get($this->getUniqid());
            $exercicio = $formData['exercicio'];
            $numConvenio = $formData['numConvenio'];
        }

        $convenio = $entityManager
            ->getRepository(Convenio::class)
            ->findOneBy([
                'numConvenio' => $numConvenio,
                'exercicio' => $exercicio
            ]);

        if (is_null($this->getAdminRequestId()) == false) {
            /** @var ParticipanteConvenio $participanteConvenio */
            $participanteConvenio = $this->getObject($this->getAdminRequestId());
            $convenio = $participanteConvenio->getFkLicitacaoConvenio();
        }

        $convenioModel = new ConvenioModel($entityManager);

        if (!is_null($convenio)) {
            $convenio->totais = $convenioModel->getValorEPercentualConvenioDisponivel($convenio);
        }

        return $convenio;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->modelManager;

        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var ParticipanteConvenio $participanteConvenio */
        $participanteConvenio = $this->getSubject();
        $percentualParticipacao = !is_null($participanteConvenio) ? $participanteConvenio->getPercentualParticipacao() / 100 : 0;

        $convenioObjectKey = $this->request->get('convenio');
        $uniqid = $this->request->get('uniqid');

        if (false == is_null($uniqid)) {
            $formData = $this->request->get($uniqid);
            $convenioObjectKey = $formData['convenio'];
        }

        if ($this->request->get('_sonata_name') != ($this->baseRouteName . '_edit')) {
            /** @var Convenio $convenio */
            $convenio = $modelManager->find(Convenio::class, $convenioObjectKey);
        } else {
            $convenio = $participanteConvenio->getFkLicitacaoConvenio();
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

        $formMapperOptions['fkLicitacaoParticipanteCertificacao'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => ParticipanteCertificacao::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repository, $term, Request $request) {
                $queryBuilder = $repository->createQueryBuilder('participanteCertificacao');
                $queryBuilder
                    ->join('participanteCertificacao.fkSwCgm', 'fkSwCgm')
                    ->where(
                        $queryBuilder->expr()->like(
                            $queryBuilder->expr()->lower('fkSwCgm.nomCgm'),
                            $queryBuilder->expr()->lower(':term')
                        )
                    )
                    ->setParameter('term', '%' . $term . '%')
                    ->orderBy('fkSwCgm.nomCgm');

                return $queryBuilder;
            },
            'label' => 'label.convenioAdmin.participantes.cgmFornecedor',
            'json_choice_label' => function (ParticipanteCertificacao $participanteCertificacao) {
                return (string) $participanteCertificacao->getFkSwCgm();
            }
        ];

        $formMapperOptions['codTipoParticipante'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choice_label' => 'descricao',
            'label' => 'label.convenioAdmin.participantes.codTipoParticipante',
            'placeholder' => 'label.selecione',
            'required' => true
        ];

        $formMapperOptions['valorParticipacao'] = [
            'attr' => [
                'class' => 'money '
            ],
            'currency' => 'BRL',
            'grouping' => false,
            'label' => 'label.convenioAdmin.participantes.valorParticipacao'
        ];

        $formMapperOptions['percentualParticipacao'] = [
            'attr' => [
                'class' => 'percent ',
                'disabled' => 'disabled'
            ],
            'data' => (float) $percentualParticipacao,
            'label' => 'label.convenioAdmin.participantes.percentualParticipacao',
            'type' => 'fractional'
        ];

        $formMapperOptions['funcao'] = [
            'label' => 'label.convenioAdmin.participantes.funcao'
        ];

        $formMapperOptions['convenio']['mapped'] = false;
        $formMapperOptions['valorConvenio']['mapped'] = false;

        if (!is_null($convenio)) {
            $convenio->totais = (new ConvenioModel($entityManager))->getValorEPercentualConvenioDisponivel($convenio);

            $formMapperOptions['convenio']['data'] = $this->id($convenio);
            $formMapperOptions['valorConvenio']['data'] = $convenio->getValor();
        }

        $formMapper
            ->with('label.convenioAdmin.convenio')
            ->add('convenioInfo', 'customField', $formMapperOptions['convenioInfo'])
            ->end()
            ->with('label.convenioAdmin.participantes.participante')
            ->add('fkLicitacaoParticipanteCertificacao', 'autocomplete', $formMapperOptions['fkLicitacaoParticipanteCertificacao'])
            ->add('fkLicitacaoTipoParticipante', null, $formMapperOptions['codTipoParticipante'])
            ->add('valorParticipacao', 'money', $formMapperOptions['valorParticipacao'])
            ->add('percentualParticipacao', 'percent', $formMapperOptions['percentualParticipacao'])
            ->add('funcao', 'text', $formMapperOptions['funcao'])
            ->add('convenio', 'hidden', $formMapperOptions['convenio'])
            ->add('valorConvenio', 'hidden', $formMapperOptions['valorConvenio'])
            ->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param ParticipanteConvenio $participanteConvenio
     */
    public function validate(ErrorElement $errorElement, $participanteConvenio)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->modelManager;

        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $participanteConvenioModel = new ParticipanteConvenioModel($entityManager);

        /** @var ParticipanteConvenio $participanteConvenioClone */
        $participanteConvenioClone = $modelManager->findOneBy(ParticipanteConvenio::class, [
            'exercicio' => $participanteConvenio->getExercicio(),
            'numConvenio' => $participanteConvenio->getNumConvenio(),
            'cgmFornecedor' => $participanteConvenio->getCgmFornecedor()
        ]);

        $originalEntityData = $entityManager->getUnitOfWork()->getOriginalEntityData($participanteConvenio);

        if (!is_null($participanteConvenioClone)
            && $this->request->get('_sonata_name') != ($this->baseRouteName . '_edit')
        ) {
            $message =
                $this->trans('participante_convenio.errors.whenHasAnotherParticipanteConvenioSavedWithSameData', [
                    '%participante%' =>
                        $participanteConvenioClone->getFkLicitacaoParticipanteCertificacao()->getFkSwCgm()
                ], 'validators');

            $errorElement->addViolation($message)->with('fkLicitacaoParticipanteCertificacao')->end();
        }

        $convenioKey = $this->getForm()->get('convenio')->getData();
        $valorParticipacao = $this->getForm()->get('valorParticipacao')->getData();
        $valorConvenioKey = $this->getForm()->get('valorConvenio')->getData();

        if (isset($convenioKey)
            && !empty($convenioKey)
        ) {

            /** @var Convenio $convenio */
            $convenio = $this->modelManager->find(Convenio::class, $convenioKey);
        }

        if (isset($valorParticipacao)
            && !empty($valorParticipacao)
        ) {
            $percentualParticipacao = $valorParticipacao / $valorConvenioKey * 100;
            $participanteConvenio->setPercentualParticipacao($percentualParticipacao);
        }

        $valorConvenio = abs($convenio->getValor());
        $valoresDisponiveis = (new ConvenioModel($entityManager))->getValorEPercentualConvenioDisponivel($convenio);

        if (!empty($originalEntityData)) {
            $valoresDisponiveis['valorDisponivel'] += $originalEntityData['valorParticipacao'];
        }

        if ($valorParticipacao == '0.0' || $valorParticipacao == '') {
            $message =
                $this->trans('participante_convenio.errors.zeroValue', [], 'validators');

            $errorElement->addViolation($message)->with('valorParticipacao')->end();
        }

        /** Valida se o valor concedido ao participante é maior que o valor do convenio */
        if ($valorConvenio < $valorParticipacao
            || ((string) $valoresDisponiveis['valorDisponivel']) < $valorParticipacao
        ) {
            $message =
                $this->trans('participante_convenio.errors.whenValorGreaterThanValorDisponivel', [], 'validators');

            $errorElement->addViolation($message)->with('valorParticipacao')->end();
        }
    }

    /**
     * @param ParticipanteConvenio $participanteConvenio
     */
    public function prePersist($participanteConvenio)
    {
        $convenioKey = $this->getForm()->get('convenio')->getData();

        /** @var Convenio $convenio */
        $convenio = $this->modelManager->find(Convenio::class, $convenioKey);

        $participanteConvenio->setFkLicitacaoConvenio($convenio);
    }

    /**
     * Redireciona para a página show do Convenio
     *
     * @param Convenio $convenio
     */
    protected function redirectToConvenio(Convenio $convenio)
    {
        $this->redirectByRoute("urbem_patrimonial_licitacao_convenio_show", [
            'id' => $this->getObjectKey($convenio)
        ]);
    }

    /**
     * @param ParticipanteConvenio $participanteConvenio
     */
    public function postPersist($participanteConvenio)
    {
        $this->redirectToConvenio($participanteConvenio->getFkLicitacaoConvenio());
    }

    /**
     * @param ParticipanteConvenio $participanteConvenio
     */
    public function postUpdate($participanteConvenio)
    {
        $this->redirectToConvenio($participanteConvenio->getFkLicitacaoConvenio());
    }

    /**
     * @param ParticipanteConvenio $participanteConvenio
     */
    public function postRemove($participanteConvenio)
    {
        $this->redirectToConvenio($participanteConvenio->getFkLicitacaoConvenio());
    }
}
