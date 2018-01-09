<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Config\Definition\Exception\Exception;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PeriodoMovimentacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_periodo_movimentacao';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/periodo-movimentacao';
    protected $customMessageDelete = 'ATENÇÃO! Ao confirmar a exclusão do período, todos os dados relativos à geração da folha de pagamento do período que está aberto serão perdidas!';
    protected $exibirBotaoIncluir = false;
    protected $includeJs = [
        '/recursoshumanos/javascripts/folhapagamento/periodoMovimentacao.js'
    ];

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'RecursosHumanosBundle:FolhaPagamento\PeriodoMovimentacao:list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->clearExcept(array('list', 'delete'))
            ->add('abrir_periodo_movimentacao', 'abrir-periodo-movimentacao')
            ->add('monta_calcula_folha', 'monta-calcula-folha')
            ->add('deletar_informacoes_calculo', 'deletar-informacoes-calculo');
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager('CoreBundle:Folhapagamento\PeriodoMovimentacao');
        /** @var PeriodoMovimentacaoModel $periodoMovimentacaoModel */
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);

        $periodoUnico = $periodoMovimentacaoModel->listPeriodoMovimentacao();
        $periodo = $periodoMovimentacaoModel->getOnePeriodo($periodoUnico);
        $codPeriodoMovimentacao = $periodo->getCodPeriodoMovimentacao();

        $query->andWhere(
            $query->expr()->eq('o.codPeriodoMovimentacao', ':param')
        );
        $query->setParameter('param', $codPeriodoMovimentacao);
        return $query;
    }

    /**
     * @param mixed $periodoMovimentacao
     */
    public function preRemove($periodoMovimentacao)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao');

            $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
            $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
            $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
            //Validar configuracao se deve realizar o adiatamento do 13 no mes do aniversario do servidor
            //Gestão Recursos Humanos :: Folha de Pagamento :: Configuração :: Configurar Cálculo de 13º Salário
            $configuracaoModel = new ConfiguracaoModel($em);
            $boAdiantamenteMesAniversario = $configuracaoModel
                ->getConfiguracao('adiantamento_13_salario', ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO, true);

            if ($boAdiantamenteMesAniversario == 'true') {
                $obErro = $periodoMovimentacao->cancelarAdiantamento13MesAniversario($this->getExercicio());
            }

            $periodo = $periodoMovimentacao->cancelarPeriodoMovimentacao('');

            $container->get('session')->getFlashBag()->add('success', 'O período atual foi fechado e todos os dados referentes ao período excluído foram removidos do sistema, Data Inicial: ' . $periodoFinal->getDtInicial()->format('d/m/Y') . ' Data Final: ' . $periodoFinal->getDtFinal()->format('d/m/Y'));

            $em->clear();
        } catch (Exception $e) {
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
        }

        (new RedirectResponse($this->generateUrl('list')))->send();
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $listMapper
            ->add('dtInicial', '', ['label' => 'Data Inicial', 'sortable' => false])
            ->add('dtFinal', '', ['label' => 'Data Final', 'sortable' => false])
            ->add('situacao', '', ['label' => 'Situação', 'mapped' => false])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ));
    }
}
