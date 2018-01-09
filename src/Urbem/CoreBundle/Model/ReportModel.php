<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Acao;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Helper\DocumentNumberConverterHelper;

/**
 * Class ReportModel
 * @package Urbem\CoreBundle\Model
 */
class ReportModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * ReportModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Recupera as informaçoes para o cabecalho do relatorio
     * @param string $exercicio
     * @param integer $codAcao
     * @return array
     */
    public function recuperaCabecalho($exercicio, $codAcao)
    {
        $arPropriedades = [
            'nom_prefeitura' => '',
            'cnpj' => '',
            'fone' => '',
            'fax' => '',
            'e_mail' => '',
            'logradouro' => '',
            'numero' => '',
            'nom_municipio' => '',
            'cep' => '',
            'logotipo' => '',
            'cod_entidade_prefeitura' => ''
        ];

        foreach ($arPropriedades as $propriedade => $valor) {
            $configuracao = $this->entityManager->getRepository(Configuracao::class)
            ->findOneBy([
                'exercicio' => $exercicio,
                'parametro' => $propriedade
            ]);

            switch ($propriedade) {
                case 'cnpj':
                    $arPropriedades[$propriedade] = DocumentNumberConverterHelper::parseNumberToCnpj($configuracao->getValor());
                    break;
                case 'cep':
                    $arPropriedades[$propriedade] = DocumentNumberConverterHelper::parseNumberToCep($configuracao->getValor());
                    break;
                default:
                    $arPropriedades[$propriedade] = $configuracao->getValor();
            }
        }

        $entidade = $this->entityManager->getRepository(Entidade::class)
        ->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $arPropriedades['cod_entidade_prefeitura']
        ]);

        $fkSwCgm = $entidade->getFkSwCgm();
        if ($entidade->getFkSwCgm()) {
            $arPropriedades['nom_prefeitura'] = $fkSwCgm->getNomcgm();
            $arPropriedades['fone'] = $fkSwCgm->getFoneResidencial();
            $arPropriedades['fax'] = $fkSwCgm->getFoneComercial();
            $arPropriedades['e_mail'] = $fkSwCgm->getEmail();
            $arPropriedades['logradouro'] = $fkSwCgm->getTipoLogradouro() . " " . $fkSwCgm->getLogradouro();
            $arPropriedades['numero'] = $fkSwCgm->getNumero() .  " " . $fkSwCgm->getComplemento();
            $arPropriedades['bairro'] = $fkSwCgm->getBairro();
            $arPropriedades['cep'] =  DocumentNumberConverterHelper::parseNumberToCep($fkSwCgm->getCep());
            if ($fkSwCgm->getFkSwCgmPessoaJuridica()) {
                $arPropriedades['cnpj'] =  DocumentNumberConverterHelper::parseNumberToCnpj($fkSwCgm->getFkSwCgmPessoaJuridica()->getCnpj());
            }
            $arPropriedades['nom_municipio'] = $fkSwCgm->getFkSwMunicipio()->getNomMunicipio();
            $arPropriedades['sigla_uf'] = $fkSwCgm->getFkSwMunicipio()->getFkSwUf()->getSiglaUf();
        }

        $acao = $this->entityManager->getRepository(Acao::class)
        ->findOneBy([
            'codAcao' => $codAcao
        ]);

        $arPropriedades['nom_modulo'] = $acao->getFkAdministracaoFuncionalidade()->getFkAdministracaoModulo()->getNomModulo();
        $arPropriedades['nom_funcionalidade'] = $acao->getFkAdministracaoFuncionalidade()->getNomFuncionalidade();
        $arPropriedades['nom_acao'] = $acao->getNomAcao();

        return $arPropriedades;
    }
}
