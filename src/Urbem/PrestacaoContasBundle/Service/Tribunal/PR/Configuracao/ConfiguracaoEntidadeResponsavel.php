<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;

final class ConfiguracaoEntidadeResponsavel extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return bool
     */
    public function save()
    {
        $em = $this->factory->getEntityManager();

        try {
            $formData = $this->processParameters();

            $formData['entidade'] = explode('~', $formData['entidade']);
            $codEntidade = array_shift($formData['entidade']);
            $exercicioEntidade = array_shift($formData['entidade']);

            $codTCE = $formData['codigo_tce'];

            $exercicio = $this->factory->getSession()->getExercicio();

            $model = new ConfiguracaoModel($em);

            $configuracao = new Configuracao();
            $configuracao->setExercicio($exercicio);
            $configuracao->setValor($codEntidade);
            $configuracao->setCodModulo(Modulo::MODULO_TCE_PR);
            $configuracao->setParametro(Configuracao::PARAMETRO_ENTIDADE_GESTAO_COD_ENTIDADE);

            $model->setInitialConfig($configuracao);

            $configuracao = new Configuracao();
            $configuracao->setExercicio($exercicio);
            $configuracao->setValor($exercicioEntidade);
            $configuracao->setCodModulo(Modulo::MODULO_TCE_PR);
            $configuracao->setParametro(Configuracao::PARAMETRO_ENTIDADE_GESTAO_EXERCICIO);

            $model->setInitialConfig($configuracao);

            $configuracao = new Configuracao();
            $configuracao->setExercicio($exercicio);
            $configuracao->setValor($codTCE);
            $configuracao->setCodModulo(Modulo::MODULO_TCE_PR);
            $configuracao->setParametro(Configuracao::PARAMETRO_ID_ENTIDADE_TCE);

            $model->setInitialConfig($configuracao);

        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }
    }

    public function load(FormMapper $formMapper)
    {
        $exercicio = $this->factory->getSession()->getExercicio();

        $model = new ConfiguracaoModel($this->factory->getEntityManager());

        $codEntidade = $model->getConfiguracao(
            Configuracao::PARAMETRO_ENTIDADE_GESTAO_COD_ENTIDADE,
            Modulo::MODULO_TCE_PR,
            true,
            $exercicio
        );

        $exercicioEntidade = $model->getConfiguracao(
            Configuracao::PARAMETRO_ENTIDADE_GESTAO_EXERCICIO,
            Modulo::MODULO_TCE_PR,
            true,
            $exercicio
        );

        $codTCE = $model->getConfiguracao(
            Configuracao::PARAMETRO_ID_ENTIDADE_TCE,
            Modulo::MODULO_TCE_PR,
            true,
            $exercicio
        );

        $formMapper->getFormBuilder()->get('codigo_tce')->setData($codTCE);

        $entidade = new Entidade();
        $entidade->setCodEntidade($codEntidade);
        $entidade->setExercicio($exercicioEntidade);

        $formMapper->getFormBuilder()->get('entidade')->setData($entidade);
    }
}