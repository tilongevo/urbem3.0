<?php
 
namespace Urbem\CoreBundle\Entity\Normas;

/**
 * TipoNorma
 */
class TipoNorma
{
    /**
     * PK
     * @var integer
     */
    private $codTipoNorma;

    /**
     * @var string
     */
    private $nomTipoNorma;

    /**
     * @var integer
     */
    private $codCadastro;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepe\VinculoTipoNorma
     */
    private $fkTcepeVinculoTipoNorma;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcerj\Fundamento
     */
    private $fkTcerjFundamento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmba\VinculoTipoNorma
     */
    private $fkTcmbaVinculoTipoNorma;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma
     */
    private $fkNormasAtributoTipoNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\NormaTipoNorma
     */
    private $fkNormasNormaTipoNormas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Cadastro
     */
    private $fkAdministracaoCadastro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkNormasAtributoTipoNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkNormasNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkNormasNormaTipoNormas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoNorma
     *
     * @param integer $codTipoNorma
     * @return TipoNorma
     */
    public function setCodTipoNorma($codTipoNorma)
    {
        $this->codTipoNorma = $codTipoNorma;
        return $this;
    }

    /**
     * Get codTipoNorma
     *
     * @return integer
     */
    public function getCodTipoNorma()
    {
        return $this->codTipoNorma;
    }

    /**
     * Set nomTipoNorma
     *
     * @param string $nomTipoNorma
     * @return TipoNorma
     */
    public function setNomTipoNorma($nomTipoNorma)
    {
        $this->nomTipoNorma = $nomTipoNorma;
        return $this;
    }

    /**
     * Get nomTipoNorma
     *
     * @return string
     */
    public function getNomTipoNorma()
    {
        return $this->nomTipoNorma;
    }

    /**
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return TipoNorma
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return TipoNorma
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * OneToMany (owning side)
     * Add NormasAtributoTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma
     * @return TipoNorma
     */
    public function addFkNormasAtributoTipoNormas(\Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma)
    {
        if (false === $this->fkNormasAtributoTipoNormas->contains($fkNormasAtributoTipoNorma)) {
            $fkNormasAtributoTipoNorma->setFkNormasTipoNorma($this);
            $this->fkNormasAtributoTipoNormas->add($fkNormasAtributoTipoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove NormasAtributoTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma
     */
    public function removeFkNormasAtributoTipoNormas(\Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma)
    {
        $this->fkNormasAtributoTipoNormas->removeElement($fkNormasAtributoTipoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkNormasAtributoTipoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma
     */
    public function getFkNormasAtributoTipoNormas()
    {
        return $this->fkNormasAtributoTipoNormas;
    }

    /**
     * OneToMany (owning side)
     * Add NormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return TipoNorma
     */
    public function addFkNormasNormas(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        if (false === $this->fkNormasNormas->contains($fkNormasNorma)) {
            $fkNormasNorma->setFkNormasTipoNorma($this);
            $this->fkNormasNormas->add($fkNormasNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove NormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     */
    public function removeFkNormasNormas(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->fkNormasNormas->removeElement($fkNormasNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkNormasNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNormas()
    {
        return $this->fkNormasNormas;
    }

    /**
     * OneToMany (owning side)
     * Add NormasNormaTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\NormaTipoNorma $fkNormasNormaTipoNorma
     * @return TipoNorma
     */
    public function addFkNormasNormaTipoNormas(\Urbem\CoreBundle\Entity\Normas\NormaTipoNorma $fkNormasNormaTipoNorma)
    {
        if (false === $this->fkNormasNormaTipoNormas->contains($fkNormasNormaTipoNorma)) {
            $fkNormasNormaTipoNorma->setFkNormasTipoNorma($this);
            $this->fkNormasNormaTipoNormas->add($fkNormasNormaTipoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove NormasNormaTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\NormaTipoNorma $fkNormasNormaTipoNorma
     */
    public function removeFkNormasNormaTipoNormas(\Urbem\CoreBundle\Entity\Normas\NormaTipoNorma $fkNormasNormaTipoNorma)
    {
        $this->fkNormasNormaTipoNormas->removeElement($fkNormasNormaTipoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkNormasNormaTipoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\NormaTipoNorma
     */
    public function getFkNormasNormaTipoNormas()
    {
        return $this->fkNormasNormaTipoNormas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoCadastro
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Cadastro $fkAdministracaoCadastro
     * @return TipoNorma
     */
    public function setFkAdministracaoCadastro(\Urbem\CoreBundle\Entity\Administracao\Cadastro $fkAdministracaoCadastro)
    {
        $this->codModulo = $fkAdministracaoCadastro->getCodModulo();
        $this->codCadastro = $fkAdministracaoCadastro->getCodCadastro();
        $this->fkAdministracaoCadastro = $fkAdministracaoCadastro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoCadastro
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Cadastro
     */
    public function getFkAdministracaoCadastro()
    {
        return $this->fkAdministracaoCadastro;
    }

    /**
     * OneToOne (inverse side)
     * Set TcepeVinculoTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\VinculoTipoNorma $fkTcepeVinculoTipoNorma
     * @return TipoNorma
     */
    public function setFkTcepeVinculoTipoNorma(\Urbem\CoreBundle\Entity\Tcepe\VinculoTipoNorma $fkTcepeVinculoTipoNorma)
    {
        $fkTcepeVinculoTipoNorma->setFkNormasTipoNorma($this);
        $this->fkTcepeVinculoTipoNorma = $fkTcepeVinculoTipoNorma;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepeVinculoTipoNorma
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\VinculoTipoNorma
     */
    public function getFkTcepeVinculoTipoNorma()
    {
        return $this->fkTcepeVinculoTipoNorma;
    }

    /**
     * OneToOne (inverse side)
     * Set TcerjFundamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcerj\Fundamento $fkTcerjFundamento
     * @return TipoNorma
     */
    public function setFkTcerjFundamento(\Urbem\CoreBundle\Entity\Tcerj\Fundamento $fkTcerjFundamento)
    {
        $fkTcerjFundamento->setFkNormasTipoNorma($this);
        $this->fkTcerjFundamento = $fkTcerjFundamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcerjFundamento
     *
     * @return \Urbem\CoreBundle\Entity\Tcerj\Fundamento
     */
    public function getFkTcerjFundamento()
    {
        return $this->fkTcerjFundamento;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmbaVinculoTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\VinculoTipoNorma $fkTcmbaVinculoTipoNorma
     * @return TipoNorma
     */
    public function setFkTcmbaVinculoTipoNorma(\Urbem\CoreBundle\Entity\Tcmba\VinculoTipoNorma $fkTcmbaVinculoTipoNorma)
    {
        $fkTcmbaVinculoTipoNorma->setFkNormasTipoNorma($this);
        $this->fkTcmbaVinculoTipoNorma = $fkTcmbaVinculoTipoNorma;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmbaVinculoTipoNorma
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\VinculoTipoNorma
     */
    public function getFkTcmbaVinculoTipoNorma()
    {
        return $this->fkTcmbaVinculoTipoNorma;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%d - %s', $this->getCodTipoNorma(), $this->getNomTipoNorma());
    }
}
