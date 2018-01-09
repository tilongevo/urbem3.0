<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Tcemg\Medidas;
use Urbem\CoreBundle\Repository\Tcemg\MedidasRepository;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;

final class ConfiguracaoGestaoFiscalMedidas extends ConfiguracaoAbstract implements ConfiguracaoInterface
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
            $medidas = $this->getForm()
                ->get('configuracao_gestao_fiscal_medidas_type')
                ->get('registros')
                ->get('dynamic_collection')
                ->getdata();

            $em = $this->factory->getEntityManager();

            /** @var MedidasRepository $repository */
            $repository = $this->getRepository(Medidas::class);

            // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRGestaoFiscalMedidas.php:123
            $repository->deleteExcept($medidas);

            /** @var Medidas $medida */
            foreach ($medidas as $medida) {
                if (null === $medida->getCodMedida()) {
                    $medida->setCodMedida($repository->nextVal('cod_medida'));
                }

                $em->persist($medida);
                $em->flush($medida);
            }

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
        $formMapper->get('configuracao_gestao_fiscal_medidas_type')
            ->get('registros')
            ->get('dynamic_collection')
            ->setData($this->getRepository(Medidas::class)->getAll());
    }
}