<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

/**
 * TipoRecibo
 */
class TipoRecibo
{
    /**
     * PK
     * @var integer
     */
    private $codTipoRecibo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoRecibo
     */
    private $fkTceamTipoDocumentoRecibos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTceamTipoDocumentoRecibos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoRecibo
     *
     * @param integer $codTipoRecibo
     * @return TipoRecibo
     */
    public function setCodTipoRecibo($codTipoRecibo)
    {
        $this->codTipoRecibo = $codTipoRecibo;
        return $this;
    }

    /**
     * Get codTipoRecibo
     *
     * @return integer
     */
    public function getCodTipoRecibo()
    {
        return $this->codTipoRecibo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoRecibo
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add TceamTipoDocumentoRecibo
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoRecibo $fkTceamTipoDocumentoRecibo
     * @return TipoRecibo
     */
    public function addFkTceamTipoDocumentoRecibos(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoRecibo $fkTceamTipoDocumentoRecibo)
    {
        if (false === $this->fkTceamTipoDocumentoRecibos->contains($fkTceamTipoDocumentoRecibo)) {
            $fkTceamTipoDocumentoRecibo->setFkTceamTipoRecibo($this);
            $this->fkTceamTipoDocumentoRecibos->add($fkTceamTipoDocumentoRecibo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TceamTipoDocumentoRecibo
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoDocumentoRecibo $fkTceamTipoDocumentoRecibo
     */
    public function removeFkTceamTipoDocumentoRecibos(\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoRecibo $fkTceamTipoDocumentoRecibo)
    {
        $this->fkTceamTipoDocumentoRecibos->removeElement($fkTceamTipoDocumentoRecibo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTceamTipoDocumentoRecibos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoDocumentoRecibo
     */
    public function getFkTceamTipoDocumentoRecibos()
    {
        return $this->fkTceamTipoDocumentoRecibos;
    }
}
