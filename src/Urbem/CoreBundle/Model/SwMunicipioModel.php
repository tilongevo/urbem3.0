<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

/**
 * Class SwMunicipioModel
 *
 * @package Urbem\CoreBundle\Model
 */
class SwMunicipioModel extends AbstractModel
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * SwMunicipioModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:SwMunicipio");
    }
    
    /**
     * Lista os municipios por uf nos campos do tipo choice
     *
     * @deprecated O municipio não possui somente uma chave, ele possui uma composta.
     *             Use o método `getMunicipiosByUf()`.
     *
     * @param  integer $codUf  código do estado
     * @param  boolean $sonata identifica se deve ou inverter as chaves da lista
     * @return array
     */
    public function getChoicesMunicipioByUf($codUf, $sonata = false)
    {
        $swmunicipio = $this->repository->findByCodUf($codUf);

        $municipios = array();
        foreach ($swmunicipio as $chave => $municipio) {
            if ($sonata) {
                $municipios[$municipio->getNomMunicipio()] = $municipio->getCodMunicipio();
            } else {
                $municipios[$municipio->getCodMunicipio()] = $municipio->getNomMunicipio();
            }
        }
        
        return $municipios;
    }

    /**
     * @param SwUf $swUf
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getMunicipiosBySwUfQuery(SwUf $swUf)
    {
        $queryBuilder = $this->repository->createQueryBuilder('m');
        $queryBuilder
            ->join('m.fkSwUf', 'u')
            ->where('u.codUf = :codUf')
            ->andWhere('u.codPais = :codPais')
            ->setParameters([
                'codUf'   => $swUf->getCodUf(),
                'codPais' => $swUf->getCodPais()
            ]);

        return $queryBuilder;
    }

    /**
     * @param SwUf $swUf
     *
     * @return ArrayCollection
     */
    public function getMunicipiosByUf(SwUf $swUf)
    {
        $municipios = $this->getMunicipiosBySwUfQuery($swUf)->getQuery()->getResult();

        return new ArrayCollection($municipios);
    }

    /**
     * @param $exercicio
     *
     * @return SwMunicipio
     */
    public function getSwMunicipioByConfiguracao($exercicio)
    {
        $configuracaoModel = new ConfiguracaoModel($this->entityManager);
        $codMunicipio = $configuracaoModel
            ->getConfiguracaoOuAnterior('cod_municipio', Modulo::MODULO_ADMINISTRATIVO, $exercicio);

        $codUf = $configuracaoModel
            ->getConfiguracaoOuAnterior('cod_uf', Modulo::MODULO_ADMINISTRATIVO, $exercicio);

        /** @var SwMunicipio $swMunicipio */
        $swMunicipio = $this->repository->findOneBy([
            'codUf' => $codUf,
            'codMunicipio' => $codMunicipio
        ]);

        return $swMunicipio;
    }

    /**
     * @param $codUf
     * @param $codMunicipio
     * @return SwMunicipio $municipio
     */
    public function getSwMunicipioByCodUFCodMunicipio($codUf, $codMunicipio)
    {
        $municipio = $this->repository->findOneBy([
            'codUf' => $codUf,
            'codMunicipio' => $codMunicipio
        ]);

        return $municipio;
    }
}
