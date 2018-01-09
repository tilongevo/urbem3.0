<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoContratacaoObra
 */
class TipoContratacaoObra
{
    /**
     * PK
     * @var integer
     */
    private $codContratacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraContratos
     */
    private $fkTcmbaObraContratos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaObraContratos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codContratacao
     *
     * @param integer $codContratacao
     * @return TipoContratacaoObra
     */
    public function setCodContratacao($codContratacao)
    {
        $this->codContratacao = $codContratacao;
        return $this;
    }

    /**
     * Get codContratacao
     *
     * @return integer
     */
    public function getCodContratacao()
    {
        return $this->codContratacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoContratacaoObra
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
     * Add TcmbaObraContratos
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraContratos $fkTcmbaObraContratos
     * @return TipoContratacaoObra
     */
    public function addFkTcmbaObraContratos(\Urbem\CoreBundle\Entity\Tcmba\ObraContratos $fkTcmbaObraContratos)
    {
        if (false === $this->fkTcmbaObraContratos->contains($fkTcmbaObraContratos)) {
            $fkTcmbaObraContratos->setFkTcmbaTipoContratacaoObra($this);
            $this->fkTcmbaObraContratos->add($fkTcmbaObraContratos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObraContratos
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraContratos $fkTcmbaObraContratos
     */
    public function removeFkTcmbaObraContratos(\Urbem\CoreBundle\Entity\Tcmba\ObraContratos $fkTcmbaObraContratos)
    {
        $this->fkTcmbaObraContratos->removeElement($fkTcmbaObraContratos);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObraContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraContratos
     */
    public function getFkTcmbaObraContratos()
    {
        return $this->fkTcmbaObraContratos;
    }
}
