<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoArquivoDclrf;
use Urbem\CoreBundle\Model\Tcemg\ConfiguracaoArquivoDclrfModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataView;

/**
 * Class ConfigurarArquivoDCLRF
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class ConfigurarArquivoDCLRF extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const GET = 'get';
    const SET = 'set';

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ToolTips.js',
            '/prestacaocontas/js/Tribunal/MG/ConfigurarArquivoDCLRF.js',
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
        try {
            $em = $this->factory->getEntityManager();
            $formCollection = $this->processParametersCollection();

            return $em->transactional(function ($entityManager) use ($formCollection) {
                $exercicio = $formCollection->findObjectByName(ConfiguracaoArquivoDclrfModel::FIELD_EXERCICIO);
                $mesReferencia = $formCollection->findObjectByName(ConfiguracaoArquivoDclrfModel::FIELD_MES_REFERENCIA);

                $repository = $entityManager->getRepository(ConfiguracaoArquivoDclrf::class);
                $entity = $repository->findOneBy([ConfiguracaoArquivoDclrfModel::FIELD_EXERCICIO => $exercicio->getValue(), ConfiguracaoArquivoDclrfModel::FIELD_MES_REFERENCIA => $mesReferencia->getValue()]);

                if (! $entity instanceof ConfiguracaoArquivoDclrf) {
                    $entity = $this->getConfiguracaoArquivoDclrf();
                    $entity->setExercicio($exercicio->getValue());
                    $entity->setMesReferencia($mesReferencia->getValue());
                }

                foreach (ConfiguracaoArquivoDclrf::getConstants() as $constant) {
                    $method = self::SET . ucfirst($constant);
                    if (is_callable([$entity, $method])) {
                        /** @var DataView $dataView */
                        $dataView = $formCollection->findObjectByName($constant);
                        call_user_func_array([$entity, $method], [$dataView->getValue()]);
                    }
                }

                $entityManager->persist($entity);
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
        $data = [];
        $formData = (object) $this->getFormSonata();
        $model = $this->getConfiguracaoModel();

        $entity = $this->getConfiguracaoArquivoDclrf();
        if (property_exists($formData, $model::FIELD_EXERCICIO) && property_exists($formData, $model::FIELD_MES_REFERENCIA)) {
            $exercicio = $formData->exercicio;
            $mesReferencia = $formData->mesReferencia;

            $entity = $model->findByExercicioAndMes($exercicio, $mesReferencia);
        }

        foreach (ConfiguracaoArquivoDclrf::getConstants() as $constant) {
            $method = self::GET . ucfirst($constant);
            if (is_callable([$entity, $method])) {
                $data[$constant] = $this->isFormat($constant, call_user_func([$entity, $method]));
            }
        }

        $response = ['response' => true];

        return array_merge($response, $data);

    }

    /**
     * @param string $field
     * @param mixed $value
     * @return mixed
     */
    protected function isFormat($field, $value)
    {
        if (ConfiguracaoArquivoDclrf::isCurrency($field)) {
            return number_format($value, 2, ',', '.');
        }

        if ($value instanceof \DateTime) {
            return $value->format("d/m/Y");
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
    }

    /**
     * @return ConfiguracaoArquivoDclrfModel
     */
    protected function getConfiguracaoModel()
    {
        return new ConfiguracaoArquivoDclrfModel($this->factory->getEntityManager());
    }

    /**
     * @return ConfiguracaoArquivoDclrf
     */
    protected function getConfiguracaoArquivoDclrf()
    {
        return new ConfiguracaoArquivoDclrf();
    }
}
