<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * OcorrenciaDetalhe909910
 */
class OcorrenciaDetalhe909910
{
    /**
     * PK
     * @var integer
     */
    private $numOcorrencia;

    /**
     * @var integer
     */
    private $posicao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ErrosPasep
     */
    private $fkImaErrosPaseps;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaErrosPaseps = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numOcorrencia
     *
     * @param integer $numOcorrencia
     * @return OcorrenciaDetalhe909910
     */
    public function setNumOcorrencia($numOcorrencia)
    {
        $this->numOcorrencia = $numOcorrencia;
        return $this;
    }

    /**
     * Get numOcorrencia
     *
     * @return integer
     */
    public function getNumOcorrencia()
    {
        return $this->numOcorrencia;
    }

    /**
     * Set posicao
     *
     * @param integer $posicao
     * @return OcorrenciaDetalhe909910
     */
    public function setPosicao($posicao)
    {
        $this->posicao = $posicao;
        return $this;
    }

    /**
     * Get posicao
     *
     * @return integer
     */
    public function getPosicao()
    {
        return $this->posicao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return OcorrenciaDetalhe909910
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
     * Add ImaErrosPasep
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ErrosPasep $fkImaErrosPasep
     * @return OcorrenciaDetalhe909910
     */
    public function addFkImaErrosPaseps(\Urbem\CoreBundle\Entity\Ima\ErrosPasep $fkImaErrosPasep)
    {
        if (false === $this->fkImaErrosPaseps->contains($fkImaErrosPasep)) {
            $fkImaErrosPasep->setFkImaOcorrenciaDetalhe909910($this);
            $this->fkImaErrosPaseps->add($fkImaErrosPasep);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaErrosPasep
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ErrosPasep $fkImaErrosPasep
     */
    public function removeFkImaErrosPaseps(\Urbem\CoreBundle\Entity\Ima\ErrosPasep $fkImaErrosPasep)
    {
        $this->fkImaErrosPaseps->removeElement($fkImaErrosPasep);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaErrosPaseps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ErrosPasep
     */
    public function getFkImaErrosPaseps()
    {
        return $this->fkImaErrosPaseps;
    }
}
