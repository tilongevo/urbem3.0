<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * ArquivoColetoraDados
 */
class ArquivoColetoraDados
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
     * @var integer
     */
    private $codLocal;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraConsistencia
     */
    private $fkPatrimonioArquivoColetoraConsistencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetora
     */
    private $fkPatrimonioArquivoColetora;


    /**
     * Set codigo
     *
     * @param integer $codigo
     * @return ArquivoColetoraDados
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
     * @return ArquivoColetoraDados
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
     * Set codLocal
     *
     * @param integer $codLocal
     * @return ArquivoColetoraDados
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return ArquivoColetoraDados
     */
    public function setFkOrganogramaLocal(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        $this->codLocal = $fkOrganogramaLocal->getCodLocal();
        $this->fkOrganogramaLocal = $fkOrganogramaLocal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaLocal
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Local
     */
    public function getFkOrganogramaLocal()
    {
        return $this->fkOrganogramaLocal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioArquivoColetora
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetora $fkPatrimonioArquivoColetora
     * @return ArquivoColetoraDados
     */
    public function setFkPatrimonioArquivoColetora(\Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetora $fkPatrimonioArquivoColetora)
    {
        $this->codigo = $fkPatrimonioArquivoColetora->getCodigo();
        $this->fkPatrimonioArquivoColetora = $fkPatrimonioArquivoColetora;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioArquivoColetora
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetora
     */
    public function getFkPatrimonioArquivoColetora()
    {
        return $this->fkPatrimonioArquivoColetora;
    }

    /**
     * OneToOne (inverse side)
     * Set PatrimonioArquivoColetoraConsistencia
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraConsistencia $fkPatrimonioArquivoColetoraConsistencia
     * @return ArquivoColetoraDados
     */
    public function setFkPatrimonioArquivoColetoraConsistencia(\Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraConsistencia $fkPatrimonioArquivoColetoraConsistencia)
    {
        $fkPatrimonioArquivoColetoraConsistencia->setFkPatrimonioArquivoColetoraDados($this);
        $this->fkPatrimonioArquivoColetoraConsistencia = $fkPatrimonioArquivoColetoraConsistencia;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPatrimonioArquivoColetoraConsistencia
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraConsistencia
     */
    public function getFkPatrimonioArquivoColetoraConsistencia()
    {
        return $this->fkPatrimonioArquivoColetoraConsistencia;
    }
}
