<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao;
use Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade;
use Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CompraDiretaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CompraDiretaProcessoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaModel;
use Urbem\CoreBundle\Model\SwProcessoModel;

/**
 * Class PenalidadesCertificacaoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class PenalidadesCertificacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_penalidades_certificacao';
    protected $baseRoutePattern = 'patrimonial/licitacao/penalidades-certificacao';
    protected $exibirBotaoIncluir = false;

    /**
     * @param ErrorElement $errorElement
     * @param mixed $penalidadeCertificacao
     */
    public function validate(ErrorElement $errorElement, $penalidadeCertificacao)
    {
        $container = $this->getConfigurationPool()->getContainer();
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $penalidade = $this->getForm()->get('fkLicitacaoPenalidade')->getData();
        list($numCertificacao, $exercicio, $cgmFornecedor) = explode('~', $this->getForm()->get('numHCertificacao')->getData());

        $penalidadeCertificacaoRepository = $em->getRepository(PenalidadesCertificacao::class);
        $objPenalidadeCertificacao = $penalidadeCertificacaoRepository->findOneBy(
            [
                'codPenalidade' => $penalidade,
                'exercicio' => $exercicio,
                'cgmFornecedor' => $cgmFornecedor,
                'numCertificacao' => $numCertificacao
            ]
        );

        if (!is_null($objPenalidadeCertificacao) && $objPenalidadeCertificacao->getFkLicitacaoPenalidade() == $penalidadeCertificacao->getFkLicitacaoPenalidade()) {
            $message = $this->trans(
                'licitacao.penalidadeCertificacao.errors.penalidadeEmUso',
                [
                    '%penalidade%' => $objPenalidadeCertificacao->getFkLicitacaoPenalidade()
                ],
                'validators'
            );
            $errorElement->with('fkLicitacaoPenalidade')->addViolation($message)->end();
        }
    }

    /**
     * @param PenalidadesCertificacao $penalidadeCertificacao
     */
    public function prePersist($penalidadeCertificacao)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());
        list($numCertificado, $exercicio, $cgmFornecedor) = explode('~', $formData['numHCertificacao']);
        list($codProcesso, $anoExercicio) = explode('~', $formData['codProcesso']);

        $processo = $entityManager
            ->getRepository('CoreBundle:SwProcesso')
            ->findOneBy([
                'codProcesso' => $codProcesso,
                'anoExercicio' => $anoExercicio
            ]);

        /** @var ParticipanteCertificacao $pCertificacao */
        $pCertificacao = $entityManager
            ->getRepository('CoreBundle:Licitacao\ParticipanteCertificacao')
            ->findOneBy([
                'numCertificacao' => $numCertificado,
                'exercicio' => $exercicio,
                'cgmFornecedor' => $cgmFornecedor
            ]);

        /** @var ParticipanteCertificacaoPenalidade $pCertificacaoPenalidade */
        $pCertificacaoPenalidade = $entityManager
            ->getRepository('CoreBundle:Licitacao\ParticipanteCertificacaoPenalidade')
            ->findOneBy([
                'numCertificacao' => $numCertificado,
                'exercicio' => $exercicio,
                'cgmFornecedor' => $cgmFornecedor
            ]);

        $pcPenalidade = null;
        if (!is_object($pCertificacaoPenalidade)) {
            $pCertificacaoPenalidade = new ParticipanteCertificacaoPenalidade();
            $pCertificacaoPenalidade->setFkLicitacaoParticipanteCertificacao($pCertificacao);
            $pCertificacaoPenalidade->setCodTipoDocumento(0);
            $pCertificacaoPenalidade->setCodDocumento(0);
            $entityManager->persist($pCertificacaoPenalidade);
        }

        $penalidadeCertificacao->setFkLicitacaoParticipanteCertificacaoPenalidade($pCertificacaoPenalidade);
        $penalidadeCertificacao->setFkSwProcesso($processo);
    }

    /**
     * @param PenalidadesCertificacao $penalidadeCertificacao
     */
    public function preUpdate($penalidadeCertificacao)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());

        $codProcesso = '';
        if (strstr($formData['codProcesso'], '-')) {
            $codProcesso = explode(' - ', $formData['codProcesso']);
            list($codProcesso, $anoExercicio) = explode('/', $codProcesso[0]);
        } else {
            list($codProcesso, $anoExercicio) = explode('~', $formData['codProcesso']);
        }

        $processo = $entityManager
            ->getRepository('CoreBundle:SwProcesso')
            ->findOneBy([
                'codProcesso' => $codProcesso,
                'anoExercicio' => $anoExercicio
            ]);

        $penalidadeCertificacao->setFkSwProcesso($processo);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('valor')
            ->add('observacao')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('exercicio')
            ->add('valor')
            ->add('observacao');

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $id = $formData['numHCertificacao'];
        }
        list($numCertificado, $exercicio, $cgmFornecedor) = explode('~', $id);

        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $certificacao = $entityManager
            ->getRepository('CoreBundle:Licitacao\ParticipanteCertificacao')
            ->findOneBy([
                'numCertificacao' => $numCertificado,
                'exercicio' => $exercicio,
                'cgmFornecedor' => $cgmFornecedor
            ]);

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions['codProcesso'] = [
            'label' => 'label.comprasDireta.codProcesso',
            'multiple' => false,
            'mapped' => false,
            'required' => false,
            'route' => ['name' => 'carrega_sw_processo'],
            'placeholder' => 'Selecione'
        ];

        $route = $this->getRequest()->get('_sonata_name');
        if ($this->baseRouteName . "_edit" == $route) {
            $fieldOptions['codProcesso']['data'] = $this->getSubject()->getfkSwProcesso();
        }

        $formMapper
            ->add('numHCertificacao', 'hidden', ['data' => $id, 'mapped' => false])
            ->add(
                'fkLicitacaoPenalidade',
                null,
                [
                    'required' => true,
                    'label' => 'label.patrimonial.penalidades_certificacao.codPenalidade',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'placeholder' => 'label.selecione'
                ]
            )
            ->add(
                'codProcesso',
                'autocomplete',
                $fieldOptions['codProcesso']
            )
            ->add(
                'dtPublicacao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'required' => true,
                    'label' => 'label.patrimonial.penalidades_certificacao.dtPublicacao'
                ]
            )
            ->add(
                'dtValidade',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'required' => true,
                    'label' => 'label.patrimonial.penalidades_certificacao.dtValidade'
                ]
            )
            ->add('observacao', null, ['label' => 'Observações'])
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
            ->add('numCertificacao')
            ->add('exercicio')
            ->add('cgmFornecedor')
            ->add('anoExercicio')
            ->add('codProcesso')
            ->add('valor')
            ->add('dtPublicacao')
            ->add('dtValidade')
            ->add('observacao')
        ;
    }

    /**
     * @param PenalidadesCertificacao $penalidadeCertificacao
     */
    public function postPersist($penalidadeCertificacao)
    {
        $this->redirect($penalidadeCertificacao);
    }

    /**
     * @param PenalidadesCertificacao $penalidadeCertificacao
     */
    public function postUpdate($penalidadeCertificacao)
    {
        $this->redirect($penalidadeCertificacao);
    }

    /**
     * @param PenalidadesCertificacao $penalidadeCertificacao
     */
    public function postRemove($penalidadeCertificacao)
    {
        $this->redirect($penalidadeCertificacao);
    }

    /**
     * @param PenalidadesCertificacao $penalidadesCertificacao
     * @param string $type
     */
    public function redirect(PenalidadesCertificacao $penalidadesCertificacao)
    {

        $this->forceRedirect("/patrimonial/licitacao/participante-certificacao/{$this->getObjectKey($penalidadesCertificacao->getFkLicitacaoParticipanteCertificacaoPenalidade()->getFkLicitacaoParticipanteCertificacao())}/show");
    }
}
