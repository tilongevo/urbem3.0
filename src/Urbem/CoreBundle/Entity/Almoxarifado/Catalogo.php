<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Catalogo
 */
class Catalogo
{
    /**
     * PK
     * @var integer
     */
    private $codCatalogo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var boolean
     */
    private $permiteManutencao = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao
     */
    private $fkAlmoxarifadoCatalogoClassificacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoNiveis
     */
    private $fkAlmoxarifadoCatalogoNiveis;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoCatalogoClassificacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoCatalogoNiveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCatalogo
     *
     * @param integer $codCatalogo
     * @return Catalogo
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
     * Set descricao
     *
     * @param string $descricao
     * @return Catalogo
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
     * Set permiteManutencao
     *
     * @param boolean $permiteManutencao
     * @return Catalogo
     */
    public function setPermiteManutencao($permiteManutencao)
    {
        $this->permiteManutencao = $permiteManutencao;
        return $this;
    }

    /**
     * Get permiteManutencao
     *
     * @return boolean
     */
    public function getPermiteManutencao()
    {
        return $this->permiteManutencao;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoCatalogoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao $fkAlmoxarifadoCatalogoClassificacao
     * @return Catalogo
     */
    public function addFkAlmoxarifadoCatalogoClassificacoes(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao $fkAlmoxarifadoCatalogoClassificacao)
    {
        if (false === $this->fkAlmoxarifadoCatalogoClassificacoes->contains($fkAlmoxarifadoCatalogoClassificacao)) {
            $fkAlmoxarifadoCatalogoClassificacao->setFkAlmoxarifadoCatalogo($this);
            $this->fkAlmoxarifadoCatalogoClassificacoes->add($fkAlmoxarifadoCatalogoClassificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCatalogoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao $fkAlmoxarifadoCatalogoClassificacao
     */
    public function removeFkAlmoxarifadoCatalogoClassificacoes(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao $fkAlmoxarifadoCatalogoClassificacao)
    {
        $this->fkAlmoxarifadoCatalogoClassificacoes->removeElement($fkAlmoxarifadoCatalogoClassificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCatalogoClassificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao
     */
    public function getFkAlmoxarifadoCatalogoClassificacoes()
    {
        return $this->fkAlmoxarifadoCatalogoClassificacoes;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoCatalogoNiveis
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoNiveis $fkAlmoxarifadoCatalogoNiveis
     * @return Catalogo
     */
    public function addFkAlmoxarifadoCatalogoNiveis(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoNiveis $fkAlmoxarifadoCatalogoNiveis)
    {
        if (false === $this->fkAlmoxarifadoCatalogoNiveis->contains($fkAlmoxarifadoCatalogoNiveis)) {
            $fkAlmoxarifadoCatalogoNiveis->setFkAlmoxarifadoCatalogo($this);
            $this->fkAlmoxarifadoCatalogoNiveis->add($fkAlmoxarifadoCatalogoNiveis);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCatalogoNiveis
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoNiveis $fkAlmoxarifadoCatalogoNiveis
     */
    public function removeFkAlmoxarifadoCatalogoNiveis(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoNiveis $fkAlmoxarifadoCatalogoNiveis)
    {
        $this->fkAlmoxarifadoCatalogoNiveis->removeElement($fkAlmoxarifadoCatalogoNiveis);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCatalogoNiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoNiveis
     */
    public function getFkAlmoxarifadoCatalogoNiveis()
    {
        return $this->fkAlmoxarifadoCatalogoNiveis;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->codCatalogo,
            $this->descricao
        );
    }
}
