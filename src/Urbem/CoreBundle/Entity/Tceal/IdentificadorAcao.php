<?php
 
namespace Urbem\CoreBundle\Entity\Tceal;

/**
 * IdentificadorAcao
 */
class IdentificadorAcao
{
    /**
     * PK
     * @var integer
     */
    private $codIdentificador;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\AcaoIdentificadorAcao
     */
    private $fkTcealAcaoIdentificadorAcoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcealAcaoIdentificadorAcoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codIdentificador
     *
     * @param integer $codIdentificador
     * @return IdentificadorAcao
     */
    public function setCodIdentificador($codIdentificador)
    {
        $this->codIdentificador = $codIdentificador;
        return $this;
    }

    /**
     * Get codIdentificador
     *
     * @return integer
     */
    public function getCodIdentificador()
    {
        return $this->codIdentificador;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return IdentificadorAcao
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
     * Add TcealAcaoIdentificadorAcao
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\AcaoIdentificadorAcao $fkTcealAcaoIdentificadorAcao
     * @return IdentificadorAcao
     */
    public function addFkTcealAcaoIdentificadorAcoes(\Urbem\CoreBundle\Entity\Tceal\AcaoIdentificadorAcao $fkTcealAcaoIdentificadorAcao)
    {
        if (false === $this->fkTcealAcaoIdentificadorAcoes->contains($fkTcealAcaoIdentificadorAcao)) {
            $fkTcealAcaoIdentificadorAcao->setFkTcealIdentificadorAcao($this);
            $this->fkTcealAcaoIdentificadorAcoes->add($fkTcealAcaoIdentificadorAcao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealAcaoIdentificadorAcao
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\AcaoIdentificadorAcao $fkTcealAcaoIdentificadorAcao
     */
    public function removeFkTcealAcaoIdentificadorAcoes(\Urbem\CoreBundle\Entity\Tceal\AcaoIdentificadorAcao $fkTcealAcaoIdentificadorAcao)
    {
        $this->fkTcealAcaoIdentificadorAcoes->removeElement($fkTcealAcaoIdentificadorAcao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealAcaoIdentificadorAcoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\AcaoIdentificadorAcao
     */
    public function getFkTcealAcaoIdentificadorAcoes()
    {
        return $this->fkTcealAcaoIdentificadorAcoes;
    }
}
