<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * MotivoDevolucao
 */
class MotivoDevolucao
{
    /**
     * PK
     * @var integer
     */
    private $codMotivo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $descricaoResumida;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao
     */
    private $fkArrecadacaoCarneDevolucoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoCarneDevolucoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codMotivo
     *
     * @param integer $codMotivo
     * @return MotivoDevolucao
     */
    public function setCodMotivo($codMotivo)
    {
        $this->codMotivo = $codMotivo;
        return $this;
    }

    /**
     * Get codMotivo
     *
     * @return integer
     */
    public function getCodMotivo()
    {
        return $this->codMotivo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return MotivoDevolucao
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
     * Set descricaoResumida
     *
     * @param string $descricaoResumida
     * @return MotivoDevolucao
     */
    public function setDescricaoResumida($descricaoResumida = null)
    {
        $this->descricaoResumida = $descricaoResumida;
        return $this;
    }

    /**
     * Get descricaoResumida
     *
     * @return string
     */
    public function getDescricaoResumida()
    {
        return $this->descricaoResumida;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCarneDevolucao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao $fkArrecadacaoCarneDevolucao
     * @return MotivoDevolucao
     */
    public function addFkArrecadacaoCarneDevolucoes(\Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao $fkArrecadacaoCarneDevolucao)
    {
        if (false === $this->fkArrecadacaoCarneDevolucoes->contains($fkArrecadacaoCarneDevolucao)) {
            $fkArrecadacaoCarneDevolucao->setFkArrecadacaoMotivoDevolucao($this);
            $this->fkArrecadacaoCarneDevolucoes->add($fkArrecadacaoCarneDevolucao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCarneDevolucao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao $fkArrecadacaoCarneDevolucao
     */
    public function removeFkArrecadacaoCarneDevolucoes(\Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao $fkArrecadacaoCarneDevolucao)
    {
        $this->fkArrecadacaoCarneDevolucoes->removeElement($fkArrecadacaoCarneDevolucao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCarneDevolucoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao
     */
    public function getFkArrecadacaoCarneDevolucoes()
    {
        return $this->fkArrecadacaoCarneDevolucoes;
    }
}
