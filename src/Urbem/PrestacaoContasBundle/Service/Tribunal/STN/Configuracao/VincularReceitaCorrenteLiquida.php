<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Stn\ReceitaCorrenteLiquida;
use Urbem\CoreBundle\Helper\MonthsHelper;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class VincularReceitaCorrenteLiquida
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao
 */
final class VincularReceitaCorrenteLiquida extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/STN/VincularReceitaCorrenteLiquida.js',
        ];
    }

    private $receita = [
        'valor_receita_tributaria',
        'valor_iptu',
        'valor_iss',
        'valor_itbi',
        'valor_irrf',
        'valor_outras_receitas_tributarias',
        'valor_receita_contribuicoes',
        'valor_receita_patrimonial',
        'valor_receita_agropecuaria',
        'valor_receita_industrial',
        'valor_receita_servicos',
        'valor_transferencias_correntes',
        'valor_cota_parte_fpm',
        'valor_cota_parte_icms',
        'valor_cota_parte_ipva',
        'valor_cota_parte_itr',
        'valor_transferencias_lc_871996',
        'valor_transferencias_lc_611989',
        'valor_transferencias_fundeb',
        'valor_outras_transferencias_correntes',
        'valor_outras_receitas',
    ];

    private $deducao = [
        'valor_contrib_plano_sss',
        'valor_compensacao_financeira',
        'valor_deducao_fundeb',
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

                $entity = $entityManager->getRepository(ReceitaCorrenteLiquida::class)->findOneBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'mes' => $mes,
                    'ano' => $ano,
                ]);
                /** @see gestaoPrestacaoContas/fontes/PHP/STN/classes/controle/CSTNConfiguracao.class.php:1087 */
                if ($entity instanceof ReceitaCorrenteLiquida) {
                    throw new \Exception('Periodo já está na lista.');
                }
                $entity = $this->getReceitaCorrenteLiquida();
                $entity->setExercicio($exercicio);
                $entity->setCodEntidade($codEntidade);
                $entity->setValor($totalValor);
                $entity->setMes($mes);
                $entity->setAno($ano);
                $entity->setValorReceitaTributaria((float) $formData['valor_receita_tributaria']);
                $entity->setValorIptu((float) $formData['valor_iptu']);
                $entity->setValorIss((float) $formData['valor_iss']);
                $entity->setValorItbi((float) $formData['valor_itbi']);
                $entity->setValorIrrf((float) $formData['valor_irrf']);
                $entity->setValorOutrasReceitasTributarias((float) $formData['valor_outras_receitas_tributarias']);
                $entity->setValorReceitaContribuicoes((float) $formData['valor_receita_contribuicoes']);
                $entity->setValorReceitaPatrimonial((float) $formData['valor_receita_patrimonial']);
                $entity->setValorReceitaAgropecuaria((float) $formData['valor_receita_agropecuaria']);
                $entity->setValorReceitaIndustrial((float) $formData['valor_receita_industrial']);
                $entity->setValorReceitaServicos((float) $formData['valor_receita_servicos']);
                $entity->setValorTransferenciasCorrentes((float) $formData['valor_transferencias_correntes']);
                $entity->setValorCotaParteFpm((float) $formData['valor_cota_parte_fpm']);
                $entity->setValorCotaParteIcms((float) $formData['valor_cota_parte_icms']);
                $entity->setValorCotaParteIpva((float) $formData['valor_cota_parte_ipva']);
                $entity->setValorCotaParteItr((float) $formData['valor_cota_parte_itr']);
                $entity->setValorTransferenciasLc871996((float) $formData['valor_transferencias_lc_871996']);
                $entity->setValorTransferenciasLc611989((float) $formData['valor_transferencias_lc_611989']);
                $entity->setValorTransferenciasFundeb((float) $formData['valor_transferencias_fundeb']);
                $entity->setValorOutrasTransferenciasCorrentes((float) $formData['valor_outras_transferencias_correntes']);
                $entity->setValorOutrasReceitas((float) $formData['valor_outras_receitas']);
                $entity->setValorContribPlanoSss((float) $formData['valor_contrib_plano_sss']);
                $entity->setValorCompensacaoFinanceira((float) $formData['valor_compensacao_financeira']);
                $entity->setValorDeducaoFundeb((float) $formData['valor_deducao_fundeb']);
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
        return $this->getTotalReceita($formData) - $this->getTotalDeducao($formData);
    }

    /**
     * @param array $formData
     * @return float|int
     */
    protected function getTotalReceita(array $formData)
    {
        $totalReceita = 0;
        foreach ($this->receita as $field) {
            if (!empty($formData[$field]) && is_numeric($formData[$field])) {
                $totalReceita += (float) $formData[$field];
            }
        }

        return $totalReceita;
    }

    /**
     * @param array $formData
     * @return float|int
     */
    protected function getTotalDeducao(array $formData)
    {
        $totalDeducao = 0;
        foreach ($this->deducao as $field) {
            if (!empty($formData[$field]) && is_numeric($formData[$field])) {
                $totalDeducao += (float) $formData[$field];
            }
        }

        return $totalDeducao;
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
        if (!is_numeric($mes) || !is_numeric($exercicio)) {
            throw new \Exception('Data Inválida.');
        }

        return [
            'content' => MonthsHelper::getPreviousPeriodsAvailable($mes, $exercicio),
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

        $qb = $em->getRepository(ReceitaCorrenteLiquida::class)->findValores($exercicio, $codEntidade);
        $entities = $qb->getQuery()->getResult();

        /** @var ReceitaCorrenteLiquida $entity */
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

        $entity = $this->factory->getEntityManager()->getRepository(ReceitaCorrenteLiquida::class)->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade,
            'mes' => $mes,
            'ano' => $ano,
        ]);
        if (!$entity instanceof ReceitaCorrenteLiquida) {
            throw new \Exception('Erro ao Apagar Dados.');
        }

        $em->remove($entity);
        $em->flush();

        return [
            'message' => 'Recurso Removido com Sucesso!',
        ];
    }

    /**
     * @return ReceitaCorrenteLiquida
     */
    protected function getReceitaCorrenteLiquida()
    {
        return new ReceitaCorrenteLiquida();
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

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/STN/Configuracao/VincularReceitaCorrenteLiquida/list.html.twig");
    }
}