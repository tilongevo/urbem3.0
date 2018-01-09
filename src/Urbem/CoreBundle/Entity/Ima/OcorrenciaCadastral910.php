<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * OcorrenciaCadastral910
 */
class OcorrenciaCadastral910
{
    /**
     * PK
     * @var integer
     */
    private $numOcorrencia;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ErrosCadastraisPasep910
     */
    private $fkImaErrosCadastraisPasep910s;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaErrosCadastraisPasep910s = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numOcorrencia
     *
     * @param integer $numOcorrencia
     * @return OcorrenciaCadastral910
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
     * Set descricao
     *
     * @param string $descricao
     * @return OcorrenciaCadastral910
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
     * Add ImaErrosCadastraisPasep910
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ErrosCadastraisPasep910 $fkImaErrosCadastraisPasep910
     * @return OcorrenciaCadastral910
     */
    public function addFkImaErrosCadastraisPasep910s(\Urbem\CoreBundle\Entity\Ima\ErrosCadastraisPasep910 $fkImaErrosCadastraisPasep910)
    {
        if (false === $this->fkImaErrosCadastraisPasep910s->contains($fkImaErrosCadastraisPasep910)) {
            $fkImaErrosCadastraisPasep910->setFkImaOcorrenciaCadastral910($this);
            $this->fkImaErrosCadastraisPasep910s->add($fkImaErrosCadastraisPasep910);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaErrosCadastraisPasep910
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ErrosCadastraisPasep910 $fkImaErrosCadastraisPasep910
     */
    public function removeFkImaErrosCadastraisPasep910s(\Urbem\CoreBundle\Entity\Ima\ErrosCadastraisPasep910 $fkImaErrosCadastraisPasep910)
    {
        $this->fkImaErrosCadastraisPasep910s->removeElement($fkImaErrosCadastraisPasep910);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaErrosCadastraisPasep910s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ErrosCadastraisPasep910
     */
    public function getFkImaErrosCadastraisPasep910s()
    {
        return $this->fkImaErrosCadastraisPasep910s;
    }
}
