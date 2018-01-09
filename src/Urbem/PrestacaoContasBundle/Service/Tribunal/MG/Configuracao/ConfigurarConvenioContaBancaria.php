<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Tcemg\ConvenioPlanoBanco;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;

/**
 * Class ConfigurarConvenioContaBancaria
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class ConfigurarConvenioContaBancaria extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const FIELD_COD_PLANO = 'codPlano';
    const FIELD_NUM_CONVENIO = 'numConvenio';
    const FIELD_DT_ASSINATURA = 'dtAssinatura';
    const FIELD_COD_ESTRUTURAL = 'codEstrutural';
    const FIELD_NOM_CONTA = 'nomConta';
    const FIELD_ENTIDADE = "entidade";

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/ExternalLib/jquery.dataTables.min.js',
            '/prestacaocontas/js/ExternalLib/dataTables.scroller.min.js',
            '/prestacaocontas/js/Tribunal/MG/ConfigurarConvenioContaBancaria.js',
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
        $formData = (array) $this->getFormSonata();

        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($entityManager) use ($formData) {
                $exercicio = $this->factory->getSession()->getExercicio();
                $convenios = $formData[self::FIELD_NUM_CONVENIO];
                $dtAssinaturas = $formData[self::FIELD_DT_ASSINATURA];

                $arrayEntidade = array_shift($formData);
                $codEntidade = $this->getCodEntidade($arrayEntidade[self::FIELD_ENTIDADE]);

                $repository = $entityManager->getRepository(ConvenioPlanoBanco::class);
                foreach ($convenios as $codPlano => $convenio) {
                    $entity = $repository->findOneBy(["codPlano" => (int) $codPlano, "exercicio" => $exercicio]);
                    if (!empty($convenio) && !empty($dtAssinaturas[$codPlano])) {
                        $dtAssinatura = new \DateTime($dtAssinaturas[$codPlano]);
                        if ($entity instanceof ConvenioPlanoBanco) {
                            $entity->setNumConvenio($convenio);
                            $entity->setDtAssinatura($dtAssinatura);
                        } else {
                            $entity = $this->getConvenioPlanoBanco();
                            $entity->setExercicio($exercicio);
                            $entity->setCodEntidade($codEntidade);
                            $entity->setCodPlano($codPlano);
                            $entity->setNumConvenio($convenio);
                            $entity->setDtAssinatura($dtAssinatura);
                        }
                        $entityManager->persist($entity);
                    } elseif ($entity instanceof ConvenioPlanoBanco) {
                        $entityManager->remove($entity);
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
     * @param TwigEngine|null $templating
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $formData = (object) $this->getFormSonata();

        $result = [];
        $codEntidade = $this->getCodEntidade($formData->entidade);
        $exercicio = $this->factory->getSession()->getExercicio();
        $qb = $this->factory->getEntityManager()->getRepository(PlanoConta::class)->findConvenioContaBancaria($exercicio, $codEntidade);
        $data  = $qb->getQuery()->getResult();

        /** @var PlanoConta $item */
        foreach ($data as $key => $item) {
            $result[$key][self::FIELD_COD_ESTRUTURAL] = $item->getCodEstrutural();
            $result[$key][self::FIELD_COD_PLANO] = (string) $item->getFkContabilidadePlanoAnalitica()->getCodPlano();
            $result[$key][self::FIELD_NOM_CONTA] = $item->getNomConta();
            $numConvenio = !is_null($item->getFkContabilidadePlanoAnalitica()->getFkTcemgConvenioPlanoBanco()) ? $item->getFkContabilidadePlanoAnalitica()->getFkTcemgConvenioPlanoBanco()->getNumConvenio() : '';
            $dtAssinatura = !is_null($item->getFkContabilidadePlanoAnalitica()->getFkTcemgConvenioPlanoBanco()) ? $item->getFkContabilidadePlanoAnalitica()->getFkTcemgConvenioPlanoBanco()->getDtAssinatura() : '';
            $result[$key][self::FIELD_NUM_CONVENIO] = is_null($numConvenio) ? '' : $numConvenio;
            $result[$key][self::FIELD_DT_ASSINATURA] = ($dtAssinatura instanceof \DateTime) ? $dtAssinatura->format('d/m/Y') : '';
        }

        return [
            'content' => $result
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/ConfigurarConvenioContaBancaria/list.html.twig");
    }

    /**
     * @return ConvenioPlanoBanco
     */
    protected function getConvenioPlanoBanco()
    {
        return new ConvenioPlanoBanco();
    }
}