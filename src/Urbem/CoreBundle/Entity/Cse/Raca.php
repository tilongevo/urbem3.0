<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * Raca
 */
class Raca
{
    /**
     * PK
     * @var integer
     */
    private $codRaca;

    /**
     * @var string
     */
    private $nomRaca;

    /**
     * @var integer
     */
    private $codRais;

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
     * Set codRaca
     *
     * @param integer $codRaca
     * @return Raca
     */
    public function setCodRaca($codRaca)
    {
        $this->codRaca = $codRaca;
        return $this;
    }

    /**
     * Get codRaca
     *
     * @return integer
     */
    public function getCodRaca()
    {
        return $this->codRaca;
    }

    /**
     * Set nomRaca
     *
     * @param string $nomRaca
     * @return Raca
     */
    public function setNomRaca($nomRaca)
    {
        $this->nomRaca = $nomRaca;
        return $this;
    }

    /**
     * Get nomRaca
     *
     * @return string
     */
    public function getNomRaca()
    {
        return $this->nomRaca;
    }

    /**
     * Set codRais
     *
     * @param integer $codRais
     * @return Raca
     */
    public function setCodRais($codRais)
    {
        $this->codRais = $codRais;
        return $this;
    }

    /**
     * Get codRais
     *
     * @return integer
     */
    public function getCodRais()
    {
        return $this->codRais;
    }

    /**
     * OneToMany (owning side)
     * Add CseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return Raca
     */
    public function addFkCseCidadoes(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        if (false === $this->fkCseCidadoes->contains($fkCseCidadao)) {
            $fkCseCidadao->setFkCseRaca($this);
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
     * @return Raca
     */
    public function addFkPessoalServidores(\Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor)
    {
        if (false === $this->fkPessoalServidores->contains($fkPessoalServidor)) {
            $fkPessoalServidor->setFkCseRaca($this);
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
