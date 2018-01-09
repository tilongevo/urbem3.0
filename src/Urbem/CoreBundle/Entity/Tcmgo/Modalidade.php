<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * Modalidade
 */
class Modalidade
{
    /**
     * PK
     * @var string
     */
    private $codModalidade;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade
     */
    private $fkTcmgoEmpenhoModalidades;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoEmpenhoModalidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModalidade
     *
     * @param string $codModalidade
     * @return Modalidade
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return string
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Modalidade
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
     * Add TcmgoEmpenhoModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade $fkTcmgoEmpenhoModalidade
     * @return Modalidade
     */
    public function addFkTcmgoEmpenhoModalidades(\Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade $fkTcmgoEmpenhoModalidade)
    {
        if (false === $this->fkTcmgoEmpenhoModalidades->contains($fkTcmgoEmpenhoModalidade)) {
            $fkTcmgoEmpenhoModalidade->setFkTcmgoModalidade($this);
            $this->fkTcmgoEmpenhoModalidades->add($fkTcmgoEmpenhoModalidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoEmpenhoModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade $fkTcmgoEmpenhoModalidade
     */
    public function removeFkTcmgoEmpenhoModalidades(\Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade $fkTcmgoEmpenhoModalidade)
    {
        $this->fkTcmgoEmpenhoModalidades->removeElement($fkTcmgoEmpenhoModalidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoEmpenhoModalidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade
     */
    public function getFkTcmgoEmpenhoModalidades()
    {
        return $this->fkTcmgoEmpenhoModalidades;
    }
}
