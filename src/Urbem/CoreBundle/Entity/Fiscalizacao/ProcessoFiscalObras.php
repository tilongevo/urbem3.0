<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * ProcessoFiscalObras
 */
class ProcessoFiscalObras
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * @var integer
     */
    private $codLocal;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    private $fkFiscalizacaoProcessoFiscal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\TipoLocal
     */
    private $fkFiscalizacaoTipoLocal;


    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProcessoFiscalObras
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return ProcessoFiscalObras
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set codLocal
     *
     * @param integer $codLocal
     * @return ProcessoFiscalObras
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
     * Set fkImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return ProcessoFiscalObras
     */
    public function setFkImobiliarioImovel(\Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel)
    {
        $this->inscricaoMunicipal = $fkImobiliarioImovel->getInscricaoMunicipal();
        $this->fkImobiliarioImovel = $fkImobiliarioImovel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    public function getFkImobiliarioImovel()
    {
        return $this->fkImobiliarioImovel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoTipoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\TipoLocal $fkFiscalizacaoTipoLocal
     * @return ProcessoFiscalObras
     */
    public function setFkFiscalizacaoTipoLocal(\Urbem\CoreBundle\Entity\Fiscalizacao\TipoLocal $fkFiscalizacaoTipoLocal)
    {
        $this->codLocal = $fkFiscalizacaoTipoLocal->getCodLocal();
        $this->fkFiscalizacaoTipoLocal = $fkFiscalizacaoTipoLocal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoTipoLocal
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\TipoLocal
     */
    public function getFkFiscalizacaoTipoLocal()
    {
        return $this->fkFiscalizacaoTipoLocal;
    }

    /**
     * OneToOne (owning side)
     * Set FiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     * @return ProcessoFiscalObras
     */
    public function setFkFiscalizacaoProcessoFiscal(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        $this->codProcesso = $fkFiscalizacaoProcessoFiscal->getCodProcesso();
        $this->fkFiscalizacaoProcessoFiscal = $fkFiscalizacaoProcessoFiscal;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFiscalizacaoProcessoFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    public function getFkFiscalizacaoProcessoFiscal()
    {
        return $this->fkFiscalizacaoProcessoFiscal;
    }
}
