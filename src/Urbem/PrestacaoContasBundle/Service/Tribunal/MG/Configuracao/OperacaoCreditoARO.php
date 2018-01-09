<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Model\Tcemg\OperacaoCreditoAroModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcemg\OperacaoCreditoAro as OperacaoCreditoAroEntity;

/**
 * Class OperacaoCreditoARO
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class OperacaoCreditoARO extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const SET = 'set';

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/OperacaoCreditoARO.js',
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
                $model = $this->getOperacaoCreditoAroModel();
                $exercicio = $this->factory->getSession()->getExercicio();
                $entidade = $formCollection->findObjectByName($model::FIELD_ENTIDADE);
                $codEntidade = $this->getCodEntidade($entidade->getValue());

                $repository = $entityManager->getRepository(OperacaoCreditoAroEntity::class);
                $entity = $repository->findOneBy([$model::FIELD_EXERCICIO => $exercicio, $model::FIELD_ENTIDADE => $codEntidade]);

                if (! $entity instanceof OperacaoCreditoAroEntity) {
                    $entity = $this->getEntity();
                    $entity->setExercicio($exercicio);
                }

                $values = $formCollection->exportDataAndValueToArray();

                foreach ($values[self::VALUE_KEY] as $field => $value) {
                    if ($field == $model::FIELD_ENTIDADE) {
                        $value = $codEntidade;
                    }
                    $method = self::SET . ucfirst($field);
                    if (is_callable([$entity, $method])) {
                        call_user_func_array([$entity, $method], [$value]);
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
        $model = $this->getOperacaoCreditoAroModel();
        $formData = (object) $this->getFormSonata();
        if (property_exists($formData, $model::FIELD_ENTIDADE)) {
            $codEntidade = $this->getCodEntidade($formData->codEntidade);
            $data = $model->findByExercicioEntidade($this->factory->getSession()->getExercicio(), $codEntidade);
            foreach ($data as $field => $item) {
               $data[$field] = $this->formatOutput($item);
            }
        }

        return array_merge(['response' => true], $data);
    }

    /**
     * @param mixed $value
     * @return string
     */
    protected function formatOutput($value)
    {
        if ($value instanceof \DateTime) {

            return $this->dateTimeToString($value);
        }
        if (is_numeric($value)) {

            return $this->currentFormat($value);
        }

        return $value;
    }

    /**
     * @param \DateTime $dateTime
     * @return string
     */
    protected function dateTimeToString(\DateTime $dateTime)
    {
        return $dateTime->format('d/m/Y');
    }

    /**
     * @param $value
     * @return string
     */
    protected function currentFormat($value)
    {
        return number_format($value, 2, ',', '.');
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
     * @return OperacaoCreditoAroModel
     */
    protected function getOperacaoCreditoAroModel()
    {
        return new OperacaoCreditoAroModel($this->factory->getEntityManager());
    }

    /**
     * @return OperacaoCreditoAroEntity
     */
    protected function getEntity()
    {
        return new OperacaoCreditoAroEntity();
    }
}