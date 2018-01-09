<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * ArquivoColetoraConsistencia
 */
class ArquivoColetoraConsistencia
{
    /**
     * PK
     * @var integer
     */
    private $codigo;

    /**
     * PK
     * @var string
     */
    private $numPlaca;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $orientacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados
     */
    private $fkPatrimonioArquivoColetoraDados;


    /**
     * Set codigo
     *
     * @param integer $codigo
     * @return ArquivoColetoraConsistencia
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set numPlaca
     *
     * @param string $numPlaca
     * @return ArquivoColetoraConsistencia
     */
    public function setNumPlaca($numPlaca)
    {
        $this->numPlaca = $numPlaca;
        return $this;
    }

    /**
     * Get numPlaca
     *
     * @return string
     */
    public function getNumPlaca()
    {
        return $this->numPlaca;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return ArquivoColetoraConsistencia
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set orientacao
     *
     * @param string $orientacao
     * @return ArquivoColetoraConsistencia
     */
    public function setOrientacao($orientacao = null)
    {
        $this->orientacao = $orientacao;
        return $this;
    }

    /**
     * Get orientacao
     *
     * @return string
     */
    public function getOrientacao()
    {
        return $this->orientacao;
    }

    /**
     * OneToOne (owning side)
     * Set PatrimonioArquivoColetoraDados
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados $fkPatrimonioArquivoColetoraDados
     * @return ArquivoColetoraConsistencia
     */
    public function setFkPatrimonioArquivoColetoraDados(\Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados $fkPatrimonioArquivoColetoraDados)
    {
        $this->codigo = $fkPatrimonioArquivoColetoraDados->getCodigo();
        $this->numPlaca = $fkPatrimonioArquivoColetoraDados->getNumPlaca();
        $this->fkPatrimonioArquivoColetoraDados = $fkPatrimonioArquivoColetoraDados;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPatrimonioArquivoColetoraDados
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados
     */
    public function getFkPatrimonioArquivoColetoraDados()
    {
        return $this->fkPatrimonioArquivoColetoraDados;
    }
}
