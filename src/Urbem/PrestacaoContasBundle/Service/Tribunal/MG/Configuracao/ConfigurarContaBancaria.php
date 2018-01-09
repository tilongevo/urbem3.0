<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Tcemg\ContaBancaria;
use Urbem\CoreBundle\Entity\Tcemg\TipoAplicacao;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;

/**
 * Class ConfigurarContaBancaria
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class ConfigurarContaBancaria extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const FIELD_CODIGO_CTB_ANTERIOR = 'codCtbAnterior';
    const FIELD_COD_TIPO_APLICACAO = 'codTipoAplicacao';

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/ExternalLib/jquery.dataTables.min.js',
            '/prestacaocontas/js/ExternalLib/dataTables.scroller.min.js',
            '/prestacaocontas/js/Tribunal/MG/ConfigurarContaBancaria.js',
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
                $codigosCtb = $formData[self::FIELD_CODIGO_CTB_ANTERIOR];
                $aplicacoes = $formData[self::FIELD_COD_TIPO_APLICACAO];

                $repository = $entityManager->getRepository(ContaBancaria::class);
                foreach ($codigosCtb as $codConta => $codigoCtb) {
                    $entity = $repository->findOneBy(["codConta" => (int) $codConta, "exercicio" => $exercicio]);
                    if ($entity instanceof ContaBancaria) {
                        $codigoCtb = empty($codigoCtb) ? null : $codigoCtb;
                        $codTipoAplicacao = empty($aplicacoes[$codConta]) ? null : $aplicacoes[$codConta];

                        $entity->setCodCtbAnterior($codigoCtb);
                        $entity->setCodTipoAplicacao($codTipoAplicacao);
                    }
                    $entityManager->persist($entity);
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

        $codEntidade = $this->getCodEntidade($formData->entidade);
        $exercicio = $this->factory->getSession()->getExercicio();
        $tipoAplicacao = $this->factory->getEntityManager()->getRepository(TipoAplicacao::class)->findAllToArray();
        $result = $this->factory->getEntityManager()->getRepository(PlanoConta::class)->findContaBancaria($exercicio, $codEntidade, (int) $formData->codOrdenacao);
        
        return [
            'content' => $result,
            'aplicacao' => $tipoAplicacao
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/ConfigurarContaBancaria/list.html.twig");
    }
}
