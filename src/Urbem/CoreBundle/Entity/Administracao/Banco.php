<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Banco
 */
class Banco
{
    /**
     * PK
     * @var string
     */
    private $codBanco;

    /**
     * @var string
     */
    private $nomBanco;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Agencia
     */
    private $fkAdministracaoAgencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoAgencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codBanco
     *
     * @param string $codBanco
     * @return Banco
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return string
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set nomBanco
     *
     * @param string $nomBanco
     * @return Banco
     */
    public function setNomBanco($nomBanco)
    {
        $this->nomBanco = $nomBanco;
        return $this;
    }

    /**
     * Get nomBanco
     *
     * @return string
     */
    public function getNomBanco()
    {
        return $this->nomBanco;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Agencia $fkAdministracaoAgencia
     * @return Banco
     */
    public function addFkAdministracaoAgencias(\Urbem\CoreBundle\Entity\Administracao\Agencia $fkAdministracaoAgencia)
    {
        if (false === $this->fkAdministracaoAgencias->contains($fkAdministracaoAgencia)) {
            $fkAdministracaoAgencia->setFkAdministracaoBanco($this);
            $this->fkAdministracaoAgencias->add($fkAdministracaoAgencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Agencia $fkAdministracaoAgencia
     */
    public function removeFkAdministracaoAgencias(\Urbem\CoreBundle\Entity\Administracao\Agencia $fkAdministracaoAgencia)
    {
        $this->fkAdministracaoAgencias->removeElement($fkAdministracaoAgencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAgencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Agencia
     */
    public function getFkAdministracaoAgencias()
    {
        return $this->fkAdministracaoAgencias;
    }
}
