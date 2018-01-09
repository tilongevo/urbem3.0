<?php

namespace Urbem\CoreBundle\Model\Beneficio;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Repository\Beneficio\BeneficiarioRepository;

class BeneficiarioModel extends AbstractModel
{
    protected $entityManager = null;
    /**
     * @var BeneficiarioRepository|null
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Beneficio\\Beneficiario");
    }

    public function findAllByCodPeriodoMovimentacao($codPeriodoMovimentacao)
    {
        $return = $this->repository->findByCodPeriodoMovimentacao($codPeriodoMovimentacao);

        return $return;
    }

    public function deleteByBeneficiario(Entity\Beneficio\Beneficiario $beneficario)
    {
        $em = $this->entityManager;
        $em->remove($beneficario);
        $em->flush();
    }

    public function getCgm()
    {
        $sql = "
        SELECT
            pessoal.servidor.cod_servidor,
            public.sw_cgm.nom_cgm
        FROM public.sw_cgm
        LEFT JOIN public.sw_cgm_pessoa_fisica
            ON public.sw_cgm_pessoa_fisica.numcgm = public.sw_cgm.numcgm
        LEFT JOIN public.sw_cgm_pessoa_juridica
            ON public.sw_cgm_pessoa_juridica.numcgm = public.sw_cgm.numcgm
        LEFT JOIN pessoal.servidor
            ON pessoal.servidor.numcgm = public.sw_cgm.numcgm
        WHERE public.sw_cgm.numcgm <> 0
        AND public.sw_cgm.numcgm IN (SELECT
            public.sw_cgm_pessoa_fisica.numcgm
        FROM public.sw_cgm_pessoa_fisica)
        AND public.sw_cgm.numcgm IN (SELECT
            pessoal.servidor.numcgm
        FROM pessoal.servidor
        INNER JOIN pessoal.servidor_contrato_servidor
            ON pessoal.servidor_contrato_servidor.cod_servidor = pessoal.servidor.cod_servidor)
        ORDER BY public.sw_cgm.nom_cgm ASC;";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        $cgms = array();
        foreach ($result as $cgm) {
            $cgms[$cgm->nom_cgm] = $cgm->cod_servidor;
        }

        return $cgms;
    }

    /**
     * @param $paramsWhere
     *
     * @return mixed
     */
    public function recuperaBeneficiariosLayoutFornecedor($paramsWhere)
    {
        return $this->repository->recuperaBeneficiariosLayoutFornecedor($paramsWhere);
    }

    /**
     * @param $coluna
     *
     * @return bool
     */
    public function validaArquivoUnimed($coluna)
    {
        //Padrao para as colunas
        $arPadrao[0] = 'ano';
        $arPadrao[1] = 'mes';
        $arPadrao[2] = 'modalidade';
        $arPadrao[3] = 'termo';
        $arPadrao[4] = 'codusu';
        $arPadrao[5] = 'nomusu';
        $arPadrao[6] = 'valor';

        //Remove espacos em branco nas descricoes da colunas
        $coluna[0] = trim($coluna[0]);
        $coluna[1] = trim($coluna[1]);
        $coluna[2] = trim($coluna[2]);
        $coluna[3] = trim($coluna[3]);
        $coluna[4] = trim($coluna[4]);
        $coluna[5] = trim($coluna[5]);
        $coluna[6] = trim($coluna[6]);

        //Compara as colunas com o padrao do arquivo
        $arComparacao = array_diff($coluna, $arPadrao);

        //Se o array de comparação estiver vazio signfica que os arrays são iguais e o arquivo é válido
        if (empty($arComparacao)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $stCondicao
     *
     * @return array
     */
    public function verificaPeriodoMovimentacao($stCondicao)
    {
        return $this->repository->verificaPeriodoMovimentacao($stCondicao);
    }

    /**
     * @param Entity\Beneficio\Beneficiario $beneficiarioOld
     * @param                               $valor
     *
     * @return Entity\Beneficio\Beneficiario
     */
    public function buildOneBeneficiarioBasedBaneficiario(Entity\Beneficio\Beneficiario $beneficiarioOld, $valor)
    {
        $beneficiario = new Entity\Beneficio\Beneficiario();
        $beneficiario->setFkBeneficioModalidadeConvenioMedico($beneficiarioOld->getFkBeneficioModalidadeConvenioMedico());
        $beneficiario->setFkBeneficioTipoConvenioMedico($beneficiarioOld->getFkBeneficioTipoConvenioMedico());
        $beneficiario->setFkComprasFornecedor($beneficiarioOld->getFkComprasFornecedor());
        $beneficiario->setFkCseGrauParentesco($beneficiarioOld->getFkCseGrauParentesco());
        $beneficiario->setFkFolhapagamentoPeriodoMovimentacao($beneficiarioOld->getFkFolhapagamentoPeriodoMovimentacao());
        $beneficiario->setFkPessoalContrato($beneficiarioOld->getFkPessoalContrato());
        $beneficiario->setFkSwCgm($beneficiarioOld->getFkSwCgm());
        $beneficiario->setValor(trim($valor));
        $beneficiario->setCodigoUsuario($beneficiarioOld->getCodigoUsuario());
        $beneficiario->setDtInicio($beneficiarioOld->getDtInicio());

        return $beneficiario;
    }
}
