<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

/**
 * TipoCertidaoDocumento
 */
class TipoCertidaoDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codTipoCertidao;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceam\TipoCertidao
     */
    private $fkTceamTipoCertidao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Documento
     */
    private $fkLicitacaoDocumento;


    /**
     * Set codTipoCertidao
     *
     * @param integer $codTipoCertidao
     * @return TipoCertidaoDocumento
     */
    public function setCodTipoCertidao($codTipoCertidao)
    {
        $this->codTipoCertidao = $codTipoCertidao;
        return $this;
    }

    /**
     * Get codTipoCertidao
     *
     * @return integer
     */
    public function getCodTipoCertidao()
    {
        return $this->codTipoCertidao;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return TipoCertidaoDocumento
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTceamTipoCertidao
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoCertidao $fkTceamTipoCertidao
     * @return TipoCertidaoDocumento
     */
    public function setFkTceamTipoCertidao(\Urbem\CoreBundle\Entity\Tceam\TipoCertidao $fkTceamTipoCertidao)
    {
        $this->codTipoCertidao = $fkTceamTipoCertidao->getCodTipoCertidao();
        $this->fkTceamTipoCertidao = $fkTceamTipoCertidao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTceamTipoCertidao
     *
     * @return \Urbem\CoreBundle\Entity\Tceam\TipoCertidao
     */
    public function getFkTceamTipoCertidao()
    {
        return $this->fkTceamTipoCertidao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Documento $fkLicitacaoDocumento
     * @return TipoCertidaoDocumento
     */
    public function setFkLicitacaoDocumento(\Urbem\CoreBundle\Entity\Licitacao\Documento $fkLicitacaoDocumento)
    {
        $this->codDocumento = $fkLicitacaoDocumento->getCodDocumento();
        $this->fkLicitacaoDocumento = $fkLicitacaoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Documento
     */
    public function getFkLicitacaoDocumento()
    {
        return $this->fkLicitacaoDocumento;
    }
}
