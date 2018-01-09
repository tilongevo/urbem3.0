<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\CatalogoClassificacaoRepository;

/**
 * Class CatalogoClassificacaoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class CatalogoClassificacaoModel extends AbstractModel
{
    /** @var ORM\EntityManager|null $entityManager */
    protected $entityManager = null;
    /** @var CatalogoClassificacaoRepository $repository */
    protected $repository = null;

    /**
     * CatalogoClassificacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\CatalogoClassificacao");
    }

    /**
     * @param Almoxarifado\CatalogoClassificacao $object
     * @return bool
     */
    public function canRemove($object)
    {
        $classificacoesFilhas = $this->repository->findClassificacoesFilhas([
            'estrutural' => $object->getCodEstrutural(),
            'codCatalogo' => $object->getCodCatalogo()
        ]);
        $classificacoesFilhas = (count($classificacoesFilhas) > 0);

        $catalogoClassificacaoBloqueioRepository = $this->entityManager->getRepository(Almoxarifado\CatalogoClassificacaoBloqueio::class);
        $resCatalogoClassificacaoBloqueio = $catalogoClassificacaoBloqueioRepository->findOneBy([
            'codClassificacao' => $object->getCodClassificacao(),
            'codCatalogo' => $object->getCodCatalogo()
        ]);

        $catalogoItemRepository = $this->entityManager->getRepository(Almoxarifado\CatalogoItem::class);
        $resCatalogoItem = $catalogoItemRepository->findOneBy([
            'codClassificacao' => $object->getCodClassificacao(),
            'codCatalogo' => $object->getCodCatalogo()
        ]);

        return !$classificacoesFilhas &&
            is_null($resCatalogoClassificacaoBloqueio) &&
            is_null($resCatalogoItem);
    }

    /**
     * @param $params
     * @return array
     */
    public function getClassificacaoNivel($params)
    {
        return $this->repository->getClassificacaoNivel($params);
    }

    /**
     * @param $params['estrutural', 'codCatalogo']
     * @return array
     */
    public function getNivelClassificacao($params)
    {
        return $this->repository->getNivelClassificacao($params);
    }

    /**
     * @param $params
     * @return array
     */
    public function getProxEstruturalLivre($params)
    {
        return $this->repository->getProxEstruturalLivre($params);
    }

    /**
     * @param $codCatalogo
     * @return int
     */
    public function getProxCodClassificacao($codCatalogo)
    {
        return $this->repository->getProxCodClassificacao($codCatalogo);
    }

    /**
     * @param $params
     * @return array
     */
    public function getMascaraReduzida($params)
    {
        return $this->repository->getMascaraReduzida($params);
    }

    /**
     * @param $params
     * @return array
     */
    public function getMascaraCompleta($params)
    {
        return $this->repository->getMascaraCompleta($params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getClassificacaoFilhos(array $params)
    {
        return $this->repository->getClassificacaoFilhos($params);
    }

    /**
    * @param array $params
    * @return array
    */
    public function getCatalogoClassificacao(array $params)
    {
        return $this->repository->getCatalogoClassificacao($params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getClassificacaoMae(array $params)
    {
        return $this->repository->getClassificacaoMae($params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getClassificacoesByClassificacaoMae(array $params)
    {
        return $this->repository->getClassificacoesByClassificacaoMae($params);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getNivelCategoriasWithMascara(array $params)
    {
        return $this->repository->getNivelCategoriasWithMascara($params);
    }

    /**
     * @param array $params
     * @return Almoxarifado\CatalogoClassificacao
     */
    public function findOneBy($params)
    {
        return $this->repository->findOneBy($params);
    }
}
