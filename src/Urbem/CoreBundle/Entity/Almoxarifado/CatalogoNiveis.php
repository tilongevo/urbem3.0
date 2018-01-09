<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * CatalogoNiveis
 */
class CatalogoNiveis
{
    /**
     * PK
     * @var integer
     */
    private $nivel;

    /**
     * PK
     * @var integer
     */
    private $codCatalogo;

    /**
     * @var string
     */
    private $mascara;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\ClassificacaoNivel
     */
    private $fkAlmoxarifadoClassificacaoNiveis;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Catalogo
     */
    private $fkAlmoxarifadoCatalogo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoClassificacaoNiveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nivel
     *
     * @param integer $nivel
     * @return CatalogoNiveis
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
        return $this;
    }

    /**
     * Get nivel
     *
     * @return integer
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set codCatalogo
     *
     * @param integer $codCatalogo
     * @return CatalogoNiveis
     */
    public function setCodCatalogo($codCatalogo)
    {
        $this->codCatalogo = $codCatalogo;
        return $this;
    }

    /**
     * Get codCatalogo
     *
     * @return integer
     */
    public function getCodCatalogo()
    {
        return $this->codCatalogo;
    }

    /**
     * Set mascara
     *
     * @param string $mascara
     * @return CatalogoNiveis
     */
    public function setMascara($mascara)
    {
        $this->mascara = $mascara;
        return $this;
    }

    /**
     * Get mascara
     *
     * @return string
     */
    public function getMascara()
    {
        return $this->mascara;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return CatalogoNiveis
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
     * Add AlmoxarifadoClassificacaoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\ClassificacaoNivel $fkAlmoxarifadoClassificacaoNivel
     * @return CatalogoNiveis
     */
    public function addFkAlmoxarifadoClassificacaoNiveis(\Urbem\CoreBundle\Entity\Almoxarifado\ClassificacaoNivel $fkAlmoxarifadoClassificacaoNivel)
    {
        if (false === $this->fkAlmoxarifadoClassificacaoNiveis->contains($fkAlmoxarifadoClassificacaoNivel)) {
            $fkAlmoxarifadoClassificacaoNivel->setFkAlmoxarifadoCatalogoNiveis($this);
            $this->fkAlmoxarifadoClassificacaoNiveis->add($fkAlmoxarifadoClassificacaoNivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoClassificacaoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\ClassificacaoNivel $fkAlmoxarifadoClassificacaoNivel
     */
    public function removeFkAlmoxarifadoClassificacaoNiveis(\Urbem\CoreBundle\Entity\Almoxarifado\ClassificacaoNivel $fkAlmoxarifadoClassificacaoNivel)
    {
        $this->fkAlmoxarifadoClassificacaoNiveis->removeElement($fkAlmoxarifadoClassificacaoNivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoClassificacaoNiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\ClassificacaoNivel
     */
    public function getFkAlmoxarifadoClassificacaoNiveis()
    {
        return $this->fkAlmoxarifadoClassificacaoNiveis;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogo
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Catalogo $fkAlmoxarifadoCatalogo
     * @return CatalogoNiveis
     */
    public function setFkAlmoxarifadoCatalogo(\Urbem\CoreBundle\Entity\Almoxarifado\Catalogo $fkAlmoxarifadoCatalogo)
    {
        $this->codCatalogo = $fkAlmoxarifadoCatalogo->getCodCatalogo();
        $this->fkAlmoxarifadoCatalogo = $fkAlmoxarifadoCatalogo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogo
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Catalogo
     */
    public function getFkAlmoxarifadoCatalogo()
    {
        return $this->fkAlmoxarifadoCatalogo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codCatalogo, $this->descricao);
    }
}
