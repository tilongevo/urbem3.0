<?php

namespace Urbem\CoreBundle\Model\Estagio;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Estagio\EntidadeContribuicao;
use Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora;
use Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino;
use Urbem\CoreBundle\Entity\Estagio\InstituicaoEntidade;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model;

class EntidadeIntermediadoraModel extends AbstractModel implements Model\InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Estagio\\EntidadeIntermediadora");
    }

    /**
     * @param EntidadeIntermediadora $entidadeIntermediadora
     * @return bool
     */
    public function canRemove($entidadeIntermediadora)
    {
        $estagiarioEstagioRepository = $this->entityManager->getRepository("CoreBundle:Estagio\\EntidadeIntermediadoraEstagio");
        $res_ee = $estagiarioEstagioRepository->findOneBy(['cgmEntidade' => $entidadeIntermediadora->getNumcgm()]);

        return is_null($res_ee);
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @param $value
     * @param $rootAlias
     * @return ProxyQuery
     */
    public function searchByCgmEntidadeIntermediadora(ProxyQuery $proxyQuery, $value, $rootAlias)
    {

        $proxyQuery
            ->leftJoin(sprintf("%s.numcgm", $rootAlias), "SwCgmPessoaJuridica")
            ->andWhere("lower(SwCgmPessoaJuridica.nomFantasia) like lower(:nomeFantasia)")
            ->setParameter('nomeFantasia', '%'.$value.'%')
        ;

        return $proxyQuery;
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @param $value
     * @param $rootAlias
     * @return ProxyQuery
     */
    public function searchByCnpjEntidadeIntermediadora(ProxyQuery $proxyQuery, $value, $rootAlias)
    {
        $proxyQuery
            ->leftJoin(sprintf("%s.numcgm", $rootAlias), "swCnpjJuridica")
            ->andWhere("swCnpjJuridica.cnpj like :cnpj")
            ->setParameter('cnpj', '%'.$value.'%')
        ;

        return $proxyQuery;
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @param $value
     * @param $rootAlias
     * @return ProxyQuery
     */
    public function searchByInstituicaoEntidadeIntermediadora(ProxyQuery $proxyQuery, $value, $rootAlias)
    {

        $proxyQuery
            ->leftJoin(sprintf("%s.cgmInstituicao", $rootAlias), "cgmInstituicao")
            ->leftJoin('CoreBundle:Estagio\CursoInstituicaoEnsino', 'c', 'WITH', 'o.cgmInstituicao = c.id')
            ->leftJoin('CoreBundle:SwCgmPessoaJuridica', 's', 'WITH', 'c.numcgm = s.numcgm')
            ->andWhere("lower(s.nomFantasia) like lower(:instituicao)")
            ->setParameter('instituicao', '%'.$value.'%')
        ;

        return $proxyQuery;
    }

    /**
     * @param $pessoaJuridica
     * @param $percentual
     * @return EntidadeIntermediadora
     */
    public function saveEntidadeIntermediadora($pessoaJuridica, $percentual)
    {
        $entidadeIntermediadora = new EntidadeIntermediadora();
        $entidadeIntermediadora
            ->setFkSwCgmPessoaJuridica($pessoaJuridica)
            ->setPercentualAtual($percentual);

        $this->save($entidadeIntermediadora);

        return $entidadeIntermediadora;
    }

    /**
     * @param EntidadeIntermediadora $entidadeIntermediadora
     * @param $percentual
     * @return EntidadeContribuicao
     */
    public function saveEntidadeContribuicao(EntidadeIntermediadora $entidadeIntermediadora, $percentual)
    {
        $entidadeContribuicao = new EntidadeContribuicao();
        $timestamp = new DateTimeMicrosecondPK();

        $entidadeContribuicao
            ->setFkEstagioEntidadeIntermediadora($entidadeIntermediadora)
            ->setPercentual($percentual)
            ->setTimestamp($timestamp);

        $this->save($entidadeContribuicao);

        return $entidadeContribuicao;
    }

    /**
     * @param EntidadeIntermediadora $entidadeIntermediadora
     * @param InstituicaoEnsino $instituicaoEnsino
     * @return InstituicaoEntidade
     */
    public function saveInstituicaoEntidade(EntidadeIntermediadora $entidadeIntermediadora, InstituicaoEnsino $instituicaoEnsino)
    {
        $instituicaoEntidade = new InstituicaoEntidade();
        $instituicaoEntidade
            ->setFkEstagioEntidadeIntermediadora($entidadeIntermediadora)
            ->setFkEstagioInstituicaoEnsino($instituicaoEnsino);

        $this->save($instituicaoEntidade);

        return $instituicaoEntidade;
    }

    /**
     * @param EntidadeIntermediadora $entidadeIntermediadora
     * @param ArrayCollection $instituicoes
     */
    public function updateInstituicaoEntidade(EntidadeIntermediadora $entidadeIntermediadora, ArrayCollection $instituicoes)
    {
        $fkInstituicoesEntidade = $entidadeIntermediadora
                                    ->getFkEstagioInstituicaoEntidades();

        foreach ($fkInstituicoesEntidade as $fkInstituicao) {
            $this->remove($fkInstituicao);
        }

        foreach ($instituicoes as $instituicao) {
            $this->saveInstituicaoEntidade($entidadeIntermediadora, $instituicao);
        }
    }
}
