<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Model\Tesouraria\ArrecadacaoModel;
use Urbem\CoreBundle\Model\Tesouraria\TransferenciaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Exception\Error;

class TransferenciaEstornadaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_estorno';
    protected $baseRoutePattern = 'financeiro/tesouraria/estorno';

    protected $transferenciaEntity;

    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'id' => $this->getRequest()->get('id')
        );
    }

    /**
     * Rotas Personalizadas
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('list');
        $collection->remove('edit');
        $collection->remove('show');
        $collection->remove('delete');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $this->adminRequestId = $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $this->adminRequestId = $id = $formData['id'];
        }

        list($codLote, $exercicio, $codEntidade, $tipo) = explode("~", $id);
        $this->transferenciaEntity = $transferencia = $em->getRepository(Entity\Tesouraria\TransferenciaView::class)->findOneBy(
            ['codLote' => $codLote, 'exercicio' => $exercicio, 'codEntidade' => $codEntidade, 'tipo' => $tipo]
        );

        $formMapper
            ->with('Estorno ' . TransferenciaModel::getTipoTransferencia($transferencia->getCodTipo()))
            ->add(
                'dadosTransferencia',
                'customField',
                [
                    'label' => false,
                    'mapped' => false,
                    'template' => 'FinanceiroBundle::Tesouraria/Estorno/PagamentoArrecadacaoExtra.html.twig',
                    'data' => [
                        'transferenciaInfo' => $transferencia,
                        'tituloContaReceita' => 'Conta de despesa'
                    ],
                    'attr' => [
                        'class' => ''
                    ]
                ]
            )
            ->end()
            ->with('Dados do estorno')
            ->add(
                'codHistorico',
                'autocomplete',
                [
                    'label' => 'Histórico Padrão',
                    'multiple' => false,
                    'mapped' => false,
                    'route' => ['name' => 'tesouraria_arrecadacao_extra_busca_historico_padrao']
                ]
            )
            ->add(
                'valor',
                'number',
                [
                    'label' => 'Valor',
                    'mapped' => false,
                    'attr' => [
                        'class' => 'money '
                    ],
                ]
            )
            ->add(
                'observacao',
                'textarea',
                [
                    'label' => "Observações",
                    'mapped' => false,
                ]
            )
            ->add(
                'id',
                'hidden',
                [
                    'data' => $id,
                    'mapped' => false
                ]
            )
            ->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param Entity\Tesouraria\Transferencia $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formContent = (object) $this->getFormPost($formSonata = true);
        $transferencia = $this->transferenciaEntity;

        $saldoEstorno = $transferencia->getSaldoEstorno();
        if ($formContent->valor > $saldoEstorno) {
            $mensagem = sprintf("Valor de estorno não pode ser maior que R$ %s", $transferencia->getSaldoEstornoFormat());
            $container->get('session')->getFlashBag()->add("error", $mensagem);

            $this->forceRedirect(
                "/financeiro/tesouraria/estorno/create?id=" . $this->adminRequestId
            );
            exit;
        }

        $paramsBoletim = [
            sprintf('cod_boletim = %s', $transferencia->getCodBoletim()),
            sprintf('cod_entidade = %s', $transferencia->getCodEntidade()),
        ];
        $boletim = new Model\Tesouraria\Boletim\BoletimModel($em);
        $boletim = current($boletim->getBoletins($paramsBoletim));

        if (!$boletim) {
            $mensagem = "Boletim não encontrado para esta entidade!";
            $container->get('session')->getFlashBag()->add("error", $mensagem);

            $this->forceRedirect(
                "/financeiro/tesouraria/estorno/create?id=" . $this->adminRequestId
            );
            exit;
        }

        list($diaBoletim, $mesBoletim, $anoBoletim) = explode('/', $boletim->dt_boletim);

        // valida a utilização da rotina de encerramento do mês contábil
        $arrecadacaoModel = new ArrecadacaoModel($em);
        if (!$arrecadacaoModel->isValidBoletimMes($this->getExercicio(), $mesBoletim)) {
            $mensagem = "Não é possível utilizar esta rotina pois o mês atual está encerrado!";
            $container->get('session')->getFlashBag()->add("error", $mensagem);

            $this->forceRedirect(
                "/financeiro/tesouraria/estorno/create?id=" . $this->adminRequestId
            );
            exit;
        }
    }

    /**
     * @param Entity\Tesouraria\TransferenciaEstornada $transferenciaEstornada
     */
    public function prePersist($transferenciaEstornada)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formContent = (object) $this->getFormPost($formSonata = true);

        /** @var Entity\Tesouraria\TransferenciaView $transferencia */
        $transferencia = $this->transferenciaEntity;
        /** @var Entity\Tesouraria\Transferencia $transferenciaObj */
        $transferenciaRepository = $em->getRepository(Entity\Tesouraria\Transferencia::class);
        $transferenciaObj = $transferenciaRepository->findOneBy(
            [
                'codLote' => $transferencia->getCodLote(),
                'exercicio' => $transferencia->getExercicio(),
                'codEntidade' => $transferencia->getCodEntidade(),
                'codTipo' => $transferencia->getCodTipo()
            ]
        );

        $codHistorico = $em->getRepository(Entity\Contabilidade\HistoricoContabil::class)->findOneBy(
            ['codHistorico' => $formContent->codHistorico, 'exercicio' => $transferenciaObj->getExercicio()]
        );

        $transferenciaEstornada->setFkTesourariaTransferencia($transferenciaObj);
        $transferenciaEstornada->setFkTesourariaBoletim($transferenciaObj->getFkTesourariaBoletim());
        $transferenciaEstornada->setFkTesourariaUsuarioTerminal($transferenciaObj->getFkTesourariaUsuarioTerminal());
        $transferenciaEstornada->setFkContabilidadeHistoricoContabil($codHistorico);
        $transferenciaEstornada->setValor($formContent->valor);
        $transferenciaEstornada->setObservacao($formContent->observacao);

        $tipoLote = 'T';
        $tipoAutenticacao = 'E';
        $nomLote = sprintf(
            'Transferência - CD: %s | CC: %s',
            $transferenciaObj->getCodPlanoCredito(),
            $transferenciaObj->getCodPlanoDebito()
        );

        // Gera lote
        $codLote = $transferenciaRepository->gerarLote(
            $transferenciaObj->getExercicio(),
            $transferenciaObj->getCodEntidade(),
            $nomLote,
            $transferenciaObj->getFkTesourariaBoletim()->getDtBoletim()->format('d/m/Y')
        );
        $LoteModel = new Model\Contabilidade\LoteModel($em);
        $objLote = $LoteModel->findOneBy([
            'codLote' => $codLote,
            'exercicio' => $transferenciaObj->getExercicio(),
            'codEntidade' => $transferenciaObj->getCodEntidade(),
            'tipo' => $tipoLote
        ]);
        $transferenciaEstornada->setFkContabilidadeLote($objLote);

        $dtBoletim = $transferenciaObj->getFkTesourariaBoletim()->getDtBoletim();
        $arrecadacaoRepository = $em->getRepository('CoreBundle:Tesouraria\Arrecadacao');
        $codAutenticadao = $arrecadacaoRepository->getCodAutenticacao($dtBoletim->format('d/m/Y'));
        $tipo = $em->getRepository('CoreBundle:Tesouraria\TipoAutenticacao')->find($tipoAutenticacao);

        $autenticacao = new Entity\Tesouraria\Autenticacao();
        $autenticacao->setCodAutenticacao($codAutenticadao);
        $autenticacao->setDtAutenticacao($dtBoletim);
        $autenticacao->setTipo($tipo);

        $em->persist($autenticacao);
        $transferenciaEstornada->setFkTesourariaAutenticacao($autenticacao);

        // Se valor estornado == 0 => Fazemos uma abertura
        if ($transferencia->getValorEstornado() == (float)0) {
            // Fazer depois de popular o estorno
            $abertura = new Entity\Tesouraria\Abertura();
            $abertura->setFkTesourariaUsuarioTerminal($transferenciaEstornada->getFkTesourariaUsuarioTerminal());
            $abertura->setFkTesourariaBoletim($transferenciaEstornada->getFkTesourariaBoletim());

            $em->persist($abertura);
        }
    }

    /**
     * @param Entity\Tesouraria\TransferenciaEstornada $transferenciaEstornada
     */
    public function postPersist($transferenciaEstornada)
    {
        $formContent = (object) $this->getFormPost($formSonata = true);
        $redirectPage = "/financeiro/tesouraria/arrecadacao/extra-arrecadacoes/%s/show";

        if ($this->transferenciaEntity->getCodTipo() == TransferenciaModel::PAGAMENTO_EXTRA) {
            $redirectPage = "/financeiro/tesouraria/extra-pagamento/%s/show";
        }

        $this->forceRedirect(
            sprintf(
                $redirectPage,
                $formContent->id
            )
        );
    }
}
