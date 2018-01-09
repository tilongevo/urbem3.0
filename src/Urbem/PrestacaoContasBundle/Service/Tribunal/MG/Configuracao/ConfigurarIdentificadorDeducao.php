<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Proxies\__CG__\Urbem\CoreBundle\Entity\Tcemg\ValoresIdentificadores;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Orcamento\Receita;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Urbem\CoreBundle\Entity\Tcers;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcemg\ReceitaIndentificadoresPeculiarReceita;

/**
 * Class ConfigurarIdentificadorDeducao
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class ConfigurarIdentificadorDeducao extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const FIELD_RECURSO = 'recurso';

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/ExternalLib/jquery.dataTables.min.js',
            '/prestacaocontas/js/ExternalLib/dataTables.scroller.min.js',
            '/prestacaocontas/js/Tribunal/MG/ConfigurarIdentificadorDeducao.js',
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
                if (!property_exists($formData, "valores_identificadores") || empty($formData->valores_identificadores)) {
                    throw new \Exception("Valores Identificadores não informado");
                }

                $exercicio = $this->factory->getSession()->getExercicio();
                $repository = $entityManager->getRepository(ReceitaIndentificadoresPeculiarReceita::class);
                foreach ($formData->valores_identificadores as $codReceita => $codIdentificador) {
                    $entity = $repository->findOneBy(["exercicio" => $exercicio, "codReceita" => (int) $codReceita]);
                    $entity->setCodIdentificador($codIdentificador);
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
        $formData = (array) $this->getFormSonata();

        foreach ($formData as $field => $value) {
            if ($field == self::FIELD_RECURSO) {
                $formData[$field] = $this->getCodRecurso($value);
            }
            if (!$value) {
                unset ($formData[$field]);
            }
        }
        $valoresIdentificadores = $this->factory->getEntityManager()->getRepository(ValoresIdentificadores::class)->findAllToArray();
        $repository = $this->factory->getEntityManager()->getRepository(Receita::class);
        $data = $repository->getIdentificadorDeducao($this->factory->getSession()->getExercicio(), $formData);

        return [
            'response' => true,
            'receita' => $data,
            'valoresIdentificadores' => $valoresIdentificadores,
        ];
    }

    /**
     * @param string $value
     * @return mixed
     */
    protected function getCodRecurso($value)
    {
        if ($value) {
            list($exercicio, $codRecurso) = explode("~", $value);

            return $codRecurso;
        }

        return $value;
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/ConfigurarIdentificadorDeducao/list.html.twig");
    }
}