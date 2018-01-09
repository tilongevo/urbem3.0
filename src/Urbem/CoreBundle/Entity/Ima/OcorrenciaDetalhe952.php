<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * OcorrenciaDetalhe952
 */
class OcorrenciaDetalhe952
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ErrosPasep952
     */
    private $fkImaErrosPasep952s;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaErrosPasep952s = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numOcorrencia
     *
     * @param integer $numOcorrencia
     * @return OcorrenciaDetalhe952
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
     * @return OcorrenciaDetalhe952
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
     * @return OcorrenciaDetalhe952
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
     * Add ImaErrosPasep952
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ErrosPasep952 $fkImaErrosPasep952
     * @return OcorrenciaDetalhe952
     */
    public function addFkImaErrosPasep952s(\Urbem\CoreBundle\Entity\Ima\ErrosPasep952 $fkImaErrosPasep952)
    {
        if (false === $this->fkImaErrosPasep952s->contains($fkImaErrosPasep952)) {
            $fkImaErrosPasep952->setFkImaOcorrenciaDetalhe952($this);
            $this->fkImaErrosPasep952s->add($fkImaErrosPasep952);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaErrosPasep952
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ErrosPasep952 $fkImaErrosPasep952
     */
    public function removeFkImaErrosPasep952s(\Urbem\CoreBundle\Entity\Ima\ErrosPasep952 $fkImaErrosPasep952)
    {
        $this->fkImaErrosPasep952s->removeElement($fkImaErrosPasep952);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaErrosPasep952s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ErrosPasep952
     */
    public function getFkImaErrosPasep952s()
    {
        return $this->fkImaErrosPasep952s;
    }
}
