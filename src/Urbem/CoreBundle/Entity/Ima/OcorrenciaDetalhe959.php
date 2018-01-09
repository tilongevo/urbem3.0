<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * OcorrenciaDetalhe959
 */
class OcorrenciaDetalhe959
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ErrosPasep959
     */
    private $fkImaErrosPasep959s;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaErrosPasep959s = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numOcorrencia
     *
     * @param integer $numOcorrencia
     * @return OcorrenciaDetalhe959
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
     * @return OcorrenciaDetalhe959
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
     * @return OcorrenciaDetalhe959
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
     * Add ImaErrosPasep959
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ErrosPasep959 $fkImaErrosPasep959
     * @return OcorrenciaDetalhe959
     */
    public function addFkImaErrosPasep959s(\Urbem\CoreBundle\Entity\Ima\ErrosPasep959 $fkImaErrosPasep959)
    {
        if (false === $this->fkImaErrosPasep959s->contains($fkImaErrosPasep959)) {
            $fkImaErrosPasep959->setFkImaOcorrenciaDetalhe959($this);
            $this->fkImaErrosPasep959s->add($fkImaErrosPasep959);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaErrosPasep959
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ErrosPasep959 $fkImaErrosPasep959
     */
    public function removeFkImaErrosPasep959s(\Urbem\CoreBundle\Entity\Ima\ErrosPasep959 $fkImaErrosPasep959)
    {
        $this->fkImaErrosPasep959s->removeElement($fkImaErrosPasep959);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaErrosPasep959s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ErrosPasep959
     */
    public function getFkImaErrosPasep959s()
    {
        return $this->fkImaErrosPasep959s;
    }
}
