<?php
 
namespace Urbem\CoreBundle\Entity\Tceal;

/**
 * BemCompradoTipoDocumentoFiscal
 */
class BemCompradoTipoDocumentoFiscal
{
    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * @var integer
     */
    private $codTipoDocumentoFiscal;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\BemComprado
     */
    private $fkPatrimonioBemComprado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceal\TipoDocumentoFiscal
     */
    private $fkTcealTipoDocumentoFiscal;


    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return BemCompradoTipoDocumentoFiscal
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set codTipoDocumentoFiscal
     *
     * @param integer $codTipoDocumentoFiscal
     * @return BemCompradoTipoDocumentoFiscal
     */
    public function setCodTipoDocumentoFiscal($codTipoDocumentoFiscal)
    {
        $this->codTipoDocumentoFiscal = $codTipoDocumentoFiscal;
        return $this;
    }

    /**
     * Get codTipoDocumentoFiscal
     *
     * @return integer
     */
    public function getCodTipoDocumentoFiscal()
    {
        return $this->codTipoDocumentoFiscal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcealTipoDocumentoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\TipoDocumentoFiscal $fkTcealTipoDocumentoFiscal
     * @return BemCompradoTipoDocumentoFiscal
     */
    public function setFkTcealTipoDocumentoFiscal(\Urbem\CoreBundle\Entity\Tceal\TipoDocumentoFiscal $fkTcealTipoDocumentoFiscal)
    {
        $this->codTipoDocumentoFiscal = $fkTcealTipoDocumentoFiscal->getCodTipoDocumentoFiscal();
        $this->fkTcealTipoDocumentoFiscal = $fkTcealTipoDocumentoFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcealTipoDocumentoFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Tceal\TipoDocumentoFiscal
     */
    public function getFkTcealTipoDocumentoFiscal()
    {
        return $this->fkTcealTipoDocumentoFiscal;
    }

    /**
     * OneToOne (owning side)
     * Set PatrimonioBemComprado
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemComprado $fkPatrimonioBemComprado
     * @return BemCompradoTipoDocumentoFiscal
     */
    public function setFkPatrimonioBemComprado(\Urbem\CoreBundle\Entity\Patrimonio\BemComprado $fkPatrimonioBemComprado)
    {
        $this->codBem = $fkPatrimonioBemComprado->getCodBem();
        $this->fkPatrimonioBemComprado = $fkPatrimonioBemComprado;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPatrimonioBemComprado
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\BemComprado
     */
    public function getFkPatrimonioBemComprado()
    {
        return $this->fkPatrimonioBemComprado;
    }
}
