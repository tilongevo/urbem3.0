<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Esfera
 */
class Esfera
{
    /**
     * PK
     * @var integer
     */
    private $codEsfera;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\RecursoDireto
     */
    private $fkOrcamentoRecursoDiretos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoRecursoDiretos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEsfera
     *
     * @param integer $codEsfera
     * @return Esfera
     */
    public function setCodEsfera($codEsfera)
    {
        $this->codEsfera = $codEsfera;
        return $this;
    }

    /**
     * Get codEsfera
     *
     * @return integer
     */
    public function getCodEsfera()
    {
        return $this->codEsfera;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Esfera
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
     * Add OrcamentoRecursoDireto
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\RecursoDireto $fkOrcamentoRecursoDireto
     * @return Esfera
     */
    public function addFkOrcamentoRecursoDiretos(\Urbem\CoreBundle\Entity\Orcamento\RecursoDireto $fkOrcamentoRecursoDireto)
    {
        if (false === $this->fkOrcamentoRecursoDiretos->contains($fkOrcamentoRecursoDireto)) {
            $fkOrcamentoRecursoDireto->setFkAdministracaoEsfera($this);
            $this->fkOrcamentoRecursoDiretos->add($fkOrcamentoRecursoDireto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoRecursoDireto
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\RecursoDireto $fkOrcamentoRecursoDireto
     */
    public function removeFkOrcamentoRecursoDiretos(\Urbem\CoreBundle\Entity\Orcamento\RecursoDireto $fkOrcamentoRecursoDireto)
    {
        $this->fkOrcamentoRecursoDiretos->removeElement($fkOrcamentoRecursoDireto);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoRecursoDiretos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\RecursoDireto
     */
    public function getFkOrcamentoRecursoDiretos()
    {
        return $this->fkOrcamentoRecursoDiretos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->descricao;
    }
}
