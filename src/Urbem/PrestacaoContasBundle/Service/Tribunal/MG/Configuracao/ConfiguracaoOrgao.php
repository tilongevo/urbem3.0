<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoEntidadeModel;
use Urbem\CoreBundle\Model\Tcemg\ConfiguracaoOrgaoModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;

final class ConfiguracaoOrgao extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoOrgao.js',
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        $em = $this->factory->getEntityManager();
        $em->getConnection()->setNestTransactionsWithSavepoints(true);
        $em->getConnection()->beginTransaction();

        try {
            /* @see src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/ConfiguracaoOrgaoType.php */
            $formData = $this->processParameters();
            $formData = reset($formData);

            list ($exercicio, $codEntidade) = explode('~', $formData['inCodEntidade']);

            $formData['inCodEntidade'] = $codEntidade;

            $configuracaoEntidadeModel = new ConfiguracaoEntidadeModel($em);

            /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterConfiguracaoOrgao.php:73 */
            $this->saveConfiguracaoEntidade(
                $configuracaoEntidadeModel,
                $exercicio,
                $formData['inCodEntidade'],
                ConfiguracaoEntidade::PARAMETRO_TCE_MG_CODIGO_ORGAO_ENTIDADE_SICOM,
                $formData['inCodigo']
            );

            /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterConfiguracaoOrgao.php:87 */
            $this->saveConfiguracaoEntidade(
                $configuracaoEntidadeModel,
                $exercicio,
                $formData['inCodEntidade'],
                ConfiguracaoEntidade::PARAMETRO_TCE_MG_TIPO_ORGAO_ENTIDADE_SICOM,
                $formData['inNumUnidade']->getNumOrgao()
            );

            $configuracaoOrgaoModel = new ConfiguracaoOrgaoModel($em);
            /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterConfiguracaoOrgao.php:118 */
            $configuracaoOrgaoModel->deleteByCodEntidadeAndExercicio($codEntidade, $exercicio);

            /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterConfiguracaoOrgao.php:115 */
            foreach ($this->getForm()->get('configuracao_orgao_type')->get('responsaveis')->get('dynamic_collection')->getdata() as $data) {
                $this->saveConfiguracaoOrgao(
                    $configuracaoOrgaoModel,
                    $formData['inCodEntidade'],
                    $exercicio,
                    $data
                );
            }

            $em->getConnection()->commit();

            return true;

        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            $em->getConnection()->rollBack();

            return false;
        }
    }

    /**
     * @param ConfiguracaoEntidadeModel $configuracaoEntidadeModel
     * @param $exercicio
     * @param $$codEntidade
     * @param $parameterName
     * @param $parameterValue
     * @return null|object|ConfiguracaoEntidade
     */
    protected function saveConfiguracaoEntidade(ConfiguracaoEntidadeModel $configuracaoEntidadeModel, $exercicio, $codEntidade, $parameterName, $parameterValue)
    {
        /* order de PK no .orm.yml */
        $configuracaoEntidade = $configuracaoEntidadeModel->getCurrentConfig(
            $exercicio,
            $codEntidade,
            $parameterName,
            Modulo::MODULO_TCE_MG
        );

        if (null === $configuracaoEntidade) {
            $configuracaoEntidade = new ConfiguracaoEntidade();
        }

        $configuracaoEntidade->setCodEntidade($codEntidade);
        $configuracaoEntidade->setCodModulo(Modulo::MODULO_TCE_MG);
        $configuracaoEntidade->setParametro($parameterName);
        $configuracaoEntidade->setExercicio($exercicio);
        $configuracaoEntidade->setValor($parameterValue);

        $configuracaoEntidadeModel->save($configuracaoEntidade);

        return $configuracaoEntidade;
    }

    /**
     * @param ConfiguracaoOrgaoModel $configuracaoOrgaoModel
     * @param $codEntidade
     * @param $exercicio
     * @param array $formData src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/ConfiguracaoOrgaoResponsavelType.php
     */
    protected function saveConfiguracaoOrgao(ConfiguracaoOrgaoModel $configuracaoOrgaoModel, $codEntidade, $exercicio, array $formData)
    {
        /* order de PK no .orm.yml */
        /* prevent duplicated PK */
        $configuracaoOrgao = $configuracaoOrgaoModel->getCurrentConfig(
            $codEntidade,
            $exercicio,
            $formData['inTipoResponsavel'],
            $formData['inNumCGM']
        );

        if (null === $configuracaoOrgao) {
            $configuracaoOrgao = new \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoOrgao();
        }

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoOrgao.php:269 */
        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterConfiguracaoOrgao.php:120 */
        $configuracaoOrgao->setExercicio($exercicio);
        $configuracaoOrgao->setCodEntidade($codEntidade);
        $configuracaoOrgao->setTipoResponsavel($formData['inTipoResponsavel']);
        $configuracaoOrgao->setNumCgm($formData['inNumCGM']);
        $configuracaoOrgao->setCrcContador($formData['stCRCContador']);

        if ($formData['stSiglaUF'] instanceof SwUf) {
            $configuracaoOrgao->setUfCrccontador($formData['stSiglaUF']->getSiglaUf());
        }

        $configuracaoOrgao->setCargoOrdenadorDespesa($formData['stCargoGestor']);
        $configuracaoOrgao->setDtInicio($formData['dtInicio']);
        $configuracaoOrgao->setDtFim($formData['dtFim']);
        $configuracaoOrgao->setEmail($formData['stEMail']);

        $configuracaoOrgaoModel->save($configuracaoOrgao);

        return $configuracaoOrgao;
    }

    /**
     * @param TwigEngine|null $templating
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        try {
            $em = $this->factory->getEntityManager();

            list($exercicio, $codEntidade) = explode('~', $this->getRequest()->get('inCodEntidade'));
            /** @var Entidade $entidade */
            $entidade = $em->getRepository(Entidade::class)->findOneBy(['exercicio' => $exercicio, 'codEntidade' => $codEntidade]);

            if (null === $entidade) {
                throw new \OutOfRangeException('Entidade não encontrada');
            }

            $configuracaoEntidadeModel = new ConfiguracaoEntidadeModel($em);

            $inCodigo = $configuracaoEntidadeModel->getCurrentConfig(
                $exercicio,
                $entidade->getCodEntidade(),
                ConfiguracaoEntidade::PARAMETRO_TCE_MG_CODIGO_ORGAO_ENTIDADE_SICOM,
                Modulo::MODULO_TCE_MG
            );

            $inNumUnidade = $configuracaoEntidadeModel->getCurrentConfig(
                $exercicio,
                $entidade->getCodEntidade(),
                ConfiguracaoEntidade::PARAMETRO_TCE_MG_TIPO_ORGAO_ENTIDADE_SICOM,
                Modulo::MODULO_TCE_MG
            );

            $inCodigo = null === $inCodigo ? new ConfiguracaoEntidade() : $inCodigo;
            $inNumUnidade = null === $inNumUnidade ? new ConfiguracaoEntidade() : $inNumUnidade;

            $responsaveis = [];

            $getDate = function ($date) {
                return true === $date instanceof \DateTime ? $date->format('d/m/Y') : '';
            };

            /** @var \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoOrgao $responsavel */
            foreach ((new ConfiguracaoOrgaoModel($em))->getByEntidade($entidade) as $responsavel) {
                $responsaveis[] = [
                    'inTipoResponsavel' => $responsavel->getTipoResponsavel(),
                    'inNumCGM' => $responsavel->getNumCgm(),
                    'stNumCGM' => (string) $responsavel->getFkSwCgm(),
                    'stCRCContador' => $responsavel->getCrcContador(),
                    'stSiglaUF' => $responsavel->getUfCrccontador(),
                    'stCargoGestor' => $responsavel->getCargoOrdenadorDespesa(),
                    'dtInicio' => $getDate($responsavel->getDtInicio()),
                    'dtFim' => $getDate($responsavel->getDtFim()),
                    'stEMail' => $responsavel->getEmail()
                ];
            }

            return [
                'response' => true,
                'inCodigo' => $inCodigo->getValor(),
                'inNumUnidade' => $inNumUnidade->getValor(),
                'responsaveis' => $responsaveis,
            ];

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }

    }
}