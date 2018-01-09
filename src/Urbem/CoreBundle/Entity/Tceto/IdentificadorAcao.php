<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\AcaoIdentificadorAcao
     */
    private $fkTcetoAcaoIdentificadorAcoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcetoAcaoIdentificadorAcoes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcetoAcaoIdentificadorAcao
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\AcaoIdentificadorAcao $fkTcetoAcaoIdentificadorAcao
     * @return IdentificadorAcao
     */
    public function addFkTcetoAcaoIdentificadorAcoes(\Urbem\CoreBundle\Entity\Tceto\AcaoIdentificadorAcao $fkTcetoAcaoIdentificadorAcao)
    {
        if (false === $this->fkTcetoAcaoIdentificadorAcoes->contains($fkTcetoAcaoIdentificadorAcao)) {
            $fkTcetoAcaoIdentificadorAcao->setFkTcetoIdentificadorAcao($this);
            $this->fkTcetoAcaoIdentificadorAcoes->add($fkTcetoAcaoIdentificadorAcao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoAcaoIdentificadorAcao
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\AcaoIdentificadorAcao $fkTcetoAcaoIdentificadorAcao
     */
    public function removeFkTcetoAcaoIdentificadorAcoes(\Urbem\CoreBundle\Entity\Tceto\AcaoIdentificadorAcao $fkTcetoAcaoIdentificadorAcao)
    {
        $this->fkTcetoAcaoIdentificadorAcoes->removeElement($fkTcetoAcaoIdentificadorAcao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoAcaoIdentificadorAcoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\AcaoIdentificadorAcao
     */
    public function getFkTcetoAcaoIdentificadorAcoes()
    {
        return $this->fkTcetoAcaoIdentificadorAcoes;
    }
}
