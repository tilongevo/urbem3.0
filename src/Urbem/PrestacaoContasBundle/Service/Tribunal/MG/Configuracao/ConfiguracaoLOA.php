<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Model\Tcemg\ConfiguracaoLOAModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;

final class ConfiguracaoLOA extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return bool
     */
    public function save()
    {
        $em = $this->factory->getEntityManager();
        $em->getConnection()->setNestTransactionsWithSavepoints(true);
        $em->getConnection()->beginTransaction();

        try {
            $exercicio = $this->factory->getSession()->getExercicio();

            $formData = $this->processParameters();

            $model = new ConfiguracaoLOAModel($this->factory->getEntityManager());

            $configuracaoLoa = $model->getCurrentConfig($exercicio);
            $configuracaoLoa = null === $configuracaoLoa ? new \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLoa() : $configuracaoLoa;

            /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterConfiguracaoLOA.php:58 */
            $configuracaoLoa->setFkNormasNorma($formData['norma']);
            $configuracaoLoa->setPercentualAberturaCredito((float) number_format((float) ($formData['nuAberturaCredito'] * 100), 2, '.', ''));
            $configuracaoLoa->setPercentualContratacaoCredito((float) number_format((float) ($formData['nuPorContratoCredito'] * 100), 2, '.', ''));
            $configuracaoLoa->setPercentualContratacaoCreditoReceita((float) number_format((float) ($formData['nuPorContratoCreditoReceita'] * 100), 2, '.', ''));

            $model->save($configuracaoLoa);

            $em->getConnection()->commit();

            return true;

        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            $em->getConnection()->rollBack();

            return false;
        }
    }

    public function load(FormMapper $formMapper)
    {
        /* form on src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/formulario.json (uaZ6MJ7JAwigyUgKLejdhfIbO4lsT6NpZr9y) */

        $exercicio = $this->factory->getSession()->getExercicio();

        $model = new ConfiguracaoLOAModel($this->factory->getEntityManager());

        $configuracaoLoa = $model->getCurrentConfig($exercicio);

        if (null === $configuracaoLoa) {
            return null;
        }

        $formMapper->getFormBuilder()->get('norma')->setData($configuracaoLoa->getFkNormasNorma());
        $formMapper->getFormBuilder()->get('nuAberturaCredito')->setData($configuracaoLoa->getPercentualAberturaCredito());
        $formMapper->getFormBuilder()->get('nuPorContratoCredito')->setData($configuracaoLoa->getPercentualContratacaoCredito());
        $formMapper->getFormBuilder()->get('nuPorContratoCreditoReceita')->setData($configuracaoLoa->getPercentualContratacaoCreditoReceita());
    }
}