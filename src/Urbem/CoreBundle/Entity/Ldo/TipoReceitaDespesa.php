<?php
 
namespace Urbem\CoreBundle\Entity\Ldo;

/**
 * TipoReceitaDespesa
 */
class TipoReceitaDespesa
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $codEstrutural;

    /**
     * @var integer
     */
    private $nivel;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var boolean
     */
    private $rpps = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoReceitaDespesa
     */
    private $fkLdoConfiguracaoReceitaDespesas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLdoConfiguracaoReceitaDespesas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoReceitaDespesa
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
     * Set tipo
     *
     * @param string $tipo
     * @return TipoReceitaDespesa
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set codEstrutural
     *
     * @param string $codEstrutural
     * @return TipoReceitaDespesa
     */
    public function setCodEstrutural($codEstrutural)
    {
        $this->codEstrutural = $codEstrutural;
        return $this;
    }

    /**
     * Get codEstrutural
     *
     * @return string
     */
    public function getCodEstrutural()
    {
        return $this->codEstrutural;
    }

    /**
     * Set nivel
     *
     * @param integer $nivel
     * @return TipoReceitaDespesa
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
     * Set descricao
     *
     * @param string $descricao
     * @return TipoReceitaDespesa
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
     * Set rpps
     *
     * @param boolean $rpps
     * @return TipoReceitaDespesa
     */
    public function setRpps($rpps)
    {
        $this->rpps = $rpps;
        return $this;
    }

    /**
     * Get rpps
     *
     * @return boolean
     */
    public function getRpps()
    {
        return $this->rpps;
    }

    /**
     * OneToMany (owning side)
     * Add LdoConfiguracaoReceitaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\ConfiguracaoReceitaDespesa $fkLdoConfiguracaoReceitaDespesa
     * @return TipoReceitaDespesa
     */
    public function addFkLdoConfiguracaoReceitaDespesas(\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoReceitaDespesa $fkLdoConfiguracaoReceitaDespesa)
    {
        if (false === $this->fkLdoConfiguracaoReceitaDespesas->contains($fkLdoConfiguracaoReceitaDespesa)) {
            $fkLdoConfiguracaoReceitaDespesa->setFkLdoTipoReceitaDespesa($this);
            $this->fkLdoConfiguracaoReceitaDespesas->add($fkLdoConfiguracaoReceitaDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LdoConfiguracaoReceitaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\ConfiguracaoReceitaDespesa $fkLdoConfiguracaoReceitaDespesa
     */
    public function removeFkLdoConfiguracaoReceitaDespesas(\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoReceitaDespesa $fkLdoConfiguracaoReceitaDespesa)
    {
        $this->fkLdoConfiguracaoReceitaDespesas->removeElement($fkLdoConfiguracaoReceitaDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkLdoConfiguracaoReceitaDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoReceitaDespesa
     */
    public function getFkLdoConfiguracaoReceitaDespesas()
    {
        return $this->fkLdoConfiguracaoReceitaDespesas;
    }
}
