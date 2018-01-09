<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Frota\VeiculoBaixado;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class VeiculoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Frota\Veiculo");
    }

    public function canRemove($object)
    {
        // Verifica VeiculoPropriedade
        $VeiculoPropriedadeRepository = $this->entityManager->getRepository("CoreBundle:Frota\\VeiculoPropriedade");
        $resVP = $VeiculoPropriedadeRepository->findOneByCodVeiculo($object->getCodVeiculo());

        // Verifica TransporteEscolar
        $TransporteEscolarRepository = $this->entityManager->getRepository("CoreBundle:Frota\\TransporteEscolar");
        $resTE = $TransporteEscolarRepository->findOneByCodVeiculo($object->getCodVeiculo());

        // Verifica Autorizacao
        $AutorizacaoRepository = $this->entityManager->getRepository("CoreBundle:Frota\\Autorizacao");
        $resAu = $AutorizacaoRepository->findOneByCodVeiculo($object->getCodVeiculo());

        // Verifica Utilizacao
        $UtilizacaoRepository = $this->entityManager->getRepository("CoreBundle:Frota\\Utilizacao");
        $resUl = $UtilizacaoRepository->findOneByCodVeiculo($object->getCodVeiculo());

        // Verifica UtilizacaoRetorno
        $UtilizacaoRetornoRepository = $this->entityManager->getRepository("CoreBundle:Frota\\UtilizacaoRetorno");
        $resUR = $UtilizacaoRetornoRepository->findOneByCodVeiculo($object->getCodVeiculo());

        // Verifica VeiculoBaixado
        $VeiculoBaixadoRepository = $this->entityManager->getRepository("CoreBundle:Frota\\VeiculoBaixado");
        $resVB = $VeiculoBaixadoRepository->findOneByCodVeiculo($object->getCodVeiculo());

        // Verifica Infracao
        $InfracaoRepository = $this->entityManager->getRepository("CoreBundle:Frota\\Infracao");
        $resIn = $InfracaoRepository->findOneByCodVeiculo($object->getCodVeiculo());

        // Verifica Abastecimento
        $AbastecimentoRepository = $this->entityManager->getRepository("CoreBundle:Frota\\Abastecimento");
        $resAb = $AbastecimentoRepository->findOneByCodVeiculo($object->getCodVeiculo());

        // Verifica Manutencao
        $ManutencaoRepository = $this->entityManager->getRepository("CoreBundle:Frota\\Manutencao");
        $resMa = $ManutencaoRepository->findOneByCodVeiculo($object->getCodVeiculo());

        return is_null($resVP) && is_null($resTE) && is_null($resAu) && is_null($resUl) && is_null($resUR)
            && is_null($resVB) && is_null($resIn) && is_null($resAb) && is_null($resMa);
    }

    public function getVeiculosUtilizando($veiculo = null)
    {
        return $this
            ->repository->getVeiculosUtilizando($veiculo);
    }

    public function getVeiculosLivres($veiculo = null)
    {
        return $this->repository
            ->getVeiculosLivres($veiculo);
    }

    /**
     * @param int $codVeiculo
     * @return null|object|Entity\Frota\Veiculo
     */
    public function getVeiculo($codVeiculo)
    {
        return $this->repository
            ->find($codVeiculo);
    }

    /**
     * @param int $codVeiculo
     * @return int
     */
    public function getKmById($codVeiculo)
    {
        return $this->getKm($this->getVeiculo($codVeiculo));
    }

    /**
     * @param Entity\Frota\Veiculo $veiculo
     * @return int
     */
    public function getLastManutencaKm(Entity\Frota\Veiculo $veiculo)
    {
        $manutencaoRepo = $this->entityManager->getRepository(Entity\Frota\Manutencao::class);
        return $manutencaoRepo->createQueryBuilder('m')
            ->select('MAX(m.km)')
            ->where('m.codVeiculo = :codVeiculo')
            ->setParameter('codVeiculo', $veiculo->getCodVeiculo())
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }


    public function getKm(Entity\Frota\Veiculo $veiculo)
    {
        $km = $this->getLastManutencaKm($veiculo);
        if ($km) {
            return $km;
        }

        $km = $veiculo->getKmInicial();
        if ($km) {
            return $km;
        }

        return 0;
    }

    /**
     * @return ORM\QueryBuilder
     */
    public function getVeiculosNaoBaixadosQuery()
    {
        $veiculoBaixadoQueryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder = $this->repository->createQueryBuilder('veiculo');

        $queryBuilder
            ->join('veiculo.fkFrotaMarca', 'fkFrotaMarca')
            ->join('veiculo.fkFrotaModelo', 'fkFrotaModelo')
            ->join('veiculo.fkFrotaTipoVeiculo', 'fkFrotaTipoVeiculo')
            ->join('veiculo.fkSwCategoriaHabilitacao', 'fkSwCategoriaHabilitacao')
            ->where(
                $queryBuilder->expr()->notIn(
                    'veiculo.codVeiculo',
                    $veiculoBaixadoQueryBuilder
                        ->select('veiculoBaixado.codVeiculo')
                        ->from(VeiculoBaixado::class, 'veiculoBaixado')
                        ->getDQL()
                )
            )
        ;
        
        return $queryBuilder;
    }
}
