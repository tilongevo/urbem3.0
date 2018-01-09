<?php
 
namespace Urbem\CoreBundle\Entity\Ldo;

/**
 * TipoIndicadores
 */
class TipoIndicadores
{
    /**
     * PK
     * @var integer
     */
    private $codTipoIndicador;

    /**
     * @var integer
     */
    private $codUnidade;

    /**
     * @var integer
     */
    private $codGrandeza;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\Indicadores
     */
    private $fkLdoIndicadoreses;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    private $fkAdministracaoUnidadeMedida;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLdoIndicadoreses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoIndicador
     *
     * @param integer $codTipoIndicador
     * @return TipoIndicadores
     */
    public function setCodTipoIndicador($codTipoIndicador)
    {
        $this->codTipoIndicador = $codTipoIndicador;
        return $this;
    }

    /**
     * Get codTipoIndicador
     *
     * @return integer
     */
    public function getCodTipoIndicador()
    {
        return $this->codTipoIndicador;
    }

    /**
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return TipoIndicadores
     */
    public function setCodUnidade($codUnidade)
    {
        $this->codUnidade = $codUnidade;
        return $this;
    }

    /**
     * Get codUnidade
     *
     * @return integer
     */
    public function getCodUnidade()
    {
        return $this->codUnidade;
    }

    /**
     * Set codGrandeza
     *
     * @param integer $codGrandeza
     * @return TipoIndicadores
     */
    public function setCodGrandeza($codGrandeza)
    {
        $this->codGrandeza = $codGrandeza;
        return $this;
    }

    /**
     * Get codGrandeza
     *
     * @return integer
     */
    public function getCodGrandeza()
    {
        return $this->codGrandeza;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoIndicadores
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
     * Add LdoIndicadores
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Indicadores $fkLdoIndicadores
     * @return TipoIndicadores
     */
    public function addFkLdoIndicadoreses(\Urbem\CoreBundle\Entity\Ldo\Indicadores $fkLdoIndicadores)
    {
        if (false === $this->fkLdoIndicadoreses->contains($fkLdoIndicadores)) {
            $fkLdoIndicadores->setFkLdoTipoIndicadores($this);
            $this->fkLdoIndicadoreses->add($fkLdoIndicadores);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LdoIndicadores
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Indicadores $fkLdoIndicadores
     */
    public function removeFkLdoIndicadoreses(\Urbem\CoreBundle\Entity\Ldo\Indicadores $fkLdoIndicadores)
    {
        $this->fkLdoIndicadoreses->removeElement($fkLdoIndicadores);
    }

    /**
     * OneToMany (owning side)
     * Get fkLdoIndicadoreses
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\Indicadores
     */
    public function getFkLdoIndicadoreses()
    {
        return $this->fkLdoIndicadoreses;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUnidadeMedida
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida
     * @return TipoIndicadores
     */
    public function setFkAdministracaoUnidadeMedida(\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida)
    {
        $this->codUnidade = $fkAdministracaoUnidadeMedida->getCodUnidade();
        $this->codGrandeza = $fkAdministracaoUnidadeMedida->getCodGrandeza();
        $this->fkAdministracaoUnidadeMedida = $fkAdministracaoUnidadeMedida;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUnidadeMedida
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    public function getFkAdministracaoUnidadeMedida()
    {
        return $this->fkAdministracaoUnidadeMedida;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) sprintf('%s', $this->getDescricao());
    }
}
