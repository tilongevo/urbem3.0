<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * OcorrenciaDetalhe910
 */
class OcorrenciaDetalhe910
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ErrosPasep910
     */
    private $fkImaErrosPasep910s;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaErrosPasep910s = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numOcorrencia
     *
     * @param integer $numOcorrencia
     * @return OcorrenciaDetalhe910
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
     * @return OcorrenciaDetalhe910
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
     * @return OcorrenciaDetalhe910
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
     * Add ImaErrosPasep910
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ErrosPasep910 $fkImaErrosPasep910
     * @return OcorrenciaDetalhe910
     */
    public function addFkImaErrosPasep910s(\Urbem\CoreBundle\Entity\Ima\ErrosPasep910 $fkImaErrosPasep910)
    {
        if (false === $this->fkImaErrosPasep910s->contains($fkImaErrosPasep910)) {
            $fkImaErrosPasep910->setFkImaOcorrenciaDetalhe910($this);
            $this->fkImaErrosPasep910s->add($fkImaErrosPasep910);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaErrosPasep910
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ErrosPasep910 $fkImaErrosPasep910
     */
    public function removeFkImaErrosPasep910s(\Urbem\CoreBundle\Entity\Ima\ErrosPasep910 $fkImaErrosPasep910)
    {
        $this->fkImaErrosPasep910s->removeElement($fkImaErrosPasep910);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaErrosPasep910s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ErrosPasep910
     */
    public function getFkImaErrosPasep910s()
    {
        return $this->fkImaErrosPasep910s;
    }
}
