<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwPais;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Repository;

class SwCgmPessoaFisicaModel extends AbstractModel implements InterfaceModel
{
    /**
     * @var ORM\EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var ORM\EntityRepository|null|Repository\SwCgmPessoaFisicaRepository
     */
    protected $repository = null;

    /**
     * SwCgmPessoaFisicaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:SwCgmPessoaFisica");
    }

    /**
     * @param $id
     * @return ORM\QueryBuilder
     */
    public function getCgmSelecionado($id)
    {
        return $this->repository->getCgmSelecionado($id);
    }

    /**
     * @param $numCgm
     * @return mixed
     */
    public function getNumCgmByNumCgm($numCgm)
    {
        return $this->repository->findOneByNumcgm($numCgm);
    }

    public function getEnderecoByNumCgm($numCgm)
    {
        /** @var SwCgmPessoaFisica $cgmPessoaFisica */
        $cgmPessoaFisica = $this->repository->find($numCgm);

        /** @var SwCgm $fkSwCgm */
        $fkSwCgm = $cgmPessoaFisica->getFkSwCgm();

        $swMunicipioModel = new SwMunicipioModel($this->entityManager);

        /** @var SwMunicipio $municipio */
        $municipio = $swMunicipioModel->getSwMunicipioByCodUFCodMunicipio(
            $fkSwCgm->getCodUf(),
            $fkSwCgm->getCodMunicipio()
        );

        /** @var SwUf $uf */
        $uf = $municipio->getFkSwUf();

        /** @var SwPais $pais */
        $pais = $uf->getFkSwPais();

        $endereço = [
            'logradouro' => $fkSwCgm->getLogradouro(),
            'numero' => $fkSwCgm->getNumero(),
            'complemento' => $fkSwCgm->getComplemento(),
            'bairro' => $fkSwCgm->getBairro(),
            'cep' => $fkSwCgm->getCep(),
            'municipio' => $municipio->getNomMunicipio(),
            'uf' => $uf->getNomUf(),
            'pais' => $pais->getNomPais(),
            'telefone' => $fkSwCgm->getFoneResidencial()
        ];

        return $endereço;
    }

    /**
     * @TODO checar @deprecated
     * @param $name
     * @return ORM\QueryBuilder
     */
    private function getQueryBuilderForCgmPessoaFisicaByName($name)
    {
        $queryBuilder = $this->repository->createQueryBuilder('pf');
        $queryBuilder
            ->leftJoin('pf.fkSwCgm', 'cgm')
            ->where($queryBuilder->expr()->like('LOWER(cgm.nomCgm)', ':name'))
        ;
        $queryBuilder->setParameter('name', '%' . strtolower($name) . '%');
        return $queryBuilder;
    }

    /**
     * @TODO checar @deprecated
     * @param $name
     * @return array
     */
    public function filterPessoaFisicaByName($name)
    {
        $queryBuilder = $this->getQueryBuilderForCgmPessoaFisicaByName($name);
        $queryBuilder->orderBy('cgm.nomCgm', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @TODO checar @deprecated
     * Retorna cgm pessoa fisica que nao sao servidores
     * @param $name
     * @return array
     */
    public function filterPessoaFisicaByNameNotServidor($name)
    {
        $queryBuilder = $this->getQueryBuilderForCgmPessoaFisicaByName($name);
        $queryBuilder->leftJoin('pf.fkPessoalServidor', 's', 'WITH', 'pf.numcgm=s.numcgm');

        $queryBuilder->orWhere(
            $queryBuilder->expr()->eq('pf.numcgm', ':idcgm')
        )
            ->andWhere(
                $queryBuilder->expr()->isNull('s.numcgm')
            );
        $queryBuilder->setParameter('idcgm', (int) $name)
            ->orderBy('cgm.nomCgm', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param SwCgmPessoaFisica $swCgmPessoaFisica
     *
     * @return boolean
     */
    public function canRemove($swCgmPessoaFisica)
    {
        $canRemove = $this->canRemoveWithAssociation($swCgmPessoaFisica);

        if ($canRemove) {
            $canRemove = (new SwCgmModel($this->entityManager))->canRemove($swCgmPessoaFisica->getFkSwCgm());
        }

        return $canRemove;
    }

    /**
     * @param $numCgm
     * @return array
     */
    public function getDadosPessoaFisicaByCgm($numCgm)
    {
        /** @var SwCgmPessoaFisica $cgmPessoaFisica */
        $cgmPessoaFisica = $this->repository->find($numCgm);

        /** @var SwCgm $swCgm */
        $swCgm = $cgmPessoaFisica->getFkSwCgm();

        $dtNascimento = null;
        if (!is_null($cgmPessoaFisica->getDtNascimento())) {
            $dtNascimento = $cgmPessoaFisica->getDtNascimento()->format('d/m/Y');
        }

        $sexo = null;
        if (!is_null($cgmPessoaFisica->getSexo())) {
            $sexo = $cgmPessoaFisica->getSexo() == "m" ? "Masculino" : "Feminino";
        }

        $dadosPessoaFisica = [
            'nome' => $swCgm->getNomCgm(),
            'dtNascimento' => $dtNascimento,
            'sexo' => $sexo,
        ];

        return $dadosPessoaFisica;
    }
}
