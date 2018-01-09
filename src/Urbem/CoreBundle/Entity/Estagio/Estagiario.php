<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * Estagiario
 */
class Estagiario
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $nomPai;

    /**
     * @var string
     */
    private $nomMae;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    private $fkEstagioEstagiarioEstagios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEstagioEstagiarioEstagios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Estagiario
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set nomPai
     *
     * @param string $nomPai
     * @return Estagiario
     */
    public function setNomPai($nomPai)
    {
        $this->nomPai = $nomPai;
        return $this;
    }

    /**
     * Get nomPai
     *
     * @return string
     */
    public function getNomPai()
    {
        return $this->nomPai;
    }

    /**
     * Set nomMae
     *
     * @param string $nomMae
     * @return Estagiario
     */
    public function setNomMae($nomMae)
    {
        $this->nomMae = $nomMae;
        return $this;
    }

    /**
     * Get nomMae
     *
     * @return string
     */
    public function getNomMae()
    {
        return $this->nomMae;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio
     * @return Estagiario
     */
    public function addFkEstagioEstagiarioEstagios(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio)
    {
        if (false === $this->fkEstagioEstagiarioEstagios->contains($fkEstagioEstagiarioEstagio)) {
            $fkEstagioEstagiarioEstagio->setFkEstagioEstagiario($this);
            $this->fkEstagioEstagiarioEstagios->add($fkEstagioEstagiarioEstagio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio
     */
    public function removeFkEstagioEstagiarioEstagios(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio)
    {
        $this->fkEstagioEstagiarioEstagios->removeElement($fkEstagioEstagiarioEstagio);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioEstagiarioEstagios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    public function getFkEstagioEstagiarioEstagios()
    {
        return $this->fkEstagioEstagiarioEstagios;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Estagiario
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }
}
