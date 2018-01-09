<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Configuracao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\PrestacaoContasBundle\Form\Builder\ArrayParser;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Urbem\CoreBundle\Entity\Tcers;

class RelacionamentoContaEntidade extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/RS/RelacionamentoContaEntidade.js'
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
            $exercicio = $this->factory->getSession()->getExercicio();
            $itemsSubmitted = $this->getListItemsSubmittedInTheForm();

            return $em->transactional(function ($entityManager) use ($collectionData, $exercicio, $itemsSubmitted) {
                $listItemsOld = $entityManager->getRepository(Tcers\PlanoContaEntidade::class)->findBy(['exercicio' => $exercicio]);
                foreach($listItemsOld as $planoContaEntidade) {
                    $entityManager->remove($planoContaEntidade);
                }

                foreach($collectionData as $planoContaEntidadeItem) {
                    $planoContaEntidade = $planoContaEntidadeItem->getNormData();
                    if (!$planoContaEntidade instanceof Tcers\PlanoContaEntidade) {
                        throw new \Exception(Error::INVALID_CLASS);
                    }

                    $keySearch = sprintf("%s~%s", $planoContaEntidade->getCodConta(), $planoContaEntidade->getExercicio());
                    if (empty($itemsSubmitted) || !in_array($keySearch, $itemsSubmitted)) {
                        $entityManager->remove($planoContaEntidade);
                        continue;
                    }

                    $entityManager->persist($planoContaEntidade);
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
    private function getListItemsSubmittedInTheForm()
    {
        $formData = $this->getFormSonata();
        $itemsPost = $itemsExists = [];
        foreach ($formData as $item) {
            if (is_array($item) && array_key_exists("formDynamicCollection", $item) && array_key_exists("dynamic_collection", $item["formDynamicCollection"])) {
                $itemsPost = $item["formDynamicCollection"]["dynamic_collection"];
                break;
            }
        }

        foreach ($itemsPost as $item) {
            $itemsExists[] = array_shift($item);
        }

        return $itemsExists;
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
    public static function getListContaEntidade(EntityManager $entityManager, $exercicio)
    {
        return $entityManager->getRepository(Tcers\PlanoContaEntidade::class)->findBy(['exercicio' => $exercicio]);
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
