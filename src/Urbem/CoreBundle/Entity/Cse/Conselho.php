<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * Conselho
 */
class Conselho
{
    /**
     * PK
     * @var integer
     */
    private $codConselho;

    /**
     * @var string
     */
    private $nomConselho;

    /**
     * @var string
     */
    private $nomRegistro;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Profissao
     */
    private $fkCseProfissoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseProfissoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConselho
     *
     * @param integer $codConselho
     * @return Conselho
     */
    public function setCodConselho($codConselho)
    {
        $this->codConselho = $codConselho;
        return $this;
    }

    /**
     * Get codConselho
     *
     * @return integer
     */
    public function getCodConselho()
    {
        return $this->codConselho;
    }

    /**
     * Set nomConselho
     *
     * @param string $nomConselho
     * @return Conselho
     */
    public function setNomConselho($nomConselho)
    {
        $this->nomConselho = $nomConselho;
        return $this;
    }

    /**
     * Get nomConselho
     *
     * @return string
     */
    public function getNomConselho()
    {
        return $this->nomConselho;
    }

    /**
     * Set nomRegistro
     *
     * @param string $nomRegistro
     * @return Conselho
     */
    public function setNomRegistro($nomRegistro)
    {
        $this->nomRegistro = $nomRegistro;
        return $this;
    }

    /**
     * Get nomRegistro
     *
     * @return string
     */
    public function getNomRegistro()
    {
        return $this->nomRegistro;
    }

    /**
     * OneToMany (owning side)
     * Add CseProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Profissao $fkCseProfissao
     * @return Conselho
     */
    public function addFkCseProfissoes(\Urbem\CoreBundle\Entity\Cse\Profissao $fkCseProfissao)
    {
        if (false === $this->fkCseProfissoes->contains($fkCseProfissao)) {
            $fkCseProfissao->setFkCseConselho($this);
            $this->fkCseProfissoes->add($fkCseProfissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Profissao $fkCseProfissao
     */
    public function removeFkCseProfissoes(\Urbem\CoreBundle\Entity\Cse\Profissao $fkCseProfissao)
    {
        $this->fkCseProfissoes->removeElement($fkCseProfissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseProfissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Profissao
     */
    public function getFkCseProfissoes()
    {
        return $this->fkCseProfissoes;
    }
}
