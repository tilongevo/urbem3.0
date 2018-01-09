<?php
 
namespace Urbem\CoreBundle\Entity\Tcesc;

/**
 * TipoCertidaoEsfinge
 */
class TipoCertidaoEsfinge
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
     * @var \Urbem\CoreBundle\Entity\Tcesc\TipoCertidao
     */
    private $fkTcescTipoCertidao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Documento
     */
    private $fkLicitacaoDocumento;


    /**
     * Set codTipoCertidao
     *
     * @param integer $codTipoCertidao
     * @return TipoCertidaoEsfinge
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
     * @return TipoCertidaoEsfinge
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
     * Set fkTcescTipoCertidao
     *
     * @param \Urbem\CoreBundle\Entity\Tcesc\TipoCertidao $fkTcescTipoCertidao
     * @return TipoCertidaoEsfinge
     */
    public function setFkTcescTipoCertidao(\Urbem\CoreBundle\Entity\Tcesc\TipoCertidao $fkTcescTipoCertidao)
    {
        $this->codTipoCertidao = $fkTcescTipoCertidao->getCodTipoCertidao();
        $this->fkTcescTipoCertidao = $fkTcescTipoCertidao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcescTipoCertidao
     *
     * @return \Urbem\CoreBundle\Entity\Tcesc\TipoCertidao
     */
    public function getFkTcescTipoCertidao()
    {
        return $this->fkTcescTipoCertidao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Documento $fkLicitacaoDocumento
     * @return TipoCertidaoEsfinge
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
