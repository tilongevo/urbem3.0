<?php

namespace Urbem\CoreBundle\Model\Tcemg;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivo;
use Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivoDescricao;
use Urbem\CoreBundle\Repository\Tcemg\ConsideracaoArquivoRepository;

/**
 * Class ConsideracaoArquivoModel
 * @package Urbem\CoreBundle\Model\Tcemg
 */
class ConsideracaoArquivoModel extends AbstractModel
{
    const FIELD_ENTIDADE = 'codEntidade';
    const FIELD_PERIODO = 'periodo';
    const FIELD_MODULO = 'moduloSicom';
    const FIELD_COD_ARQUIVO = 'codArquivo';

    /**
     * @var array
     */
    protected $planejamentoMensalIds = [
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
        21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40,
        41, 58, 59];

    /**
     * @var array
     */
    protected $arquivosPlanejamentoIds = [
        1, 3, 45, 47, 48, 49, 50, 51, 6, 53, 54, 55, 56, 41
    ];

    /**
     * @var array
     */
    protected $balanceteContabilIds =  [
        1, 41, 42
    ];

    /**
     * @var array
     */
    protected $inclusaoProgramasIds = [
        1, 43, 44, 57, 41
    ];

    /**
     * @var array
     */
    protected $folhaPagamentoIds = [
        60
    ];

    /**
     * @var ORM\EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var ConsideracaoArquivoRepository $repository
     */
    protected $repository = null;

    /**
     * ConsideracaoArquivoDescricaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ConsideracaoArquivo::class);
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $periodo
     * @param $modulo
     * @return array
     */
    public function findConsideracoesToArray($exercicio, $codEntidade, $periodo, $modulo)
    {
        $filters = $this->getFilters($exercicio, $codEntidade, $periodo, $modulo);

        $qb = $this->repository->findConsideracoes($filters);

        $result = $qb->getQuery()->getArrayResult();

        if(!count($result)) {
            $this->insert($exercicio, $codEntidade, $periodo, $modulo);
            $qb = $this->repository->findConsideracoes($filters);
            $result = $qb->getQuery()->getArrayResult();
        }

        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $periodo
     * @param $modulo
     * @return array
     */
    protected function getFilters($exercicio, $codEntidade, $periodo, $modulo)
    {
        return  [
            self::FIELD_EXERCICIO => $exercicio,
            self::FIELD_ENTIDADE => $codEntidade,
            self::FIELD_PERIODO => $periodo,
            self::FIELD_MODULO => $modulo,

        ];
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $periodo
     * @param $modulo
     */
    protected function insert($exercicio, $codEntidade, $periodo, $modulo)
    {
        $codArquivos = $this->getArquivosIds($modulo);

        foreach ($codArquivos as $codArquivo) {
            $entity = $this->getConsideracaoArquivoDescricao();
            $entity->setCodArquivo($codArquivo);
            $entity->setExercicio($exercicio);
            $entity->setCodEntidade($codEntidade);
            $entity->setPeriodo($periodo);
            $entity->setModuloSicom($modulo);
            $entity->setDescricao('');
            $this->save($entity);
        }
    }

    /**
     * @param string $modulo
     * @return array
     */
    protected function getArquivosIds($modulo)
    {
        $ids = [];

        switch ($modulo) {
            case 'mensal':
                $ids = $this->planejamentoMensalIds;
                break;
            case 'balancete':
                $ids = $this->balanceteContabilIds;
                break;
            case 'planejamento':
                $ids = $this->arquivosPlanejamentoIds;
                break;
            case 'inclusao':
                $ids = $this->inclusaoProgramasIds;
                break;
            case 'folha':
                $ids = $this->folhaPagamentoIds;
                break;
        }

        return $ids;
    }

    /**
     * @return ConsideracaoArquivoDescricao
     */
    protected function getConsideracaoArquivoDescricao()
    {
        return new ConsideracaoArquivoDescricao();
    }
}
