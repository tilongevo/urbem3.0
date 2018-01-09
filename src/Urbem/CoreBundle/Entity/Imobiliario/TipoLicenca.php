<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TipoLicenca
 */
class TipoLicenca
{
    const TIPO_LICENCA_NOVA_EDIFICACAO = 1;
    const TIPO_LICENCA_HABITE_SE = 2;
    const TIPO_LICENCA_REFORMA = 3;
    const TIPO_LICENCA_REPAROS = 4;
    const TIPO_LICENCA_RECONSTRUCAO = 5;
    const TIPO_LICENCA_DEMOLICAO = 6;
    const TIPO_LICENCA_LOTEAMENTO = 7;
    const TIPO_LICENCA_DESMEMBRAMENTO = 8;
    const TIPO_LICENCA_AGLUTINACAO = 9;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca
     */
    private $fkImobiliarioAtributoTipoLicencas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento
     */
    private $fkImobiliarioTipoLicencaDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Permissao
     */
    private $fkImobiliarioPermissoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioAtributoTipoLicencas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTipoLicencaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioPermissoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoLicenca
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
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoLicenca
     */
    public function setNomTipo($nomTipo)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoTipoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca $fkImobiliarioAtributoTipoLicenca
     * @return TipoLicenca
     */
    public function addFkImobiliarioAtributoTipoLicencas(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca $fkImobiliarioAtributoTipoLicenca)
    {
        if (false === $this->fkImobiliarioAtributoTipoLicencas->contains($fkImobiliarioAtributoTipoLicenca)) {
            $fkImobiliarioAtributoTipoLicenca->setFkImobiliarioTipoLicenca($this);
            $this->fkImobiliarioAtributoTipoLicencas->add($fkImobiliarioAtributoTipoLicenca);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoTipoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca $fkImobiliarioAtributoTipoLicenca
     */
    public function removeFkImobiliarioAtributoTipoLicencas(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca $fkImobiliarioAtributoTipoLicenca)
    {
        $this->fkImobiliarioAtributoTipoLicencas->removeElement($fkImobiliarioAtributoTipoLicenca);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoTipoLicencas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca
     */
    public function getFkImobiliarioAtributoTipoLicencas()
    {
        return $this->fkImobiliarioAtributoTipoLicencas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTipoLicencaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento $fkImobiliarioTipoLicencaDocumento
     * @return TipoLicenca
     */
    public function addFkImobiliarioTipoLicencaDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento $fkImobiliarioTipoLicencaDocumento)
    {
        if (false === $this->fkImobiliarioTipoLicencaDocumentos->contains($fkImobiliarioTipoLicencaDocumento)) {
            $fkImobiliarioTipoLicencaDocumento->setFkImobiliarioTipoLicenca($this);
            $this->fkImobiliarioTipoLicencaDocumentos->add($fkImobiliarioTipoLicencaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTipoLicencaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento $fkImobiliarioTipoLicencaDocumento
     */
    public function removeFkImobiliarioTipoLicencaDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento $fkImobiliarioTipoLicencaDocumento)
    {
        $this->fkImobiliarioTipoLicencaDocumentos->removeElement($fkImobiliarioTipoLicencaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTipoLicencaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento
     */
    public function getFkImobiliarioTipoLicencaDocumentos()
    {
        return $this->fkImobiliarioTipoLicencaDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Permissao $fkImobiliarioPermissao
     * @return TipoLicenca
     */
    public function addFkImobiliarioPermissoes(\Urbem\CoreBundle\Entity\Imobiliario\Permissao $fkImobiliarioPermissao)
    {
        if (false === $this->fkImobiliarioPermissoes->contains($fkImobiliarioPermissao)) {
            $fkImobiliarioPermissao->setFkImobiliarioTipoLicenca($this);
            $this->fkImobiliarioPermissoes->add($fkImobiliarioPermissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Permissao $fkImobiliarioPermissao
     */
    public function removeFkImobiliarioPermissoes(\Urbem\CoreBundle\Entity\Imobiliario\Permissao $fkImobiliarioPermissao)
    {
        $this->fkImobiliarioPermissoes->removeElement($fkImobiliarioPermissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioPermissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Permissao
     */
    public function getFkImobiliarioPermissoes()
    {
        return $this->fkImobiliarioPermissoes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codTipo, $this->nomTipo);
    }
}
