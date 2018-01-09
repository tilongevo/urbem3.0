<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;

use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade;
use Urbem\CoreBundle\Entity\Tesouraria;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

/**
 * Class EntidadeModel
 *
 * @package Urbem\CoreBundle\Model\Orcamento
 */
class EntidadeModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    /**
     * EntidadeModel constructor.
     *
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\Entidade");
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function getEntidades($exercicio)
    {
        return $this->repository->findEntidades($exercicio, $params = '');
    }

    /**
     * @param $exercicio
     *
     * @return mixed
     */
    public function getEntidadeByCgmAndExercicio($exercicio)
    {
        $entidades = $this->repository->getEntidadeByCgmAndExercicio($exercicio);

        $entidadesEntity = array();
        foreach ($entidades as $entidade) {
            $entidadesEntity[] = $this->repository->findById($entidade->id);
        }

        return array_shift($entidadesEntity);
    }

    /**
     * @param $exercicio
     *
     * @return ORM\QueryBuilder
     */
    public function getEntidadeByCgmAndExercicioQueryBuilder($exercicio)
    {
        return $this->repository->getEntidadeByCgmAndExercicioQueryBuilder($exercicio);
    }

    /**
     * @param $codEntidade
     *
     * @return mixed
     */
    public function findOneByCodEntidade($codEntidade)
    {
        return $this->repository->findOneByCodEntidade($codEntidade);
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return null|object
     */
    public function findOneByCodEntidadeAndExercicio($codEntidade, $exercicio)
    {
        return $this->repository->findOneBy(['codEntidade' => $codEntidade, 'exercicio' => $exercicio]);
    }

    /**
     * @param integer $yearSource Ano exercicio a ser copiado
     * @param integer $yearTarget Ano exercicio a ser criado
     * @return bool
     * @throws \Exception
     */
    public function replicaEntidade($yearSource, $yearTarget, $translator)
    {
        // Este é o ano que teremos que gerar as duplicadas
        $yearTarget = (int) $yearTarget;

        // Este é o ano que vamos copiar
        $yearSource = (int) $yearSource;

        $entidadesADuplicar = $this->repository->findByExercicio((string) $yearTarget);

        // Verificamos se já existem entidades para o exercicio a ser duplicado.
        // Se existir, retornar erro
        if (count($entidadesADuplicar)) {
            throw new \Exception($translator->trans('label.orcamento.entidade.exercicioExistente', ['%exercicio%' => $yearTarget]));
        }

        $entidades = $this->repository->findByExercicio((string) $yearSource);

        if (!count($entidades)) {
            throw new \Exception($translator->trans('label.orcamento.entidade.entidadeInexistente', ['%exercicio%' => $yearSource]));
        }

        foreach ($entidades as $entidade) {
            $entidadeDuplicada = new Entidade();
            $entidadeDuplicada->setCodEntidade($entidade->getCodEntidade());
            $entidadeDuplicada->setExercicio((string) $yearTarget);
            $entidadeDuplicada->setFkSwCgm($entidade->getFkSwCgm());
            $entidadeDuplicada->setFkSwCgmPessoaFisica($entidade->getFkSwCgmPessoaFisica());
            if (!$entidade->getFkEconomicoResponsavelTecnico()) {
                $responsavelTecnico = $this
                    ->entityManager
                    ->getRepository('CoreBundle:Economico\ResponsavelTecnico')
                    ->findOneBy([
                        'numcgm' => $entidade->getCodRespTecnico()
                    ]);
                $entidadeDuplicada->setFkEconomicoResponsavelTecnico($responsavelTecnico);
                $entidadeDuplicada->setCodProfissao($responsavelTecnico->getCodProfissao());
                $entidadeDuplicada->setSequencia($responsavelTecnico->getSequencia());
            } else {
                $entidadeDuplicada->setFkEconomicoResponsavelTecnico($entidade->getFkEconomicoResponsavelTecnico());
                $entidadeDuplicada->setCodProfissao($entidade->getFkEconomicoResponsavelTecnico()->getCodProfissao());
                $entidadeDuplicada->setSequencia($entidade->getFkEconomicoResponsavelTecnico()->getSequencia());
            }

            foreach ($entidade->getFkOrcamentoUsuarioEntidades() as $usuarioEntidade) {
                $usuarioEntidadeDuplicada = new UsuarioEntidade();
                $usuarioEntidadeDuplicada->setFkAdministracaoUsuario($usuarioEntidade->getFkAdministracaoUsuario());
                $entidadeDuplicada->addFkOrcamentoUsuarioEntidades($usuarioEntidadeDuplicada);
            }

            $this->entityManager->persist($entidadeDuplicada);
        }
        $this->entityManager->flush();
        return true;
    }

    /**
     * @param array $params
     * @return Entidade
     */
    public function find(array $params)
    {
        /** @var Entidade $entidade */
        $entidade = $this->repository->findOneBy($params);

        return $entidade;
    }

    /**
     * @param $exercicio
     * @return ORM\QueryBuilder
     */
    public function findByExercicioQuery($exercicio)
    {
        $queryBuilder = $this->repository->createQueryBuilder('entidade');
        $queryBuilder
            ->join('entidade.fkSwCgm', 'swCgm')
            ->where('entidade.exercicio = :exercicio')
            ->setParameter('exercicio', $exercicio)
        ;

        return $queryBuilder;
    }

    /**
     * @return ORM\QueryBuilder
     */
    public function recuperaEntidadesParaPagamentosEstorno()
    {
        $queryBuilder = $this->repository->createQueryBuilder('entidade');

        $join = 'pagtoEstorno.codEntidade = entidade.codEntidade';

        return $queryBuilder
            ->join(Tesouraria\VwOrcamentariaPagamentoEstornoView::class, 'pagtoEstorno', 'WITH', $join)
        ;
    }

    /**
     * @param $exercicio
     *
     * @return array
     */
    public function recuperaEntidadeEmpenho($exercicio)
    {
        $queryBuilder = $this->repository->createQueryBuilder('entidade');
        $queryBuilder->join('entidade.fkEmpenhoEmpenhos', 'empenhos')
            ->where('empenhos.exercicio = :exercicio')
            ->setParameter('exercicio', $exercicio)
            ->orderBy('entidade.codEntidade')
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param $exercicio
     *
     * @return null|object|Entidade
     */
    public function getEntidadePrefeitura($exercicio)
    {
        $codEntidadePrefeitura = (new ConfiguracaoModel($this->entityManager))
            ->getConfiguracao('cod_entidade_prefeitura', Modulo::MODULO_ORCAMENTO, true, $exercicio);

        return $this->repository->findOneBy([
            'codEntidade' => $codEntidadePrefeitura,
            'exercicio' => $exercicio
        ]);
    }
}
