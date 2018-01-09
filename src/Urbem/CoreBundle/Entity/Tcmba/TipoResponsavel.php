<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoResponsavel
 */
class TipoResponsavel
{
    /**
     * PK
     * @var integer
     */
    private $codTipoResponsavel;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador
     */
    private $fkTcmbaConfiguracaoRatificadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador
     */
    private $fkTcmbaConfiguracaoOrdenadores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaConfiguracaoRatificadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaConfiguracaoOrdenadores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoResponsavel
     *
     * @param integer $codTipoResponsavel
     * @return TipoResponsavel
     */
    public function setCodTipoResponsavel($codTipoResponsavel)
    {
        $this->codTipoResponsavel = $codTipoResponsavel;
        return $this;
    }

    /**
     * Get codTipoResponsavel
     *
     * @return integer
     */
    public function getCodTipoResponsavel()
    {
        return $this->codTipoResponsavel;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoResponsavel
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
     * Add TcmbaConfiguracaoRatificador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador
     * @return TipoResponsavel
     */
    public function addFkTcmbaConfiguracaoRatificadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador)
    {
        if (false === $this->fkTcmbaConfiguracaoRatificadores->contains($fkTcmbaConfiguracaoRatificador)) {
            $fkTcmbaConfiguracaoRatificador->setFkTcmbaTipoResponsavel($this);
            $this->fkTcmbaConfiguracaoRatificadores->add($fkTcmbaConfiguracaoRatificador);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaConfiguracaoRatificador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador
     */
    public function removeFkTcmbaConfiguracaoRatificadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador)
    {
        $this->fkTcmbaConfiguracaoRatificadores->removeElement($fkTcmbaConfiguracaoRatificador);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaConfiguracaoRatificadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador
     */
    public function getFkTcmbaConfiguracaoRatificadores()
    {
        return $this->fkTcmbaConfiguracaoRatificadores;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador
     * @return TipoResponsavel
     */
    public function addFkTcmbaConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador)
    {
        if (false === $this->fkTcmbaConfiguracaoOrdenadores->contains($fkTcmbaConfiguracaoOrdenador)) {
            $fkTcmbaConfiguracaoOrdenador->setFkTcmbaTipoResponsavel($this);
            $this->fkTcmbaConfiguracaoOrdenadores->add($fkTcmbaConfiguracaoOrdenador);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador
     */
    public function removeFkTcmbaConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador)
    {
        $this->fkTcmbaConfiguracaoOrdenadores->removeElement($fkTcmbaConfiguracaoOrdenador);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaConfiguracaoOrdenadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador
     */
    public function getFkTcmbaConfiguracaoOrdenadores()
    {
        return $this->fkTcmbaConfiguracaoOrdenadores;
    }
}
