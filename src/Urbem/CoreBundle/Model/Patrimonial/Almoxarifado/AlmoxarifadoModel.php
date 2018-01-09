<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 25/07/16
 * Time: 11:14
 */
namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Doctrine\ORM\EntityRepository;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\AlmoxarifadoRepository;

class AlmoxarifadoModel extends AbstractModel
{
    /** @var EntityRepository|AlmoxarifadoRepository  */
    protected $repository;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado::class);
    }

    public function getAllAlmoxarifado()
    {
        return $this->repository->getAllAlmoxarifado();
    }

    public function canRemove($object)
    {
        $PedidoTransferenciaRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\PedidoTransferencia");
        $resPtd = $PedidoTransferenciaRepository->findOneByCodAlmoxarifadoDestino($object->getCodAlmoxarifado());

        $PedidoTransferenciaRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\PedidoTransferencia");
        $resPto = $PedidoTransferenciaRepository->findOneByCodAlmoxarifadoOrigem($object->getCodAlmoxarifado());

        $LocalizacaoFisicaRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\LocalizacaoFisica");
        $resLf = $LocalizacaoFisicaRepository->findOneByCodAlmoxarifado($object->getCodAlmoxarifado());

        $LocalizacaoFisicaItemRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\LocalizacaoFisicaItem");
        $resLfi = $LocalizacaoFisicaItemRepository->findOneByCodAlmoxarifado($object->getCodAlmoxarifado());

        $RequisicaoRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\Requisicao");
        $resRe = $RequisicaoRepository->findOneByCodAlmoxarifado($object->getCodAlmoxarifado());

        $EstoqueMaterialRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\EstoqueMaterial");
        $resEm = $EstoqueMaterialRepository->findOneByCodAlmoxarifado($object->getCodAlmoxarifado());

        $InventarioRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\Inventario");
        $resIn = $InventarioRepository->findOneByCodAlmoxarifado($object->getCodAlmoxarifado());

        return is_null($resPtd) && is_null($resPto) && is_null($resLf) && is_null($resLfi) && is_null($resRe) && is_null($resEm) && is_null($resIn);
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @param string $value
     * @param string $rootAlias
     * @return ProxyQuery
     */
    public function searchByCgmAlmoxarifado(ProxyQuery $proxyQuery, $value, $rootAlias)
    {
        $proxyQuery
            ->leftJoin(sprintf("%s.cgmAlmoxarifado", $rootAlias), "cgmAlmoxarifado")
            ->andWhere("lower(cgmAlmoxarifado.nomFantasia) like lower(:cgmAlmoxarifado_numcgm)")
            ->setParameter('cgmAlmoxarifado_numcgm', '%'.$value.'%')
        ;

        return $proxyQuery;
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @param string $value
     * @param string $rootAlias
     * @return ProxyQuery
     */
    public function searchByCgmResponsavel(ProxyQuery $proxyQuery, $value, $rootAlias)
    {
        $proxyQuery
            ->leftJoin(sprintf("%s.cgmResponsavel", $rootAlias), "cgmResponsavel")
            ->andWhere("cgmResponsavel.numcgm = :cgmResponsavel_numcgm")
            ->setParameter('cgmResponsavel_numcgm', $value)
        ;

        return $proxyQuery;
    }

    /**
     * @param $codAlmoxarifado
     * @return null|object
     */
    public function getOneByCodAlmoxarifado($codAlmoxarifado)
    {
        return $this->repository->findOneBy([
            'codAlmoxarifado' => $codAlmoxarifado
        ]);
    }

    /**
     * @return ORM\QueryBuilder
     */
    public function getAlmoxarifadosPadraoQuery()
    {
        $queryBuilder = $this->repository->createQueryBuilder('almoxarifado');
        $queryBuilder
            ->join('almoxarifado.fkAlmoxarifadoPermissaoAlmoxarifados', 'permissaoAlmoxarifados')
            ->where('permissaoAlmoxarifados.padrao = \'t\'');

        return $queryBuilder;
    }

    /**
     * @return array
     */
    public function getAlmoxarifadosPadrao()
    {
        return $this->getAlmoxarifadosPadraoQuery()->getQuery()->getResult();
    }
}
