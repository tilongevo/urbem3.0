<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Model\Tcemg\ExecucaoVariacaoModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Urbem\CoreBundle\Entity\Tcers;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcemg\ExecucaoVariacao;

final class ConsideracaoExecucaoVariacao extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const FIELD_COD_MES = 'codMes';

    const SET = 'set';

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ToolTips.js',
            '/prestacaocontas/js/Tribunal/MG/ConsideracaoExecucaoVariacao.js',
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
        $formCollection = $this->processParametersCollection();
        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($em) use ($formCollection) {
                $model = $this->getExecucaoVariacaoModel();
                $exercicio = $this->factory->getSession()->getExercicio();
                $mesDataView = $formCollection->findObjectByName($model::FIELD_COD_MES);

                $qb = $model->findByExercicioAndMes($exercicio, $mesDataView->getValue());

                $result = $qb->getQuery()->getResult();
                $entity = $this->getExecucaoVariacao();
                if (count($result)) {
                    $entity = array_shift($result);
                }
                $formArray = $formCollection->exportDataAndValueToArray();
                $entity->setExercicio($exercicio);

                foreach ($formArray[self::VALUE_KEY] as $field => $value) {
                    $method = self::SET . ucfirst($field);
                    if (is_callable([$entity, $method])) {
                        call_user_func_array([$entity, $method], [$value]);
                    }
                }

                $em->persist($entity);
                $em->flush();
            });
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());

            return false;
        }
    }

    /**
     * @param $mes
     * @return array
     */
    protected function searchValues($mes)
    {
        $model = $this->getExecucaoVariacaoModel();
        $result = $model->findByExercicioAndMes($this->factory->getSession()->getExercicio(), (int) $mes);

        return $result;
    }

    /**
     * @param TwigEngine|null $templating
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $data = [];
        $formData = (object) $this->getFormSonata();
        $qb = $this->searchValues($formData->codMes);
        $result = $qb->getQuery()->getArrayResult();
        if (count($result)) {
            $data = array_shift($result);
        }

        return array_merge(['response' => true], $data);
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
     * @return ExecucaoVariacaoModel
     */
    protected function getExecucaoVariacaoModel()
    {
        return new ExecucaoVariacaoModel($this->factory->getEntityManager());
    }

    /**
     * @return ExecucaoVariacao
     */
    protected function getExecucaoVariacao()
    {
        return new ExecucaoVariacao();
    }
}