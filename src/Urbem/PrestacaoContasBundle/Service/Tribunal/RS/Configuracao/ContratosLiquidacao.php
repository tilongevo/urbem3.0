<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Configuracao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Exception\Error;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Urbem\CoreBundle\Entity\Tcers;
use Symfony\Bridge\Twig\TwigEngine;

class ContratosLiquidacao extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const FIEL_COLLECTION_DATA = "formDynamicCollection";

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/RS/ContratosLiquidacao.js'
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
            $collectionData = $this->getDataCollectionFromField(self::FIEL_COLLECTION_DATA);

            return $em->transactional(function ($entityManager) use ($collectionData) {
                $listItemsOld = self::getListItemsContratosLiquidacao($entityManager);

                foreach($listItemsOld as $contrato) {
                    $entityManager->remove($contrato);
                }

                foreach($collectionData as $contrato) {
                    $contratoLiquidacao = $contrato->getNormData();

                    if ($contratoLiquidacao->isEmpty()) {
                        continue;
                    }

                    if (!$contratoLiquidacao instanceof Tcers\ContratosLiquidacao) {
                        throw new \Exception(Error::INVALID_CLASS);
                    }

                    $entityManager->persist($contratoLiquidacao);
                }

                $entityManager->flush();
            });
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }
    }

    /**
     * @param \Sonata\CoreBundle\Validator\ErrorElement $errorElement
     */
    public function validate(ErrorElement $errorElement)
    {
        $dataList = $this->getDataCollectionFromField(self::FIEL_COLLECTION_DATA);
        $linha = 1;

        foreach($dataList as $contrato) {
            $contratoLiquidacao = $contrato->getNormData();

            if ($contratoLiquidacao->isEmpty()) {
                continue;
            }

            $messageInvalidData = sprintf("Linha %s - *campo* - %s", $linha, Error::INVALID_VALUE);

            if (!$contratoLiquidacao->getCodLiquidacao() > 0) {
                $messageInvalidData = str_replace("*campo*", "Código Liquidação", $messageInvalidData);
                $errorElement->with("codLiquidacao")->addViolation($messageInvalidData)->end();
            }

            if (!(int)$contratoLiquidacao->getExercicio() > 0) {
                $messageInvalidData = str_replace("*campo*", "Exercício", $messageInvalidData);
                $errorElement->with("exercicio")->addViolation($messageInvalidData)->end();
            }

            if (!$contratoLiquidacao->getCodContrato() > 0) {
                $messageInvalidData = str_replace("*campo*", "Código Contrato", $messageInvalidData);
                $errorElement->with("codContrato")->addViolation($messageInvalidData)->end();
            }

            if (!$contratoLiquidacao->getCodContratoTce() > 0) {
                $messageInvalidData = str_replace("*campo*", "Código Contrato TCE", $messageInvalidData);
                $errorElement->with("codContratoTce")->addViolation($messageInvalidData)->end();
            }

            $linha++;
        }
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @return array|\Urbem\CoreBundle\Entity\Tcers\ContratosLiquidacao[]
     */
    public static function getListItemsContratosLiquidacao(EntityManager $entityManager)
    {
        return $entityManager->getRepository(Tcers\ContratosLiquidacao::class)->findAll();
    }

    /**
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        return [
            'response' => true
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);
    }
}
