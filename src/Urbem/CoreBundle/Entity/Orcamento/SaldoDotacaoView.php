<?php

namespace Urbem\CoreBundle\Entity\Orcamento;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orcamento.saldo_dotacao
 *
 * @ORM\Table(name="orcamento.saldo_dotacao")
 * @ORM\Entity
 */
class SaldoDotacaoView
{
    /**
     * @var integer
     *
     * @ORM\Column(name="rnum", type="integer", nullable=false)
     * @ORM\Id
     */
    private $rowNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="cod_entidade", type="integer", nullable=false)
     */
    private $codEntidade;

    /**
     * @var string
     *
     * @ORM\Column(name="exercicio", type="string", length=10 , nullable=true)
     */
    private $exercicio;

    /**
     * @var string
     *
     * @ORM\Column(name="entidade", type="string", length=10 , nullable=true)
     */
    private $entidade;

    /**
     * @var integer
     *
     * @ORM\Column(name="cod_despesa", type="integer", nullable=true)
     */
    private $codDespesa;

    /**
     * @var integer
     *
     * @ORM\Column(name="cod_conta", type="integer", nullable=true)
     */
    private $codConta;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", nullable=true)
     */
    private $descricao;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_orgao", type="integer", nullable=true)
     */
    private $numOrgao;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_orgao", type="string")
     */
    private $nomOrgao;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_unidade", type="integer", nullable=true)
     */
    private $numUnidade;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_unidade", type="string")
     */
    private $nomUnidade;

    /**
     * @var integer
     *
     * @ORM\Column(name="cod_funcao", type="integer", nullable=true)
     */
    private $codFuncao;

    /**
     * @var string
     *
     * @ORM\Column(name="funcao", type="string")
     */
    private $funcao;

    /**
     * @var integer
     *
     * @ORM\Column(name="cod_subfuncao", type="integer", nullable=true)
     */
    private $codSubfuncao;

    /**
     * @var string
     *
     * @ORM\Column(name="subfuncao", type="string")
     */
    private $subfuncao;

    /**
     * @var integer
     *
     * @ORM\Column(name="cod_programa", type="integer", nullable=true)
     */
    private $codPrograma;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_programa", type="integer", nullable=true)
     */
    private $numPrograma;

    /**
     * @var string
     *
     * @ORM\Column(name="programa", type="string")
     */
    private $programa;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_pao", type="integer", nullable=true)
     */
    private $numPao;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_acao", type="integer", nullable=true)
     */
    private $numAcao;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_pao", type="string")
     */
    private $nomPao;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_estrutural", type="string")
     */
    private $codEstrutural;

    /**
     * @var integer
     *
     * @ORM\Column(name="cod_recurso", type="integer", nullable=true)
     */
    private $codRecurso;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_recurso", type="string")
     */
    private $nomRecurso;

    /**
     * @var integer
     *
     * @ORM\Column(name="cod_fonte", type="integer", nullable=true)
     */
    private $codFonte;

    /**
     * @var string
     *
     * @ORM\Column(name="masc_recurso_red", type="string")
     */
    private $mascRecursoRed;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_detalhamento", type="string", nullable=true)
     */
    private $codDetalhamento;

    /**
     * @var decimal
     *
     * @ORM\Column(name="valor_orcado", type="decimal", precision=14, scale=2)
     */
    private $valorOrcado;

    /**
     * @var decimal
     *
     * @ORM\Column(name="valor_suplementado", type="decimal", precision=14, scale=2)
     */
    private $valorSuplementado;

    /**
     * @var decimal
     *
     * @ORM\Column(name="valor_reduzido", type="decimal", precision=14, scale=2)
     */
    private $valorReduzido;

    /**
     * @var decimal
     *
     * @ORM\Column(name="valor_reserva", type="decimal", precision=14, scale=2)
     */
    private $valorReserva;

    /**
     * @var decimal
     *
     * @ORM\Column(name="valor_empenhado", type="decimal", precision=14, scale=2)
     */
    private $valorEmpenhado;

    /**
     * @var decimal
     *
     * @ORM\Column(name="valor_anulado", type="decimal", precision=14, scale=2)
     */
    private $valorAnulado;

    /**
     * @var decimal
     *
     * @ORM\Column(name="valor_liquidado", type="decimal", precision=14, scale=2)
     */
    private $valorLiquidado;

    /**
     * @var decimal
     *
     * @ORM\Column(name="valor_pago", type="decimal", precision=14, scale=2)
     */
    private $valorPago;

    /**
     * @var decimal
     *
     * @ORM\Column(name="saldo_disponivel", type="decimal", precision=14, scale=2)
     */
    private $saldoDisponivel;

    /**
     * @var decimal
     *
     * @ORM\Column(name="saldo", type="decimal", precision=14, scale=2)
     */
    private $saldo;

    /**
     * @return int
     */
    public function getRowNumber()
    {
        return $this->rowNumber;
    }

    /**
     * @param int $rowNumber
     */
    public function setRowNumber($rowNumber)
    {
        $this->rowNumber = $rowNumber;
    }

    /**
     * @return int
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * @param int $codEntidade
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
    }

    /**
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * @param string $exercicio
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
    }

    /**
     * @return string
     */
    public function getEntidade()
    {
        return $this->entidade;
    }

    /**
     * @param string $entidade
     */
    public function setEntidade($entidade)
    {
        $this->entidade = $entidade;
    }

    /**
     * @return int
     */
    public function getCodDespesa()
    {
        return $this->codDespesa;
    }

    /**
     * @param int $codDespesa
     */
    public function setCodDespesa($codDespesa)
    {
        $this->codDespesa = $codDespesa;
    }

    /**
     * @return int
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * @param int $codConta
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return int
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * @param int $numOrgao
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
    }

    /**
     * @return string
     */
    public function getNomOrgao()
    {
        return $this->nomOrgao;
    }

    /**
     * @param string $nomOrgao
     */
    public function setNomOrgao($nomOrgao)
    {
        $this->nomOrgao = $nomOrgao;
    }

    /**
     * @return int
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * @param int $numUnidade
     */
    public function setNumUnidade($numUnidade)
    {
        $this->numUnidade = $numUnidade;
    }

    /**
     * @return string
     */
    public function getNomUnidade()
    {
        return $this->nomUnidade;
    }

    /**
     * @param string $nomUnidade
     */
    public function setNomUnidade($nomUnidade)
    {
        $this->nomUnidade = $nomUnidade;
    }

    /**
     * @return int
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * @param int $codFuncao
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
    }

    /**
     * @return string
     */
    public function getFuncao()
    {
        return $this->funcao;
    }

    /**
     * @param string $funcao
     */
    public function setFuncao($funcao)
    {
        $this->funcao = $funcao;
    }

    /**
     * @return int
     */
    public function getCodSubfuncao()
    {
        return $this->codSubfuncao;
    }

    /**
     * @param int $codSubfuncao
     */
    public function setCodSubfuncao($codSubfuncao)
    {
        $this->codSubfuncao = $codSubfuncao;
    }

    /**
     * @return string
     */
    public function getSubfuncao()
    {
        return $this->subfuncao;
    }

    /**
     * @param string $subfuncao
     */
    public function setSubfuncao($subfuncao)
    {
        $this->subfuncao = $subfuncao;
    }

    /**
     * @return int
     */
    public function getCodPrograma()
    {
        return $this->codPrograma;
    }

    /**
     * @param int $codPrograma
     */
    public function setCodPrograma($codPrograma)
    {
        $this->codPrograma = $codPrograma;
    }

    /**
     * @return int
     */
    public function getNumPrograma()
    {
        return $this->numPrograma;
    }

    /**
     * @param int $numPrograma
     */
    public function setNumPrograma($numPrograma)
    {
        $this->numPrograma = $numPrograma;
    }

    /**
     * @return string
     */
    public function getPrograma()
    {
        return $this->programa;
    }

    /**
     * @param string $programa
     */
    public function setPrograma($programa)
    {
        $this->programa = $programa;
    }

    /**
     * @return int
     */
    public function getNumPao()
    {
        return $this->numPao;
    }

    /**
     * @param int $numPao
     */
    public function setNumPao($numPao)
    {
        $this->numPao = $numPao;
    }

    /**
     * @return int
     */
    public function getNumAcao()
    {
        return $this->numAcao;
    }

    /**
     * @param int $numAcao
     */
    public function setNumAcao($numAcao)
    {
        $this->numAcao = $numAcao;
    }

    /**
     * @return string
     */
    public function getNomPao()
    {
        return $this->nomPao;
    }

    /**
     * @param string $nomPao
     */
    public function setNomPao($nomPao)
    {
        $this->nomPao = $nomPao;
    }

    /**
     * @return string
     */
    public function getCodEstrutural()
    {
        return $this->codEstrutural;
    }

    /**
     * @param string $codEstrutural
     */
    public function setCodEstrutural($codEstrutural)
    {
        $this->codEstrutural = $codEstrutural;
    }

    /**
     * @return int
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * @param int $codRecurso
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
    }

    /**
     * @return string
     */
    public function getNomRecurso()
    {
        return $this->nomRecurso;
    }

    /**
     * @param string $nomRecurso
     */
    public function setNomRecurso($nomRecurso)
    {
        $this->nomRecurso = $nomRecurso;
    }

    /**
     * @return int
     */
    public function getCodFonte()
    {
        return $this->codFonte;
    }

    /**
     * @param int $codFonte
     */
    public function setCodFonte($codFonte)
    {
        $this->codFonte = $codFonte;
    }

    /**
     * @return string
     */
    public function getMascRecursoRed()
    {
        return $this->mascRecursoRed;
    }

    /**
     * @param string $mascRecursoRed
     */
    public function setMascRecursoRed($mascRecursoRed)
    {
        $this->mascRecursoRed = $mascRecursoRed;
    }

    /**
     * @return string
     */
    public function getCodDetalhamento()
    {
        return $this->codDetalhamento;
    }

    /**
     * @param string $codDetalhamento
     */
    public function setCodDetalhamento($codDetalhamento)
    {
        $this->codDetalhamento = $codDetalhamento;
    }

    /**
     * @return decimal
     */
    public function getValorOrcado()
    {
        return $this->formatMoney($this->valorOrcado);
    }

    /**
     * @param decimal $valorOrcado
     */
    public function setValorOrcado($valorOrcado)
    {
        $this->valorOrcado = $valorOrcado;
    }

    /**
     * @return decimal
     */
    public function getValorSuplementado()
    {
        return $this->formatMoney($this->valorSuplementado);
    }

    /**
     * @param decimal $valorSuplementado
     */
    public function setValorSuplementado($valorSuplementado)
    {
        $this->valorSuplementado = $valorSuplementado;
    }

    /**
     * @return decimal
     */
    public function getValorReduzido()
    {
        return $this->formatMoney($this->valorReduzido);
    }

    /**
     * @param decimal $valorReduzido
     */
    public function setValorReduzido($valorReduzido)
    {
        $this->valorReduzido = $valorReduzido;
    }

    /**
     * @return decimal
     */
    public function getValorReserva()
    {
        return $this->formatMoney($this->valorReserva);
    }

    /**
     * @param decimal $valorReserva
     */
    public function setValorReserva($valorReserva)
    {
        $this->valorReserva = $valorReserva;
    }

    /**
     * @return decimal
     */
    public function getValorEmpenhado()
    {
        return $this->formatMoney($this->valorEmpenhado);
    }

    /**
     * @param decimal $valorEmpenhado
     */
    public function setValorEmpenhado($valorEmpenhado)
    {
        $this->valorEmpenhado = $valorEmpenhado;
    }

    /**
     * @return decimal
     */
    public function getValorAnulado()
    {
        return $this->formatMoney($this->valorAnulado);
    }

    /**
     * @param decimal $valorAnulado
     */
    public function setValorAnulado($valorAnulado)
    {
        $this->valorAnulado = $valorAnulado;
    }

    /**
     * @return decimal
     */
    public function getValorLiquidado()
    {
        return $this->formatMoney($this->valorLiquidado);
    }

    /**
     * @param decimal $valorLiquidado
     */
    public function setValorLiquidado($valorLiquidado)
    {
        $this->valorLiquidado = $valorLiquidado;
    }

    /**
     * @return decimal
     */
    public function getValorPago()
    {
        return $this->formatMoney($this->valorPago);
    }

    /**
     * @param decimal $valorPago
     */
    public function setValorPago($valorPago)
    {
        $this->valorPago = $valorPago;
    }

    /**
     * @return decimal
     */
    public function getSaldoDisponivel()
    {
        return $this->formatMoney($this->saldoDisponivel);
    }

    /**
     * @param decimal $saldoDisponivel
     */
    public function setSaldoDisponivel($saldoDisponivel)
    {
        $this->saldoDisponivel = $saldoDisponivel;
    }

    /**
     * @return decimal
     */
    public function getSaldo()
    {
        return $this->formatMoney($this->saldo);
    }

    /**
     * @param decimal $saldo
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;
    }

    /**
     * @return string
     */
    public function getNumOrgaoNumEntidade()
    {
        return sprintf("%s/%s", $this->getNumOrgao(), $this->getNumUnidade());
    }

    /**
     * @param $value
     * @return string
     */
    private function formatMoney($value)
    {
        return number_format($value, 2, ',', '.');
    }

    /**
     * @return string
     */
    public function getEntidadeComposto()
    {
        return sprintf("%s - %s", $this->codEntidade, $this->entidade);
    }

    /**
     * @return string
     */
    public function getDotacaoComposto()
    {
        return sprintf("%s - %s", $this->codConta, $this->descricao);
    }

    /**
     * @return string
     */
    public function getOrgaoComposto()
    {
        return sprintf("%s - %s", $this->numOrgao, $this->nomOrgao);
    }

    /**
     * @return string
     */
    public function getUnidadeComposto()
    {
        return sprintf("%s - %s", $this->numUnidade, $this->nomUnidade);
    }

    /**
     * @return string
     */
    public function getFuncaoComposto()
    {
        return sprintf("%s - %s", $this->codFuncao, $this->funcao);
    }

    /**
     * @return string
     */
    public function getSubfuncaoComposto()
    {
        return sprintf("%s - %s", $this->codSubfuncao, $this->subfuncao);
    }

    /**
     * @return string
     */
    public function getProgramaComposto()
    {
        return sprintf("%s - %s", $this->codPrograma, $this->programa);
    }

    /**
     * @return string
     */
    public function getPaoComposto()
    {
        return sprintf("%s - %s", $this->numPao, $this->nomPao);
    }

    /**
     * @return string
     */
    public function getRecursoComposto()
    {
        return sprintf("%s - %s", $this->codRecurso, $this->nomRecurso);
    }
}
