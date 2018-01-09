<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * AgentePolitico
 */
class AgentePolitico
{
    /**
     * PK
     * @var integer
     */
    private $codAgentePolitico;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico
     */
    private $fkTcepeCgmAgentePoliticos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepeCgmAgentePoliticos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAgentePolitico
     *
     * @param integer $codAgentePolitico
     * @return AgentePolitico
     */
    public function setCodAgentePolitico($codAgentePolitico)
    {
        $this->codAgentePolitico = $codAgentePolitico;
        return $this;
    }

    /**
     * Get codAgentePolitico
     *
     * @return integer
     */
    public function getCodAgentePolitico()
    {
        return $this->codAgentePolitico;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return AgentePolitico
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
     * Add TcepeCgmAgentePolitico
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico $fkTcepeCgmAgentePolitico
     * @return AgentePolitico
     */
    public function addFkTcepeCgmAgentePoliticos(\Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico $fkTcepeCgmAgentePolitico)
    {
        if (false === $this->fkTcepeCgmAgentePoliticos->contains($fkTcepeCgmAgentePolitico)) {
            $fkTcepeCgmAgentePolitico->setFkTcepeAgentePolitico($this);
            $this->fkTcepeCgmAgentePoliticos->add($fkTcepeCgmAgentePolitico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeCgmAgentePolitico
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico $fkTcepeCgmAgentePolitico
     */
    public function removeFkTcepeCgmAgentePoliticos(\Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico $fkTcepeCgmAgentePolitico)
    {
        $this->fkTcepeCgmAgentePoliticos->removeElement($fkTcepeCgmAgentePolitico);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeCgmAgentePoliticos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\CgmAgentePolitico
     */
    public function getFkTcepeCgmAgentePoliticos()
    {
        return $this->fkTcepeCgmAgentePoliticos;
    }
}
