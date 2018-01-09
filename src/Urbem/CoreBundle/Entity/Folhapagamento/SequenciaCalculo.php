<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * SequenciaCalculo
 */
class SequenciaCalculo
{
    /**
     * PK
     * @var integer
     */
    private $codSequencia;

    /**
     * @var integer
     */
    private $sequencia;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $complemento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento
     */
    private $fkFolhapagamentoSequenciaCalculoEventos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoSequenciaCalculoEventos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codSequencia
     *
     * @param integer $codSequencia
     * @return SequenciaCalculo
     */
    public function setCodSequencia($codSequencia)
    {
        $this->codSequencia = $codSequencia;
        return $this;
    }

    /**
     * Get codSequencia
     *
     * @return integer
     */
    public function getCodSequencia()
    {
        return $this->codSequencia;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return SequenciaCalculo
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return SequenciaCalculo
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
     * Set complemento
     *
     * @param string $complemento
     * @return SequenciaCalculo
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoSequenciaCalculoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento $fkFolhapagamentoSequenciaCalculoEvento
     * @return SequenciaCalculo
     */
    public function addFkFolhapagamentoSequenciaCalculoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento $fkFolhapagamentoSequenciaCalculoEvento)
    {
        if (false === $this->fkFolhapagamentoSequenciaCalculoEventos->contains($fkFolhapagamentoSequenciaCalculoEvento)) {
            $fkFolhapagamentoSequenciaCalculoEvento->setFkFolhapagamentoSequenciaCalculo($this);
            $this->fkFolhapagamentoSequenciaCalculoEventos->add($fkFolhapagamentoSequenciaCalculoEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoSequenciaCalculoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento $fkFolhapagamentoSequenciaCalculoEvento
     */
    public function removeFkFolhapagamentoSequenciaCalculoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento $fkFolhapagamentoSequenciaCalculoEvento)
    {
        $this->fkFolhapagamentoSequenciaCalculoEventos->removeElement($fkFolhapagamentoSequenciaCalculoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoSequenciaCalculoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento
     */
    public function getFkFolhapagamentoSequenciaCalculoEventos()
    {
        return $this->fkFolhapagamentoSequenciaCalculoEventos;
    }
}
