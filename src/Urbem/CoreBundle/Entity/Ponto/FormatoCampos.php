<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * FormatoCampos
 */
class FormatoCampos
{
    /**
     * PK
     * @var integer
     */
    private $codCampo;

    /**
     * @var string
     */
    private $nomCampo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\FormatoTamanhoFixo
     */
    private $fkPontoFormatoTamanhoFixos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DelimitadorColunas
     */
    private $fkPontoDelimitadorColunas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoFormatoTamanhoFixos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoDelimitadorColunas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCampo
     *
     * @param integer $codCampo
     * @return FormatoCampos
     */
    public function setCodCampo($codCampo)
    {
        $this->codCampo = $codCampo;
        return $this;
    }

    /**
     * Get codCampo
     *
     * @return integer
     */
    public function getCodCampo()
    {
        return $this->codCampo;
    }

    /**
     * Set nomCampo
     *
     * @param string $nomCampo
     * @return FormatoCampos
     */
    public function setNomCampo($nomCampo)
    {
        $this->nomCampo = $nomCampo;
        return $this;
    }

    /**
     * Get nomCampo
     *
     * @return string
     */
    public function getNomCampo()
    {
        return $this->nomCampo;
    }

    /**
     * OneToMany (owning side)
     * Add PontoFormatoTamanhoFixo
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoTamanhoFixo $fkPontoFormatoTamanhoFixo
     * @return FormatoCampos
     */
    public function addFkPontoFormatoTamanhoFixos(\Urbem\CoreBundle\Entity\Ponto\FormatoTamanhoFixo $fkPontoFormatoTamanhoFixo)
    {
        if (false === $this->fkPontoFormatoTamanhoFixos->contains($fkPontoFormatoTamanhoFixo)) {
            $fkPontoFormatoTamanhoFixo->setFkPontoFormatoCampos($this);
            $this->fkPontoFormatoTamanhoFixos->add($fkPontoFormatoTamanhoFixo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoFormatoTamanhoFixo
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoTamanhoFixo $fkPontoFormatoTamanhoFixo
     */
    public function removeFkPontoFormatoTamanhoFixos(\Urbem\CoreBundle\Entity\Ponto\FormatoTamanhoFixo $fkPontoFormatoTamanhoFixo)
    {
        $this->fkPontoFormatoTamanhoFixos->removeElement($fkPontoFormatoTamanhoFixo);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoFormatoTamanhoFixos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\FormatoTamanhoFixo
     */
    public function getFkPontoFormatoTamanhoFixos()
    {
        return $this->fkPontoFormatoTamanhoFixos;
    }

    /**
     * OneToMany (owning side)
     * Add PontoDelimitadorColunas
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DelimitadorColunas $fkPontoDelimitadorColunas
     * @return FormatoCampos
     */
    public function addFkPontoDelimitadorColunas(\Urbem\CoreBundle\Entity\Ponto\DelimitadorColunas $fkPontoDelimitadorColunas)
    {
        if (false === $this->fkPontoDelimitadorColunas->contains($fkPontoDelimitadorColunas)) {
            $fkPontoDelimitadorColunas->setFkPontoFormatoCampos($this);
            $this->fkPontoDelimitadorColunas->add($fkPontoDelimitadorColunas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoDelimitadorColunas
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DelimitadorColunas $fkPontoDelimitadorColunas
     */
    public function removeFkPontoDelimitadorColunas(\Urbem\CoreBundle\Entity\Ponto\DelimitadorColunas $fkPontoDelimitadorColunas)
    {
        $this->fkPontoDelimitadorColunas->removeElement($fkPontoDelimitadorColunas);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoDelimitadorColunas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DelimitadorColunas
     */
    public function getFkPontoDelimitadorColunas()
    {
        return $this->fkPontoDelimitadorColunas;
    }
}
