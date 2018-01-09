<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * Nota
 */
class Nota
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var integer
     */
    private $valorNota;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa
     */
    private $fkArrecadacaoNotaAvulsa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\NotaFiscal
     */
    private $fkArrecadacaoNotaFiscal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\NotaServico
     */
    private $fkArrecadacaoNotaServicos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoNotaServicos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return Nota
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set valorNota
     *
     * @param integer $valorNota
     * @return Nota
     */
    public function setValorNota($valorNota)
    {
        $this->valorNota = $valorNota;
        return $this;
    }

    /**
     * Get valorNota
     *
     * @return integer
     */
    public function getValorNota()
    {
        return $this->valorNota;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoNotaServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaServico $fkArrecadacaoNotaServico
     * @return Nota
     */
    public function addFkArrecadacaoNotaServicos(\Urbem\CoreBundle\Entity\Arrecadacao\NotaServico $fkArrecadacaoNotaServico)
    {
        if (false === $this->fkArrecadacaoNotaServicos->contains($fkArrecadacaoNotaServico)) {
            $fkArrecadacaoNotaServico->setFkArrecadacaoNota($this);
            $this->fkArrecadacaoNotaServicos->add($fkArrecadacaoNotaServico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoNotaServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaServico $fkArrecadacaoNotaServico
     */
    public function removeFkArrecadacaoNotaServicos(\Urbem\CoreBundle\Entity\Arrecadacao\NotaServico $fkArrecadacaoNotaServico)
    {
        $this->fkArrecadacaoNotaServicos->removeElement($fkArrecadacaoNotaServico);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoNotaServicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\NotaServico
     */
    public function getFkArrecadacaoNotaServicos()
    {
        return $this->fkArrecadacaoNotaServicos;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoNotaAvulsa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa
     * @return Nota
     */
    public function setFkArrecadacaoNotaAvulsa(\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa)
    {
        $fkArrecadacaoNotaAvulsa->setFkArrecadacaoNota($this);
        $this->fkArrecadacaoNotaAvulsa = $fkArrecadacaoNotaAvulsa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoNotaAvulsa
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa
     */
    public function getFkArrecadacaoNotaAvulsa()
    {
        return $this->fkArrecadacaoNotaAvulsa;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoNotaFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaFiscal $fkArrecadacaoNotaFiscal
     * @return Nota
     */
    public function setFkArrecadacaoNotaFiscal(\Urbem\CoreBundle\Entity\Arrecadacao\NotaFiscal $fkArrecadacaoNotaFiscal)
    {
        $fkArrecadacaoNotaFiscal->setFkArrecadacaoNota($this);
        $this->fkArrecadacaoNotaFiscal = $fkArrecadacaoNotaFiscal;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoNotaFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\NotaFiscal
     */
    public function getFkArrecadacaoNotaFiscal()
    {
        return $this->fkArrecadacaoNotaFiscal;
    }
}
