<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Tcemg\SubtipoVeiculoTce;
use Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoVinculo;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Frota\TipoVeiculo;
use Urbem\CoreBundle\Entity\Tcemg\TipoVeiculoTce;

/**
 * Class ConfigurarTipoVeiculo
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class ConfigurarTipoVeiculo extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const FIELD_TIPO_VEICULO_TCE = 'tipoVeiculoTce';
    const FIELD_SUBTIPO_VEICULO_TCE = 'subtipoVeiculoTce';

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/ExternalLib/jquery.dataTables.min.js',
            '/prestacaocontas/js/ExternalLib/dataTables.scroller.min.js',
            '/prestacaocontas/js/Tribunal/MG/ConfigurarTipoVeiculo.js',
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
        $formData = (object) $this->getFormSonata();

        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($entityManager) use ($formData) {
                if (!property_exists($formData, self::FIELD_TIPO_VEICULO_TCE) || !property_exists($formData, self::FIELD_SUBTIPO_VEICULO_TCE)) {
                    throw new \Exception("Tipo e Subtipo de Veículos não informados.");
                }

                $repository = $entityManager->getRepository(TipoVeiculoVinculo::class);
                $subtipo = $formData->subtipoVeiculoTce;

                foreach ($formData->tipoVeiculoTce as $key => $tipo) {
                    $codTipo = (int) $tipo;
                    $codSubtipo = (int) $subtipo[$key];
                    /** @var TipoVeiculoVinculo $entity */
                    $entity = $repository->findOneBy(["codTipo" => $key]);
                    $entity->setCodTipoTce($codTipo);
                    $entity->setCodSubtipoTce($codSubtipo);
                    
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
        $tipoVeiculo = $this->factory->getEntityManager()->getRepository(TipoVeiculo::class)->findTipoVeiculoToArray();
        $tipoVeiculoTce = $this->factory->getEntityManager()->getRepository(TipoVeiculoTce::class)->findAllToArray();
        $subtipoVeiculoTce = $this->factory->getEntityManager()->getRepository(SubtipoVeiculoTce::class)->findAllToArray();

        return [
            'tipoVeiculo' => $tipoVeiculo,
            'tipoVeiculoTce' => $tipoVeiculoTce,
            'subtipoVeiculoTce' => $this->groupBySubtype($subtipoVeiculoTce),
        ];
    }

    /**
     * @param array $subtipoVeiculo
     * @return array
     */
    protected function groupBySubtype(array $subtipoVeiculo)
    {
        $group = [];
        foreach ($subtipoVeiculo as $tipo) {
            $codTipoTce = $tipo['codTipoTce'];
            $codSubtipoTce = $tipo['codSubtipoTce'];
            $nomSubtipoTce = $tipo['nomSubtipoTce'];

            $group[$codTipoTce][$codSubtipoTce] = $nomSubtipoTce;
        }

        return $group;
    }


    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/ConfigurarTipoVeiculo/list.html.twig");
    }
}
