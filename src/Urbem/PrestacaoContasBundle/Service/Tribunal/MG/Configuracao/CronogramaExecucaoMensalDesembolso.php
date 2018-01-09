<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Entity\Tcemg\GruposDespesa;
use Urbem\CoreBundle\Helper\MonthsHelper;
use Urbem\PrestacaoContasBundle\Model\BalanceteDespesaModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso as Entity;

/**
 * Class CronogramaExecucaoMensalDesembolso
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class CronogramaExecucaoMensalDesembolso extends ConfiguracaoAbstract implements ConfiguracaoInterface
{

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/ExternalLib/jquery.dataTables.min.js',
            '/prestacaocontas/js/ExternalLib/dataTables.scroller.min.js',
            '/prestacaocontas/js/Tribunal/MG/CronogramaExecucaoMensalDesembolso.js',
        ];
    }

    /**
     * @return string
     */
    public function dynamicBlockJs()
    {
        return parent::dynamicBlockJs();
    }

    /**
     * @return array
     */
    public function processParameters()
    {
        $params = parent::processParameters();
        return $params;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $formData = (array)$this->getFormSonata();

        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($entityManager) use ($formData) {
                $exercicio = $this->factory->getSession()->getExercicio();
                $parameters = array_shift($formData);
                $entidade = $this->getCodEntidade($parameters['entidade']);
                $orgao = $parameters['orgao'];
                $unidade = $formData['unidade'];
                $grupos = $formData['codGrupo'];
                $totais = $formData['total'];

                if (false == $this->validateSaldo($exercicio, $entidade, $orgao, $unidade, $totais)) {
                    throw new \Exception('Valores Totais Superior ao Saldo Diponível para esta Unidade.');
                }
                $repository = $entityManager->getRepository(Entity::class);
                foreach ($grupos as $grupo => $periodos) {
                    foreach ($periodos as $periodo => $value) {
                        /** @var Entity $entity */
                        $entity = $repository->findOneBy([
                            "codGrupo" => (int)$grupo,
                            "exercicio" => $exercicio,
                            "codEntidade" => (int)$entidade,
                            "periodo" => (int)$periodo,
                            "numUnidade" => (int)$unidade,
                            "numOrgao" => (int)$orgao,
                        ]);
                        $entity->setValor($value);
                        $entityManager->persist($entity);
                    }
                }
                $entityManager->flush();
            });
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }
    }

    /**
     * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterCronogramaExecucaoMensalDesembolso.php:70
     * @param $exercicio
     * @param $entidade
     * @param $orgao
     * @param $unidade
     * @param array $totais
     *
     * @return bool
     */
    protected function validateSaldo($exercicio, $entidade, $orgao, $unidade, array $totais)
    {
        $total = 0;
        $saldoInicial = $this->getSaldoInicial($exercicio, $entidade, $orgao, $unidade);
        foreach ($totais as $value) {
            $total += (float)$value;
        }

        return $total <= $saldoInicial;
    }

    /**
     * @return array
     */
    public function actionLoadUnidade()
    {
        $data = [];

        $exercicio = $this->factory->getSession()->getExercicio();
        $em = $this->factory->getEntityManager();
        $orgao = $this->getRequest()->get('orgao');

        $qb = $em->getRepository(Unidade::class)->findUnidadeByExercicioAndOrgao($exercicio, (int)$orgao);
        $unidades = $qb->getQuery()->getResult();

        /** @var Unidade $unidade */
        foreach ($unidades as $unidade) {
            $data[$unidade->getNumUnidade()] = $unidade->getNumUnidade() . ' - ' . $unidade->getNomUnidade();
        }

        return [
            'content' => $data
        ];
    }

    /**
     * @return array
     */
    public function actionLoadCronogramaMensalDesembolso()
    {

        $grupos = [];
        $em = $this->factory->getEntityManager();

        $exercicio = $this->factory->getSession()->getExercicio();
        $entidade = $this->getRequest()->get('entidade');
        $entidade = $this->getCodEntidade($entidade);
        $orgao = $this->getRequest()->get('orgao');
        $unidade = $this->getRequest()->get('unidade');

        $saldoInicial = $this->getSaldoInicial($exercicio, $entidade, $orgao, $unidade);

        $repository = $em->getRepository(GruposDespesa::class);
        $gruposDespesas = $repository->findAll();
        $cronogramas = $repository->getCronogramaMensalDesembolso($exercicio, $entidade, $orgao, $unidade);

        /** @var GruposDespesa $grupo */
        foreach ($gruposDespesas as $grupo) {
            $grupos[] = [
                'codGrupo' => $grupo->getCodGrupo(),
                'descricao' => $grupo->getDescricao(),
            ];
        }

        $data = [];
        foreach ($cronogramas as $item) {
            $periodo = ($item['periodo'] == 3) ? "Marco" : MonthsHelper::getMonthName($item['periodo']);
            $data[$item['codGrupo']][strtolower($periodo)] = (float) $item['valor'];
            $data[$item['codGrupo']]['descricao'] = $item['descricao'];
        }

        return [
            'content' => $data,
            'gruposDespesa' => $grupos,
            'saldoInicial' => number_format($saldoInicial, 2, ",", "."),
        ];
    }

    /**
     * @param TwigEngine|null $templating
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $action = (string)$this->getRequest()->get('action');
        $action = sprintf('action%s', ucfirst($action));

        if (false === method_exists($this, $action)) {
            return [
                'response' => false,
                'message' => sprintf('action %s not found', $action)
            ];
        }

        try {

            return [
                    'response' => true,
                ] + call_user_func_array([$this, $action], [$templating]);

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @param $exercicio
     * @param $entidade
     * @param $orgao
     * @param $unidade
     * @return int|float
     */
    protected function getSaldoInicial($exercicio, $entidade, $orgao, $unidade)
    {
        $balanceteMensalModel = $this->getBalanceteDespesaModel();
        $saldoInicial = $balanceteMensalModel->getCronogramaMensalDesembolsoSaldoInicial($exercicio, $entidade, $orgao, $unidade);
        if (count($saldoInicial)) {
            $saldo = array_shift($saldoInicial);

            return (float) $saldo['saldo_inicial'];
        }

        return 0;
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/CronogramaExecucaoMensalDesembolso/list.html.twig");
    }

    /**
     * @return BalanceteDespesaModel
     */
    protected function getBalanceteDespesaModel()
    {
        return new BalanceteDespesaModel($this->factory->getEntityManager());
    }
}