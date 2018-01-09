<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Stn\DespesaPessoal;
use Urbem\CoreBundle\Helper\MonthsHelper;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class VincularDespesaPessoal
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao
 */
final class VincularDespesaPessoal extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/STN/VincularDespesaPessoal.js',
        ];
    }

    private $bruto = [
        'valor_pessoal_ativo',
        'valor_pessoal_inativo',
        'valor_terceirizacao',
    ];

    private $despesas = [
        'valor_indenizacoes',
        'valor_decisao_judicial',
        'valor_exercicios_anteriores',
        'valor_inativos_pensionistas',
    ];

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
        $formData = (array) $this->getFormSonata();

        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($entityManager) use ($formData) {
                $exercicio = $this->factory->getSession()->getExercicio();
                $codEntidade = $formData['entidade'];
                $periodo = $formData['periodo'];
                list($mes, $ano) = explode("/", $periodo);
                $totalValor = $this->processTotal($formData);

                $entity = $entityManager->getRepository(DespesaPessoal::class)->findOneBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'mes' => $mes,
                    'ano' => $ano,
                ]);
                if ($entity instanceof DespesaPessoal) {
                    throw new \Exception('Periodo já está na lista.');
                }
                $entity = $this->getDespesaPessoal();
                $entity->setExercicio($exercicio);
                $entity->setCodEntidade($codEntidade);
                $entity->setValor($totalValor);
                $entity->setMes($mes);
                $entity->setAno($ano);
                $entity->setValorPessoalAtivo((float) $formData['valor_pessoal_ativo']);
                $entity->setValorPessoalInativo((float) $formData['valor_pessoal_inativo']);
                $entity->setValorTerceirizacao((float) $formData['valor_terceirizacao']);
                $entity->setValorIndenizacoes((float) $formData['valor_indenizacoes']);
                $entity->setValorDecisaoJudicial((float) $formData['valor_decisao_judicial']);
                $entity->setValorExerciciosAnteriores((float) $formData['valor_exercicios_anteriores']);
                $entity->setValorInativosPensionistas((float) $formData['valor_inativos_pensionistas']);

                $entityManager->persist($entity);
                $entityManager->flush();

                return true;
            });
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }
    }

    /**
     * @param array $formData
     * @return float|int
     */
    protected function processTotal(array $formData)
    {
        return $this->getTotalBruto($formData) - $this->getTotalDespesas($formData);
    }

    /**
     * @param array $formData
     * @return float|int
     */
    protected function getTotalBruto(array $formData)
    {
        $total = 0;
        foreach ($this->bruto as $field) {
            if (!empty($formData[$field]) && is_numeric($formData[$field])) {
                $total += (float) $formData[$field];
            }
        }

        return $total;
    }

    /**
     * @param array $formData
     * @return float|int
     */
    protected function getTotalDespesas(array $formData)
    {
        $total = 0;
        foreach ($this->despesas as $field) {
            if (!empty($formData[$field]) && is_numeric($formData[$field])) {
                $total += (float) $formData[$field];
            }
        }

        return $total;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function actionLoadEntidade()
    {
        $data = [];

        $em = $this->factory->getEntityManager();
        if (empty($this->getRequest()->get('dataImplantacao'))) {
            throw new \Exception('Data Inválida.');
        }
        list($dia, $mes, $exercicio) = explode('/', $this->getRequest()->get('dataImplantacao'));
        $entidades = $em->getRepository(Entidade::class)->findEntidades($exercicio);

        foreach ($entidades as $entidade) {
            $data[$entidade['cod_entidade']] = $entidade['entidade'];
        }

        return [
            'content' => $data
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function actionLoadPeriodo()
    {
        if (empty($this->getRequest()->get('dataImplantacao'))) {
            throw new \Exception('Preencha a Data de Implantação.');
        }
        list($dia, $mes, $exercicio) = explode('/', $this->getRequest()->get('dataImplantacao'));
        if (!is_numeric($mes) || $mes > 12 || !is_numeric($exercicio)) {
            throw new \Exception('Data Inválida.');
        }

        $periodo = [];
        $exercicioAnterior = $exercicio - 1;
        while ($mes < 13) {
            $key = $mes . "/" . $exercicioAnterior;
            $periodo[$key] = MonthsHelper::getMonthName($mes) . "/" . $exercicioAnterior;
            $mes++;
        }

        return [
            'content' => $periodo,
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function actionLoadValores()
    {
        $valores = [];
        $em = $this->factory->getEntityManager();
        if (empty($this->getRequest()->get('entidade')) || empty($this->getRequest()->get('dataImplantacao'))) {
            throw new \Exception('Parametros inválidos.');
        }

        $codEntidade = $this->getRequest()->get('entidade');
        list($dia, $mes, $exercicio) = explode('/', $this->getRequest()->get('dataImplantacao'));

        if (!is_numeric($exercicio)) {
            throw new \Exception('Data Inválida.');
        }

        $qb = $em->getRepository(DespesaPessoal::class)->findDespesasPessoais($exercicio, $codEntidade);
        $entities = $qb->getQuery()->getResult();

        /** @var DespesaPessoal $entity */
        foreach ($entities as $entity) {
            $valores[] = [
                'periodo' => MonthsHelper::getMonthName($entity->getMes()) . '/' . $entity->getAno(),
                'valor' => number_format($entity->getValor(), 2, ',', '.'),
                'exercicio' => $entity->getExercicio(),
                'codEntidade' => $entity->getCodEntidade(),
                'mes' => $entity->getMes(),
                'ano' => $entity->getAno(),
            ];
        }

        return [
            'valores' => $valores,
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function actionDelete()
    {
        $em = $this->factory->getEntityManager();
        $exercicio = $this->getRequest()->get('exercicio');
        $codEntidade = $this->getRequest()->get('codEntidade');
        $mes = $this->getRequest()->get('mes');
        $ano = $this->getRequest()->get('ano');

        if (empty($exercicio) && empty($codEntidade) && empty($mes) && empty($ano)) {
            throw new \Exception('Parametros inválidos.');
        }

        $entity = $this->factory->getEntityManager()->getRepository(DespesaPessoal::class)->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade,
            'mes' => $mes,
            'ano' => $ano,
        ]);
        if (!$entity instanceof DespesaPessoal) {
            throw new \Exception('Erro ao Apagar Dados.');
        }

        $em->remove($entity);
        $em->flush();

        return [
            'message' => 'Recurso Removido com Sucesso!',
        ];
    }

    /**
     * @return DespesaPessoal
     */
    protected function getDespesaPessoal()
    {
        return new DespesaPessoal();
    }

    /**
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
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/STN/Configuracao/VincularDespesaPessoal/list.html.twig");
    }
}