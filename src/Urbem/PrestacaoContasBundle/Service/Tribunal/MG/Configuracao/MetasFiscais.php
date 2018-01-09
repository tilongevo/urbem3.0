<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataView;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Urbem\CoreBundle\Entity\Tcers;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Model\Tcemg\MetasFiscaisModel;
use Urbem\CoreBundle\Entity\Tcemg\MetasFiscais as MetasFiscaisEntity;

final class MetasFiscais extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const GET = 'get';
    const SET = 'set';

    const MULTIPLIER = 100;

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ToolTips.js',
            '/prestacaocontas/js/Tribunal/MG/MetasFiscais.js',
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
        $em = $this->factory->getEntityManager();
        $em->beginTransaction();
        $exercicio = $this->factory->getSession()->getExercicio();
        try {
            $collectionData = $this->processParametersCollection();
            $entity = $this->getMetasFiscaisModel()->findByExercicio($exercicio);

            if (!$entity instanceof MetasFiscaisEntity) {
                $entity = $this->getMetasFiscais();
                $entity->setExercicio($exercicio);
            }

            foreach (MetasFiscaisEntity::getConstants() as $constant) {
                $method = self::SET . ucfirst($constant);
                if (is_callable([$entity, $method])) {
                    /** @var DataView $dataView */
                    $dataView = $collectionData->findObjectByName($constant);
                    $value = $this->formatValueForPersist($dataView->getValue(), $constant);
                    call_user_func_array([$entity, $method], [$value]);
                }
            }

            $em->persist($entity);
            $em->flush();
            $em->commit();

            return $this;
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            $em->rollback();

            return false;
        }
    }

    /**
     * @param float|null $value
     * @param string $field
     * @return null|float
     */
    protected function formatValueForPersist($value, $field)
    {
        if (is_null($value)) {
            return null;
        }

        if (MetasFiscaisEntity::isPercentage($field)) {
            return (float) number_format( (float) ($value * self::MULTIPLIER), 2, '.', '');
        }

        return $value;
    }

    /**
     * @return array
     */
    protected function searchMetasFiscais()
    {
        $entity = $this->getMetasFiscaisModel()->findByExercicio($this->factory->getSession()->getExercicio());
        $data = [];

        if (!$entity InstanceOf MetasFiscaisEntity) {
            $entity = $this->getMetasFiscais();
        }
            foreach (MetasFiscaisEntity::getConstants() as $constant) {
            $method = self::GET . ucfirst($constant);
            if (is_callable([$entity, $method])) {
                $data[$constant] = $this->formatCurrency(call_user_func([$entity, $method]));
            }
        }

        return $data;
    }

    /**
     * @param string $value
     * @return string|null
     */
    protected function formatCurrency($value)
    {
        if ($value) {
            return number_format($value, 2, ',', '.');
        }

        return $value;
    }

    /**
     * @param TwigEngine|null $templating
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $metasFiscaisParameters = $this->searchMetasFiscais();
        $response = ['response' => true];

        return array_merge($response, $metasFiscaisParameters);
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
     * @return MetasFiscaisModel
     */
    protected function getMetasFiscaisModel()
    {
        return new MetasFiscaisModel($this->factory->getEntityManager());
    }

    /**
     * @return MetasFiscaisEntity
     */
    protected function getMetasFiscais()
    {
        return new MetasFiscaisEntity();
    }
}
