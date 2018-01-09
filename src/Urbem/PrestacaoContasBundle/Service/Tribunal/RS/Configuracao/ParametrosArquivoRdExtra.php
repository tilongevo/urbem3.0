<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Configuracao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica;
use Urbem\CoreBundle\Exception\Error;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Urbem\CoreBundle\Entity\Tcers;

/**
 * Class ParametrosArquivoRdExtra
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Configuracao
 */
class ParametrosArquivoRdExtra extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/RS/ParametrosArquivoRdExtra.js'
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
                $listItemsOld = $entityManager->getRepository(Tcers\RdExtra::class)->findAll();
                foreach($listItemsOld as $rdExtraItem) {
                    $entityManager->remove($rdExtraItem);
                }

                foreach($collectionData as $rdExtraItem) {
                    $rdExtra = $rdExtraItem->getNormData();
                    if (!$rdExtra instanceof Tcers\RdExtra) {
                        throw new \Exception(Error::INVALID_CLASS);
                    }

                    if (empty($rdExtra->getClassificacao())) {
                        continue;
                    }

                    $entityManager->persist($rdExtra);
                }
            });
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }
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
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @return array|\Urbem\CoreBundle\Entity\Tcers\RdExtra[]
     */
    public static function getListItemsRdExtra(EntityManager $entityManager)
    {
        return $entityManager->getRepository(Tcers\RdExtra::class)->findAll();
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
