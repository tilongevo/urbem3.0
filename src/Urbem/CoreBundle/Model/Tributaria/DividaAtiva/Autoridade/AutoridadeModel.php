<?php

namespace Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Autoridade;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Divida\Autoridade;
use Urbem\CoreBundle\Entity\Divida\Procurador;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Normas\TipoNorma;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Helper\UploadHelper;

class AutoridadeModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var AutoridadeRepository|null  */
    protected $repository = null;

    const SITUACAO_ATIVO = 'Ativo';
    const TIPO_AUTORIDADE_PROCURADOR = 'procurador';
    const TIPO_AUTORIDADE_AUTORIDADE = 'autoridade';

    /**
     * AutoridadeModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Autoridade::class);
    }

    /**
     * @param $filter
     * @return array
     */
    public function getMatriculas($filter)
    {
        $matriculas = $this->repository->findMatriculas($filter);
        $retorno = [];
        foreach ($matriculas as $matricula) {
            if ($matricula['situacao'] === self::SITUACAO_ATIVO) {
                array_push($retorno, ['id' => $matricula['registro'], 'label' => sprintf('%s - %s', $matricula['registro'], $matricula['nom_cgm'])]);
            }
        }

        $items = ['items' => $retorno];
        return $items;
    }

    /**
     * @param $registro
     * @return mixed
     */
    public function getFuncaoCargo($registro)
    {
        $funcaoCargo = $this->repository->findFuncaoCargo($registro);
        $strFuncaoCargo = null;
        if (!empty($funcaoCargo)) {
            $strFuncaoCargo = sprintf('%s - %s', $funcaoCargo['descricao'], $funcaoCargo['dt_admissao']);
        }
        return $strFuncaoCargo;
    }

    /**
     * @return ArrayCollection
     */
    public function getAllTipoNormas()
    {
        $normas = $this->entityManager->getRepository(TipoNorma::class)->findBy([], ['nomTipoNorma' => 'ASC']);
        $collection = new ArrayCollection();
        if (!empty($normas)) {
            foreach ($normas as $norma) {
                $collection->set($norma->getNomTipoNorma(), $norma->getCodTipoNorma());
            }
        }

        return $collection;
    }

    /**
     * @param $codTipoNorma
     * @return ArrayCollection
     */
    public function getFundamentacaoLegal($codTipoNorma)
    {
        $fundamentacoesLegal = $this->repository->findFundamentacaoLegal($codTipoNorma);
        $collection = new ArrayCollection();
        if (!empty($fundamentacoesLegal)) {
            foreach ($fundamentacoesLegal as $fundamentacaoLegal) {
                $strFundamentacaoLegal = sprintf('%s %s - %s', $fundamentacaoLegal['nom_tipo_norma'], $fundamentacaoLegal['num_norma_exercicio'], $fundamentacaoLegal['nom_norma']);
                if (!empty($codTipoNorma)) {
                    $collection->set($fundamentacaoLegal['cod_norma'], $strFundamentacaoLegal);
                } else {
                    $collection->set($strFundamentacaoLegal, $fundamentacaoLegal['cod_norma']);
                }
            }
        }
        return $collection;
    }

    /**
     * @param $childrens
     * @param $object
     */
    public function prePersist($childrens, $object)
    {
        $contrato = $this->entityManager->getRepository(Contrato::class)->findOneByRegistro(current(explode(' - ', current($childrens['matriculas']->getViewData()))));
        $norma = $this->entityManager->getRepository(Norma::class)->find($childrens['fundamentacaoLegal']->getViewData());
        $matriculas = $this->repository->findMatriculas(current(explode(' - ', current($childrens['matriculas']->getViewData()))));
        $swCgmPf = $this->entityManager->getRepository(SwCgmPessoaFisica::class)->find(current($matriculas)['numcgm']);
        $object->setFkPessoalContrato($contrato);
        $object->setFkNormasNorma($norma);
        $object->setFkSwCgmPessoaFisica($swCgmPf);
    }

    /**
     * @param $childrens
     * @param $object
     */
    public function postPersist($childrens, $object)
    {
        if (self::TIPO_AUTORIDADE_PROCURADOR === $childrens['tipoAutoridade']->getViewData()) {
            $fkDividaProcurador = new Procurador();
            if (!empty($object->getFkDividaProcurador())) {
                $fkDividaProcurador = $object->getFkDividaProcurador();
            }
            $fkDividaProcurador->setCodUf($childrens['codUf']->getViewData());
            $fkDividaProcurador->setOab($childrens['oab']->getViewData());
            $fkDividaProcurador->setFkDividaAutoridade($object);
            $object->setFkDividaProcurador($fkDividaProcurador);
        } else {
            $this->removeProcurador($object);
        }
    }

    /**
     * @param $object
     */
    public function removeProcurador($object)
    {
        if (!empty($object->getFkDividaProcurador())) {
            $this->remove($object->getFkDividaProcurador());
        }
    }

    /**
     * @param $object
     * @param $container
     */
    public function upload($object, $container)
    {
        if ($object->getTipoAssinatura() !== null) {
            $tipoAssinatura = $container->getParameter("tributariobundle");
            $upload = new UploadHelper();
            $upload->setPath($tipoAssinatura['tipoAssinatura']);
            $upload->setFile($object->getTipoAssinatura());
            $arquivo = $upload->executeUpload();
            $object->setTipoAssinatura($arquivo['name']);
        }
    }

    /**
     * @param $object
     * @param $container
     * @param $childrens
     */
    public function uploadUpdate($object, $container, $childrens)
    {
        if (empty($object->getTipoAssinatura())) {
            $object->setTipoAssinatura($childrens['file']->getViewData());
        } else {
            $this->upload($object, $container);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getSwUf()
    {
        $ufs = $this->entityManager->getRepository(SwUf::class)->findAll();
        $collection = new ArrayCollection();
        if (!empty($ufs)) {
            foreach ($ufs as $uf) {
                $collection->set($uf->getNomUf(), $uf->getCodUf());
            }
        }
        return $collection;
    }

    /**
     * @param $autoridade
     * @return array
     */
    public function init($autoridade, $container)
    {
        $field = new ArrayCollection();
        $field->set('tipoAutoridade', ['data' => self::TIPO_AUTORIDADE_AUTORIDADE]);
        $field->set('matriculas', ['data' => null]);
        $field->set('funcaoCargo', ['data' => null]);
        $field->set('tipo', ['data' => null]);
        $field->set('fundamentacaoLegal', ['data' => null]);
        $field->set('oab', ['data' => null]);
        $field->set('codUf', ['data' => null]);
        $field->set('file', ['data' => null]);
        $field->set('tipoAssinatura', ['help' => null]);

        if (!empty($autoridade->getCodAutoridade())) {
            if (!empty($autoridade->getFkDividaProcurador())) {
                $field->set('tipoAutoridade', ['data' => self::TIPO_AUTORIDADE_PROCURADOR]);
            }

            $matricula = sprintf('%s - %s', $autoridade->getFkPessoalContrato()->getRegistro(), $autoridade->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomCgm());
            $field->set('matriculas', ['data' => $matricula]);
            $field->set('funcaoCargo', ['data' => $this->getFuncaoCargo($autoridade->getFkPessoalContrato()->getRegistro())]);
            $field->set('tipo', ['data' => $autoridade->getFkNormasNorma()->getCodTipoNorma()]);
            $field->set('fundamentacaoLegal', ['data' => $autoridade->getFkNormasNorma()->getCodNorma()]);
            $field->set('file', ['data' => $autoridade->getTipoAssinatura()]);
            if (!empty($autoridade->getFkDividaProcurador())) {
                $field->set('oab', ['data' => $autoridade->getFkDividaProcurador()->getOab()]);
                $field->set('codUf', ['data' => $autoridade->getFkDividaProcurador()->getCodUf()]);
            }

            if (!empty($autoridade->getTipoAssinatura())) {
                $tipoAssinaturaPath = $container->getParameter("tributariobundle");
                $fullPath = $tipoAssinaturaPath['tipoAssinaturaDownload'] . $autoridade->getTipoAssinatura();
                $field->set('tipoAssinatura', ['help' => '<a href="' . $fullPath . '" target="_blank">' . $autoridade->getTipoAssinatura() . '</a>']);
            }
        }

        return $field->toArray();
    }

    /**
     * @param $codFundamentacaoLegal
     * @return ArrayCollection
     */
    public function getFundamentacaoLegalAndTipo($codFundamentacaoLegal)
    {
        $fundamentacaoLegal = $this->entityManager->getRepository(Norma::class)->find($codFundamentacaoLegal);

        $arrayFundamentacaoLegal = new ArrayCollection();
        $arrayFundamentacaoLegal->set('tipo', $fundamentacaoLegal->getFkNormasTipoNorma()->getNomTipoNorma());
        $arrayFundamentacaoLegal->set(
            'fundamentacaoLegal',
            sprintf(
                '%s %s/%s - %s',
                $fundamentacaoLegal->getFkNormasTipoNorma()->getNomTipoNorma(),
                str_pad($fundamentacaoLegal->getNumNorma(), 6, 0, STR_PAD_LEFT),
                $fundamentacaoLegal->getExercicio(),
                $fundamentacaoLegal->getNomNorma()
            )
        );

        return $arrayFundamentacaoLegal;
    }
}
