<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho;
use Urbem\CoreBundle\Entity\Empenho\CategoriaEmpenho;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenho;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Empenho\AutorizacaoEmpenhoRepository;

/**
 * Class AutorizacaoEmpenhoModel
 * @package Urbem\CoreBundle\Model\Empenho
 */
class AutorizacaoEmpenhoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var AutorizacaoEmpenhoRepository|null */
    protected $repository = null;

    /**
     * AutorizacaoEmpenhoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        /** @var AutorizacaoEmpenhoRepository repository */
        $this->repository = $this->entityManager->getRepository(AutorizacaoEmpenho::class);
    }

    /**
     * @param string $exercicio
     * @param int $codEntidade
     * @return int
     */
    public function getProximoCodAutorizacao($exercicio, $codEntidade)
    {
        return $this->repository->getProximoCodAutorizacao($exercicio, $codEntidade);
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return mixed
     */
    public function listarMaiorData($exercicio, $codEntidade)
    {
        $maiorDataAutorizacao = $this->repository->recuperaMaiorDataAutorizacaoEmpenho($exercicio, $codEntidade);
        return $maiorDataAutorizacao;
    }

    /**
     * @param Entidade $entidade
     * @param $exercicioEntidade
     * @param Unidade $unidade
     * @param CategoriaEmpenho $categoria
     * @param $data
     * @param PreEmpenho $codPreEmpenho
     * @return AutorizacaoEmpenho
     */
    public function saveAutorizacaoEmpenho(Entidade $entidade, $exercicioEntidade, Unidade $unidade, CategoriaEmpenho $categoria, $data, PreEmpenho $codPreEmpenho)
    {
        $dateFormat = \DateTime::createFromFormat("d/m/Y", $data);
        $dataMicrosecondPk = new DateTimeMicrosecondPK($dateFormat->format(DateTimeMicrosecondPK::FORMAT));
        $codAutorizacao = $this->getProximoCodAutorizacao($exercicioEntidade, $entidade->getCodEntidade());
        $obTEmpenhoAutorizacaoEmpenho = new AutorizacaoEmpenho();
        $obTEmpenhoAutorizacaoEmpenho->setFkOrcamentoEntidade($entidade);
        $obTEmpenhoAutorizacaoEmpenho->setFkEmpenhoPreEmpenho($codPreEmpenho);
        $obTEmpenhoAutorizacaoEmpenho->setDtAutorizacao($dataMicrosecondPk);
        $obTEmpenhoAutorizacaoEmpenho->setCodAutorizacao($codAutorizacao);
        $obTEmpenhoAutorizacaoEmpenho->setFkEmpenhoCategoriaEmpenho($categoria);
        $obTEmpenhoAutorizacaoEmpenho->setFkOrcamentoUnidade($unidade);
        $this->save($obTEmpenhoAutorizacaoEmpenho);

        if ($categoria->getCodCategoria() == 2 || $categoria->getCodCategoria() == 3) {
            $contrapartidaAutorizacaoModel = new ContrapartidaAutorizacaoModel($this->entityManager);
            $contrapartidaAutorizacaoModel->saveContrapartidaAutorizacao($obTEmpenhoAutorizacaoEmpenho);
        }
        return $obTEmpenhoAutorizacaoEmpenho;
    }

    /**
     * Filtro de emitir empenho por autorização do sistema antigo
     *
     * @param  integer $numcgm
     * @param  string $exercicio
     * @param  array $filter
     * @return array
     */
    public function filterAutorizacaoEmpenho($numcgm, $exercicio, $filter)
    {
        $filterAutorizacaoEmpenho = $this->entityManager
            ->getRepository(AutorizacaoEmpenho::class)
            ->getAutorizacaoEmpenho($numcgm, $exercicio, $filter);

        return $filterAutorizacaoEmpenho;
    }

    /**
     * @param $numcgm
     * @param $filter
     * @return mixed
     */
    public function filterDuplicarAutorizacaoEmpenho($numcgm, $filter)
    {
        return $this->repository->filterDuplicarAutorizacaoEmpenho($numcgm, $filter);
    }
}
