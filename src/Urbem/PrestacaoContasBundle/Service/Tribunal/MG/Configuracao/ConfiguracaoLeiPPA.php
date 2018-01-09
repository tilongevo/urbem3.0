<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Model\Normas\NormaModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;

final class ConfiguracaoLeiPPA extends ConfiguracaoAbstract implements ConfiguracaoInterface
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

            /* @see src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/ConfiguracaoOrgaoType.php */
            $formData = $this->processParameters();
            $formData['alteracao'] = true === empty($formData['alteracao']) ? [] : $formData['alteracao'];

            $normaModel = new NormaModel($this->factory->getEntityManager());

            /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterConfiguracaoLeisPPA.php:70 */
            $normaModel->setNormaConsultaPPATCEMG($formData['consulta'], $exercicio);

            /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterConfiguracaoLeisPPA.php:94 */
            $normaModel->setNormasAlteracaoPPATCEMG($formData['alteracao'], $exercicio);

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
        /* form on src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/formulario.json (gpWL7mIKBya5TP4ZQZceSOzhMjObNfGOAR9c) */

        $exercicio = $this->factory->getSession()->getExercicio();
        $normaModel = new NormaModel($this->factory->getEntityManager());

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoLeisPPA.php:184 */
        /* autocomplete (src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/ConfiguracaoLeiPPAType.php)  */
        $formMapper->getFormBuilder()->get('consulta')->setData($normaModel->getNormaConsultaPPATCEMGByExercicio($exercicio));

        /* @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoLeisPPA.php:130 */
        /* autocomplete (src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/ConfiguracaoLeiPPAType.php)  */
        $formMapper->getFormBuilder()->get('alteracao')->setData($normaModel->getNormasAlteracaoPPATCEMGByExercicio($exercicio));
    }
}