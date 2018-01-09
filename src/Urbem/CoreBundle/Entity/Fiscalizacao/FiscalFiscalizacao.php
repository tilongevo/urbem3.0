<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * FiscalFiscalizacao
 */
class FiscalFiscalizacao
{
    /**
     * PK
     * @var integer
     */
    private $codFiscal;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal
     */
    private $fkFiscalizacaoFiscal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao
     */
    private $fkFiscalizacaoTipoFiscalizacao;


    /**
     * Set codFiscal
     *
     * @param integer $codFiscal
     * @return FiscalFiscalizacao
     */
    public function setCodFiscal($codFiscal)
    {
        $this->codFiscal = $codFiscal;
        return $this;
    }

    /**
     * Get codFiscal
     *
     * @return integer
     */
    public function getCodFiscal()
    {
        return $this->codFiscal;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return FiscalFiscalizacao
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal $fkFiscalizacaoFiscal
     * @return FiscalFiscalizacao
     */
    public function setFkFiscalizacaoFiscal(\Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal $fkFiscalizacaoFiscal)
    {
        $this->codFiscal = $fkFiscalizacaoFiscal->getCodFiscal();
        $this->fkFiscalizacaoFiscal = $fkFiscalizacaoFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal
     */
    public function getFkFiscalizacaoFiscal()
    {
        return $this->fkFiscalizacaoFiscal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoTipoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao $fkFiscalizacaoTipoFiscalizacao
     * @return FiscalFiscalizacao
     */
    public function setFkFiscalizacaoTipoFiscalizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao $fkFiscalizacaoTipoFiscalizacao)
    {
        $this->codTipo = $fkFiscalizacaoTipoFiscalizacao->getCodTipo();
        $this->fkFiscalizacaoTipoFiscalizacao = $fkFiscalizacaoTipoFiscalizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoTipoFiscalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao
     */
    public function getFkFiscalizacaoTipoFiscalizacao()
    {
        return $this->fkFiscalizacaoTipoFiscalizacao;
    }
}
