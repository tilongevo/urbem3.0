<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConsignacaoEmprestimoBanrisul
 */
class ConsignacaoEmprestimoBanrisul
{
    /**
     * PK
     * @var integer
     */
    private $numLinha;

    /**
     * PK
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * @var integer
     */
    private $oa;

    /**
     * @var integer
     */
    private $matricula;

    /**
     * @var string
     */
    private $cpf;

    /**
     * @var string
     */
    private $nomFuncionario;

    /**
     * @var integer
     */
    private $codCanal;

    /**
     * @var string
     */
    private $nroContrato;

    /**
     * @var string
     */
    private $prestacao;

    /**
     * @var integer
     */
    private $valConsignar;

    /**
     * @var integer
     */
    private $valConsignado;

    /**
     * @var string
     */
    private $filler;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * @var string
     */
    private $origemPagamento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulErro
     */
    private $fkImaConsignacaoEmprestimoBanrisulErro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulConfiguracao
     */
    private $fkImaConsignacaoEmprestimoBanrisulConfiguracao;


    /**
     * Set numLinha
     *
     * @param integer $numLinha
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setNumLinha($numLinha)
    {
        $this->numLinha = $numLinha;
        return $this;
    }

    /**
     * Get numLinha
     *
     * @return integer
     */
    public function getNumLinha()
    {
        return $this->numLinha;
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setCodPeriodoMovimentacao($codPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $codPeriodoMovimentacao;
        return $this;
    }

    /**
     * Get codPeriodoMovimentacao
     *
     * @return integer
     */
    public function getCodPeriodoMovimentacao()
    {
        return $this->codPeriodoMovimentacao;
    }

    /**
     * Set oa
     *
     * @param integer $oa
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setOa($oa = null)
    {
        $this->oa = $oa;
        return $this;
    }

    /**
     * Get oa
     *
     * @return integer
     */
    public function getOa()
    {
        return $this->oa;
    }

    /**
     * Set matricula
     *
     * @param integer $matricula
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setMatricula($matricula = null)
    {
        $this->matricula = $matricula;
        return $this;
    }

    /**
     * Get matricula
     *
     * @return integer
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set cpf
     *
     * @param string $cpf
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setCpf($cpf = null)
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * Get cpf
     *
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set nomFuncionario
     *
     * @param string $nomFuncionario
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setNomFuncionario($nomFuncionario = null)
    {
        $this->nomFuncionario = $nomFuncionario;
        return $this;
    }

    /**
     * Get nomFuncionario
     *
     * @return string
     */
    public function getNomFuncionario()
    {
        return $this->nomFuncionario;
    }

    /**
     * Set codCanal
     *
     * @param integer $codCanal
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setCodCanal($codCanal = null)
    {
        $this->codCanal = $codCanal;
        return $this;
    }

    /**
     * Get codCanal
     *
     * @return integer
     */
    public function getCodCanal()
    {
        return $this->codCanal;
    }

    /**
     * Set nroContrato
     *
     * @param string $nroContrato
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setNroContrato($nroContrato = null)
    {
        $this->nroContrato = $nroContrato;
        return $this;
    }

    /**
     * Get nroContrato
     *
     * @return string
     */
    public function getNroContrato()
    {
        return $this->nroContrato;
    }

    /**
     * Set prestacao
     *
     * @param string $prestacao
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setPrestacao($prestacao = null)
    {
        $this->prestacao = $prestacao;
        return $this;
    }

    /**
     * Get prestacao
     *
     * @return string
     */
    public function getPrestacao()
    {
        return $this->prestacao;
    }

    /**
     * Set valConsignar
     *
     * @param integer $valConsignar
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setValConsignar($valConsignar = null)
    {
        $this->valConsignar = $valConsignar;
        return $this;
    }

    /**
     * Get valConsignar
     *
     * @return integer
     */
    public function getValConsignar()
    {
        return $this->valConsignar;
    }

    /**
     * Set valConsignado
     *
     * @param integer $valConsignado
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setValConsignado($valConsignado = null)
    {
        $this->valConsignado = $valConsignado;
        return $this;
    }

    /**
     * Get valConsignado
     *
     * @return integer
     */
    public function getValConsignado()
    {
        return $this->valConsignado;
    }

    /**
     * Set filler
     *
     * @param string $filler
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setFiller($filler = null)
    {
        $this->filler = $filler;
        return $this;
    }

    /**
     * Get filler
     *
     * @return string
     */
    public function getFiller()
    {
        return $this->filler;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setCodContrato($codContrato = null)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set origemPagamento
     *
     * @param string $origemPagamento
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setOrigemPagamento($origemPagamento = null)
    {
        $this->origemPagamento = $origemPagamento;
        return $this;
    }

    /**
     * Get origemPagamento
     *
     * @return string
     */
    public function getOrigemPagamento()
    {
        return $this->origemPagamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaConsignacaoEmprestimoBanrisulConfiguracao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulConfiguracao $fkImaConsignacaoEmprestimoBanrisulConfiguracao
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setFkImaConsignacaoEmprestimoBanrisulConfiguracao(\Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulConfiguracao $fkImaConsignacaoEmprestimoBanrisulConfiguracao)
    {
        $this->codPeriodoMovimentacao = $fkImaConsignacaoEmprestimoBanrisulConfiguracao->getCodPeriodoMovimentacao();
        $this->fkImaConsignacaoEmprestimoBanrisulConfiguracao = $fkImaConsignacaoEmprestimoBanrisulConfiguracao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaConsignacaoEmprestimoBanrisulConfiguracao
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulConfiguracao
     */
    public function getFkImaConsignacaoEmprestimoBanrisulConfiguracao()
    {
        return $this->fkImaConsignacaoEmprestimoBanrisulConfiguracao;
    }

    /**
     * OneToOne (inverse side)
     * Set ImaConsignacaoEmprestimoBanrisulErro
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulErro $fkImaConsignacaoEmprestimoBanrisulErro
     * @return ConsignacaoEmprestimoBanrisul
     */
    public function setFkImaConsignacaoEmprestimoBanrisulErro(\Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulErro $fkImaConsignacaoEmprestimoBanrisulErro)
    {
        $fkImaConsignacaoEmprestimoBanrisulErro->setFkImaConsignacaoEmprestimoBanrisul($this);
        $this->fkImaConsignacaoEmprestimoBanrisulErro = $fkImaConsignacaoEmprestimoBanrisulErro;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImaConsignacaoEmprestimoBanrisulErro
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulErro
     */
    public function getFkImaConsignacaoEmprestimoBanrisulErro()
    {
        return $this->fkImaConsignacaoEmprestimoBanrisulErro;
    }
}
