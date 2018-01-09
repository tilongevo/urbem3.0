<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * SchemaRh
 */
class SchemaRh
{
    /**
     * PK
     * @var integer
     */
    private $schemaCod;

    /**
     * @var string
     */
    private $schemaNome;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\EntidadeRh
     */
    private $fkAdministracaoEntidadeRhs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\TabelasRh
     */
    private $fkAdministracaoTabelasRhs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoEntidadeRhs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoTabelasRhs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set schemaCod
     *
     * @param integer $schemaCod
     * @return SchemaRh
     */
    public function setSchemaCod($schemaCod)
    {
        $this->schemaCod = $schemaCod;
        return $this;
    }

    /**
     * Get schemaCod
     *
     * @return integer
     */
    public function getSchemaCod()
    {
        return $this->schemaCod;
    }

    /**
     * Set schemaNome
     *
     * @param string $schemaNome
     * @return SchemaRh
     */
    public function setSchemaNome($schemaNome)
    {
        $this->schemaNome = $schemaNome;
        return $this;
    }

    /**
     * Get schemaNome
     *
     * @return string
     */
    public function getSchemaNome()
    {
        return $this->schemaNome;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoEntidadeRh
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\EntidadeRh $fkAdministracaoEntidadeRh
     * @return SchemaRh
     */
    public function addFkAdministracaoEntidadeRhs(\Urbem\CoreBundle\Entity\Administracao\EntidadeRh $fkAdministracaoEntidadeRh)
    {
        if (false === $this->fkAdministracaoEntidadeRhs->contains($fkAdministracaoEntidadeRh)) {
            $fkAdministracaoEntidadeRh->setFkAdministracaoSchemaRh($this);
            $this->fkAdministracaoEntidadeRhs->add($fkAdministracaoEntidadeRh);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoEntidadeRh
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\EntidadeRh $fkAdministracaoEntidadeRh
     */
    public function removeFkAdministracaoEntidadeRhs(\Urbem\CoreBundle\Entity\Administracao\EntidadeRh $fkAdministracaoEntidadeRh)
    {
        $this->fkAdministracaoEntidadeRhs->removeElement($fkAdministracaoEntidadeRh);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoEntidadeRhs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\EntidadeRh
     */
    public function getFkAdministracaoEntidadeRhs()
    {
        return $this->fkAdministracaoEntidadeRhs;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoTabelasRh
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\TabelasRh $fkAdministracaoTabelasRh
     * @return SchemaRh
     */
    public function addFkAdministracaoTabelasRhs(\Urbem\CoreBundle\Entity\Administracao\TabelasRh $fkAdministracaoTabelasRh)
    {
        if (false === $this->fkAdministracaoTabelasRhs->contains($fkAdministracaoTabelasRh)) {
            $fkAdministracaoTabelasRh->setFkAdministracaoSchemaRh($this);
            $this->fkAdministracaoTabelasRhs->add($fkAdministracaoTabelasRh);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoTabelasRh
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\TabelasRh $fkAdministracaoTabelasRh
     */
    public function removeFkAdministracaoTabelasRhs(\Urbem\CoreBundle\Entity\Administracao\TabelasRh $fkAdministracaoTabelasRh)
    {
        $this->fkAdministracaoTabelasRhs->removeElement($fkAdministracaoTabelasRh);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoTabelasRhs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\TabelasRh
     */
    public function getFkAdministracaoTabelasRhs()
    {
        return $this->fkAdministracaoTabelasRhs;
    }
}
