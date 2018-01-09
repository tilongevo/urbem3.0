<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * EstadoCivil
 */
class EstadoCivil
{
    /**
     * PK
     * @var integer
     */
    private $codEstado;

    /**
     * @var string
     */
    private $nomEstado;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    private $fkCseCidadoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    private $fkPessoalServidores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseCidadoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalServidores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEstado
     *
     * @param integer $codEstado
     * @return EstadoCivil
     */
    public function setCodEstado($codEstado)
    {
        $this->codEstado = $codEstado;
        return $this;
    }

    /**
     * Get codEstado
     *
     * @return integer
     */
    public function getCodEstado()
    {
        return $this->codEstado;
    }

    /**
     * Set nomEstado
     *
     * @param string $nomEstado
     * @return EstadoCivil
     */
    public function setNomEstado($nomEstado)
    {
        $this->nomEstado = $nomEstado;
        return $this;
    }

    /**
     * Get nomEstado
     *
     * @return string
     */
    public function getNomEstado()
    {
        return $this->nomEstado;
    }

    /**
     * OneToMany (owning side)
     * Add CseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return EstadoCivil
     */
    public function addFkCseCidadoes(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        if (false === $this->fkCseCidadoes->contains($fkCseCidadao)) {
            $fkCseCidadao->setFkCseEstadoCivil($this);
            $this->fkCseCidadoes->add($fkCseCidadao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     */
    public function removeFkCseCidadoes(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        $this->fkCseCidadoes->removeElement($fkCseCidadao);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseCidadoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    public function getFkCseCidadoes()
    {
        return $this->fkCseCidadoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor
     * @return EstadoCivil
     */
    public function addFkPessoalServidores(\Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor)
    {
        if (false === $this->fkPessoalServidores->contains($fkPessoalServidor)) {
            $fkPessoalServidor->setFkCseEstadoCivil($this);
            $this->fkPessoalServidores->add($fkPessoalServidor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor
     */
    public function removeFkPessoalServidores(\Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor)
    {
        $this->fkPessoalServidores->removeElement($fkPessoalServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    public function getFkPessoalServidores()
    {
        return $this->fkPessoalServidores;
    }
}
