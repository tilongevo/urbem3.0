<?php

namespace Urbem\CoreBundle\Model\Normas;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Entity\Normas;
use Urbem\CoreBundle\Entity\Normas\AtributoNormaValor;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Normas\NormaDataTermino;
use Urbem\CoreBundle\Entity\Normas\NormaTipoNorma;
use Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisLdo;
use Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLeisPpa;
use Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco;
use Urbem\CoreBundle\Repository\Normas\NormaRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao\ConfiguracaoLeiLDO;

class NormaModel extends AbstractModel
{
    protected $entityManager = null;

    const VALOR_INICIAL = 1;

    /**
     * @var NormaRepository $repository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(
            'CoreBundle:Normas\Norma'
        );
    }

    /**
     * @param Norma $norma
     *
     * @return bool
     */
    public function canRemove(Norma $norma)
    {
        $canRemove = false;

        /** @var AtributoNormaValor $atributoNormaValor */
        foreach ($norma->getFkNormasAtributoNormaValores() as $atributoNormaValor) {
            $canRemove = $this->canRemoveWithAssociation($atributoNormaValor, ['fkNormasNorma', 'fkNormasAtributoTipoNorma']);

            if ($canRemove) {
                $this->remove($atributoNormaValor, false);
            }
        }

        /** @var NormaTipoNorma $normaTipoNorma */
        foreach ($norma->getFkNormasNormaTipoNormas() as $normaTipoNorma) {
            $canRemove = $this->canRemoveWithAssociation($normaTipoNorma, ['fkNormasTipoNorma', 'fkNormasTipoNorma']);

            if ($canRemove) {
                $this->remove($normaTipoNorma, false);
            }
        }

        $canRemove = $this->canRemoveWithAssociation($norma);

        if ($canRemove) {
            $this->entityManager->flush();
        }

        return $canRemove;
    }

    public function getNormaAndTipoByCodContrato($codContrato)
    {
        return $this->repository->getNormaAndTipoByCodContrato($codContrato);
    }

    public function findByCodNorma($codNorma)
    {
        return $this->repository->findByCodNorma($codNorma);
    }

    public function getNormas($exercicio)
    {
        return $this->repository->getNormas($exercicio);
    }

    public function getNormasPorExercicio($exercicio)
    {
        return $this->repository->getNormasPorExercicio($exercicio);
    }

    public function getNormasComTiposToArray($exercicio, $useSelect2 = true)
    {
        $allNormas = $this->repository->getNormas($exercicio);
        $result = [];
        foreach ($allNormas as $norma) {
            $this->parseNormasTipos($norma, $result, $useSelect2);
        }

        return $result;
    }

    public function getCustomNormasComTipos($exercicio, $keys = [], $queryBuilder = false)
    {
        $query = $this->repository->createQueryBuilder('norma');
        $query
            ->leftJoin('norma.fkNormasTipoNorma', 'fkNormasTipoNorma')
            ->where('norma.exercicio = :exercicio')
            ->setParameter('exercicio', $exercicio);

        return $query;
    }

    /**
     * @param Normas\Norma $norma
     * @return string
     */
    public function getFormattedNormaString(Normas\Norma $norma)
    {
        $tipoNorma = $norma->getFkNormasTipoNorma()->getNomTipoNorma();
        $numNorma = "{$norma->getNumNorma()}/{$norma->getExercicio()}";
        $nomNorma = $norma->getNomNorma();

        return "{$tipoNorma} {$numNorma} - {$nomNorma}";
    }

    public function parseNormasTipos($norma, &$result, $useSelect2)
    {
        $codNorma = $useSelect2 ? $norma['nom_norma'] : $norma['cod_norma'];
        $nameNorma = $useSelect2 ? $norma['cod_norma'] : $norma['nom_norma'];

        if (array_key_exists($norma['nom_tipo_norma'], $result)) {
            return $result[$norma['nom_tipo_norma']][$codNorma] = $nameNorma;
        }

        return $result[$norma['nom_tipo_norma']] = [$codNorma => $nameNorma];
    }

    public function getNormaByLicitacao(Licitacao\Licitacao $licitacao)
    {
        $result = $this->repository->getNormaByLicitacao([
            'cod_licitacao' => $licitacao->getCodLicitacao(),
            'cod_entidade' => $licitacao->getCodEntidade(),
            'exercicio' => $licitacao->getExercicio()
        ]);

        return $result;
    }
    
    /**
     * Procura todas as Normas filtrando pelo tipo
     * @param  integer  $tipo   código do tipo da Norma
     * @param  boolean $sonata quando a requisição é via ajax ou sonata
     * @return array
     */
    public function findAllNormasPorTipo($tipo, $sonata = false)
    {
        $normas = $this->repository->findAllNormasPorTipo($tipo);
        
        $options = [];
        foreach ($normas as $norma) {
            if ($sonata) {
                $options[$norma['codNorma'] . " - " . $norma['nomNorma']] = $norma['codNorma'];
            } else {
                $options[$norma['codNorma']] = $norma['codNorma'] . " - " . $norma['nomNorma'];
            }
        }
        
        return $options;
    }

    /**
     * @param $paramsWhere
     * @return mixed
     */
    public function getNormasJson($paramsWhere)
    {
        return $this->repository->getNormasJson($paramsWhere);
    }

    /**
     * @param $exercicio
     * @return null|object|Norma
     */
    public function getNormaConsultaPPATCEMGByExercicio($exercicio)
    {
        $norma =  $this->getNormaTCEByExercicio(
            $exercicio,
            ConfiguracaoLeisPpa::class,
            ConfiguracaoLeisPpa::TIPO_CONFIGURACAO_CONSULTA,
            1
        );

        return array_shift($norma);
    }

    /**
     * @param $exercicio
     * @return null|object|Norma
     */
    public function getNormaConsultaLDOTCEMGByExercicio($exercicio)
    {
        $norma =  $this->getNormaTCEByExercicio(
            $exercicio,
            ConfiguracaoLeisLdo::class,
            ConfiguracaoLeisLdo::TIPO_CONFIGURACAO_CONSULTA,
            1
        );

        return array_shift($norma);
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function getNormasAlteracaoPPATCEMGByExercicio($exercicio)
    {
        return $this->getNormaTCEByExercicio($exercicio, ConfiguracaoLeisPpa::class, ConfiguracaoLeisPpa::TIPO_CONFIGURACAO_ALTERACAO);
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function getNormasAlteracaoLDOTCEMGByExercicio($exercicio)
    {
        return $this->getNormaTCEByExercicio($exercicio, ConfiguracaoLeisLdo::class, ConfiguracaoLeisLdo::TIPO_CONFIGURACAO_ALTERACAO);
    }

    public function setNormaConsultaPPATCEMG(Norma $norma, $exercicio)
    {
        $this->setNormasAlteracaoTCE([$norma], $exercicio, ConfiguracaoLeisPpa::class, ConfiguracaoLeisPpa::TIPO_CONFIGURACAO_CONSULTA);
    }

    public function setNormaConsultaLDOTCEMG(Norma $norma, $exercicio)
    {
        $this->setNormasAlteracaoTCE([$norma], $exercicio, ConfiguracaoLeisLdo::class, ConfiguracaoLeisLdo::TIPO_CONFIGURACAO_CONSULTA);
    }

    public function setNormasAlteracaoPPATCEMG(array $normas, $exercicio)
    {
        $this->setNormasAlteracaoTCE($normas, $exercicio, ConfiguracaoLeisPpa::class, ConfiguracaoLeisPpa::TIPO_CONFIGURACAO_ALTERACAO);
    }

    public function setNormasAlteracaoLDOTCEMG(array $normas, $exercicio)
    {
        $this->setNormasAlteracaoTCE($normas, $exercicio, ConfiguracaoLeisLdo::class, ConfiguracaoLeisLdo::TIPO_CONFIGURACAO_ALTERACAO);
    }

    /**
     * @param array $normas
     * @param $exercicio
     * @param string $class ConfiguracaoLeisLdo OR ConfiguracaoLeisPpa
     * @param string $tipoConfiguracao TIPO_CONFIGURACAO_ALTERACAO OR TIPO_CONFIGURACAO_CONSULTA
     */
    protected function setNormasAlteracaoTCE(array $normas, $exercicio, $class, $tipoConfiguracao)
    {
        $notInCodNorma = [];

        foreach ($normas as $norma) {
            $configuracao = $this->entityManager->getRepository($class)->findOneBy([
                'exercicio' => $exercicio,
                'tipoConfiguracao' => $tipoConfiguracao,
                'fkNormasNorma' => $norma
            ]);

            $configuracao = null === $configuracao ? new $class : $configuracao;
            $configuracao->setExercicio($exercicio);
            $configuracao->setFkNormasNorma($norma);
            $configuracao->setStatus(true);
            $configuracao->setTipoConfiguracao($tipoConfiguracao);

            $this->entityManager->persist($configuracao);
            $this->entityManager->flush($configuracao);

            $notInCodNorma[] = $norma->getCodNorma();
        }

        $qb = $this->entityManager->getRepository($class)->createQueryBuilder('configuracao');
        $qb->update($class, 'configuracao');
        $qb->set('configuracao.status', 'false');
        $qb->andWhere('configuracao.exercicio = :exercicio');
        $qb->andWhere('configuracao.tipoConfiguracao = :tipoConfiguracao');

        if (0 < count($notInCodNorma)) {
            $qb->andWhere($qb->expr()->notIn('configuracao.codNorma', $notInCodNorma));
        }

        $qb->setParameter('exercicio', $exercicio);
        $qb->setParameter('tipoConfiguracao', $tipoConfiguracao);
        $qb->getQuery()->execute();
    }

    /**
     * @param $exercicio
     * @param string $class ConfiguracaoLeisLdo OR ConfiguracaoLeisPpa
     * @param string $tipoConfiguracao TIPO_CONFIGURACAO_ALTERACAO OR TIPO_CONFIGURACAO_CONSULTA
     * @param null $limit
     * @return array
     */
    protected function getNormaTCEByExercicio($exercicio, $class, $tipoConfiguracao, $limit = null)
    {
        $configuracoes = $this->entityManager->getRepository($class)->findBy([
            'exercicio' => $exercicio,
            'tipoConfiguracao' => $tipoConfiguracao,
            'status' => true
        ], null, $limit);

        $normas = [];

        foreach ($configuracoes as $configuracao) {
            $normas[] = $configuracao->getFkNormasNorma();
        }

        return $normas;
    }

    /**
     * @param $exercicio
     * @param $entidade
     * @return array
     */
    public function findDecretoToArray($exercicio, $entidade)
    {
        $decretos = $this->findDecretoTcemgToArray($exercicio, $entidade);

        if (count($decretos)) {

            return $decretos;
        }

        $this->createDecreto($exercicio, $entidade);

        return $this->findDecretoTcemgToArray($exercicio, $entidade);
    }

    /**
     * @param $exercicio
     * @param $entidade
     * @return array
     */
    protected function findDecretoTcemgToArray($exercicio, $entidade)
    {
        $qb = $this->repository->findDecretoTcemg($exercicio, $entidade);
        $result = $qb->getQuery()->getArrayResult();

        return $result;
    }

    /**
     * @param $exercicio
     * @param $entidade
     */
    protected function createDecreto($exercicio, $entidade)
    {
        $qb = $this->repository->withExercicioQueryBuilder($exercicio);

        $decretos = $qb->getQuery()->getResult();

        /** @var Norma $decreto */
        foreach ($decretos as $decreto) {
            $tipoRegPreco = $this->getTipoRegistroPreco();
            $tipoRegPreco->setExercicio($exercicio);
            $tipoRegPreco->setCodEntidade($entidade);
            $tipoRegPreco->setCodNorma($decreto->getCodNorma());
            $tipoRegPreco->setCodTipoDecreto(null);
            $this->save($tipoRegPreco);
        }
    }

    /**
     * @return TipoRegistroPreco
     */
    protected function getTipoRegistroPreco()
    {
        return new TipoRegistroPreco();
    }
}
