<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConsignacaoEmprestimoBanrisulErro
 */
class ConsignacaoEmprestimoBanrisulErro
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
     * @var string
     */
    private $codMotivoRejeicao;

    /**
     * @var string
     */
    private $descricaoMotivo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisul
     */
    private $fkImaConsignacaoEmprestimoBanrisul;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\MotivosRejeicaoConsignacaoEmprestimoBanrisul
     */
    private $fkImaMotivosRejeicaoConsignacaoEmprestimoBanrisul;


    /**
     * Set numLinha
     *
     * @param integer $numLinha
     * @return ConsignacaoEmprestimoBanrisulErro
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
     * @return ConsignacaoEmprestimoBanrisulErro
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
     * Set codMotivoRejeicao
     *
     * @param string $codMotivoRejeicao
     * @return ConsignacaoEmprestimoBanrisulErro
     */
    public function setCodMotivoRejeicao($codMotivoRejeicao)
    {
        $this->codMotivoRejeicao = $codMotivoRejeicao;
        return $this;
    }

    /**
     * Get codMotivoRejeicao
     *
     * @return string
     */
    public function getCodMotivoRejeicao()
    {
        return $this->codMotivoRejeicao;
    }

    /**
     * Set descricaoMotivo
     *
     * @param string $descricaoMotivo
     * @return ConsignacaoEmprestimoBanrisulErro
     */
    public function setDescricaoMotivo($descricaoMotivo)
    {
        $this->descricaoMotivo = $descricaoMotivo;
        return $this;
    }

    /**
     * Get descricaoMotivo
     *
     * @return string
     */
    public function getDescricaoMotivo()
    {
        return $this->descricaoMotivo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaMotivosRejeicaoConsignacaoEmprestimoBanrisul
     *
     * @param \Urbem\CoreBundle\Entity\Ima\MotivosRejeicaoConsignacaoEmprestimoBanrisul $fkImaMotivosRejeicaoConsignacaoEmprestimoBanrisul
     * @return ConsignacaoEmprestimoBanrisulErro
     */
    public function setFkImaMotivosRejeicaoConsignacaoEmprestimoBanrisul(\Urbem\CoreBundle\Entity\Ima\MotivosRejeicaoConsignacaoEmprestimoBanrisul $fkImaMotivosRejeicaoConsignacaoEmprestimoBanrisul)
    {
        $this->codMotivoRejeicao = $fkImaMotivosRejeicaoConsignacaoEmprestimoBanrisul->getCodMotivoRejeicao();
        $this->fkImaMotivosRejeicaoConsignacaoEmprestimoBanrisul = $fkImaMotivosRejeicaoConsignacaoEmprestimoBanrisul;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaMotivosRejeicaoConsignacaoEmprestimoBanrisul
     *
     * @return \Urbem\CoreBundle\Entity\Ima\MotivosRejeicaoConsignacaoEmprestimoBanrisul
     */
    public function getFkImaMotivosRejeicaoConsignacaoEmprestimoBanrisul()
    {
        return $this->fkImaMotivosRejeicaoConsignacaoEmprestimoBanrisul;
    }

    /**
     * OneToOne (owning side)
     * Set ImaConsignacaoEmprestimoBanrisul
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisul $fkImaConsignacaoEmprestimoBanrisul
     * @return ConsignacaoEmprestimoBanrisulErro
     */
    public function setFkImaConsignacaoEmprestimoBanrisul(\Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisul $fkImaConsignacaoEmprestimoBanrisul)
    {
        $this->numLinha = $fkImaConsignacaoEmprestimoBanrisul->getNumLinha();
        $this->codPeriodoMovimentacao = $fkImaConsignacaoEmprestimoBanrisul->getCodPeriodoMovimentacao();
        $this->fkImaConsignacaoEmprestimoBanrisul = $fkImaConsignacaoEmprestimoBanrisul;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImaConsignacaoEmprestimoBanrisul
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisul
     */
    public function getFkImaConsignacaoEmprestimoBanrisul()
    {
        return $this->fkImaConsignacaoEmprestimoBanrisul;
    }
}
