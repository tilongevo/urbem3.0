<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ArrecadacaoReceita
 */
class ArrecadacaoReceita
{
    /**
     * PK
     * @var integer
     */
    private $codArrecadacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampArrecadacao;

    /**
     * PK
     * @var integer
     */
    private $codReceita;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $vlArrecadacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaReceita
     */
    private $fkTesourariaArrecadacaoEstornadaReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora
     */
    private $fkTesourariaArrecadacaoReceitaDedutoras;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    private $fkTesourariaArrecadacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaArrecadacaoEstornadaReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoReceitaDedutoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampArrecadacao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codArrecadacao
     *
     * @param integer $codArrecadacao
     * @return ArrecadacaoReceita
     */
    public function setCodArrecadacao($codArrecadacao)
    {
        $this->codArrecadacao = $codArrecadacao;
        return $this;
    }

    /**
     * Get codArrecadacao
     *
     * @return integer
     */
    public function getCodArrecadacao()
    {
        return $this->codArrecadacao;
    }

    /**
     * Set timestampArrecadacao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao
     * @return ArrecadacaoReceita
     */
    public function setTimestampArrecadacao(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao)
    {
        $this->timestampArrecadacao = $timestampArrecadacao;
        return $this;
    }

    /**
     * Get timestampArrecadacao
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampArrecadacao()
    {
        return $this->timestampArrecadacao;
    }

    /**
     * Set codReceita
     *
     * @param integer $codReceita
     * @return ArrecadacaoReceita
     */
    public function setCodReceita($codReceita)
    {
        $this->codReceita = $codReceita;
        return $this;
    }

    /**
     * Get codReceita
     *
     * @return integer
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ArrecadacaoReceita
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set vlArrecadacao
     *
     * @param integer $vlArrecadacao
     * @return ArrecadacaoReceita
     */
    public function setVlArrecadacao($vlArrecadacao)
    {
        $this->vlArrecadacao = $vlArrecadacao;
        return $this;
    }

    /**
     * Get vlArrecadacao
     *
     * @return integer
     */
    public function getVlArrecadacao()
    {
        return $this->vlArrecadacao;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoEstornadaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaReceita $fkTesourariaArrecadacaoEstornadaReceita
     * @return ArrecadacaoReceita
     */
    public function addFkTesourariaArrecadacaoEstornadaReceitas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaReceita $fkTesourariaArrecadacaoEstornadaReceita)
    {
        if (false === $this->fkTesourariaArrecadacaoEstornadaReceitas->contains($fkTesourariaArrecadacaoEstornadaReceita)) {
            $fkTesourariaArrecadacaoEstornadaReceita->setFkTesourariaArrecadacaoReceita($this);
            $this->fkTesourariaArrecadacaoEstornadaReceitas->add($fkTesourariaArrecadacaoEstornadaReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoEstornadaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaReceita $fkTesourariaArrecadacaoEstornadaReceita
     */
    public function removeFkTesourariaArrecadacaoEstornadaReceitas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaReceita $fkTesourariaArrecadacaoEstornadaReceita)
    {
        $this->fkTesourariaArrecadacaoEstornadaReceitas->removeElement($fkTesourariaArrecadacaoEstornadaReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoEstornadaReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaReceita
     */
    public function getFkTesourariaArrecadacaoEstornadaReceitas()
    {
        return $this->fkTesourariaArrecadacaoEstornadaReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoReceitaDedutora
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora $fkTesourariaArrecadacaoReceitaDedutora
     * @return ArrecadacaoReceita
     */
    public function addFkTesourariaArrecadacaoReceitaDedutoras(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora $fkTesourariaArrecadacaoReceitaDedutora)
    {
        if (false === $this->fkTesourariaArrecadacaoReceitaDedutoras->contains($fkTesourariaArrecadacaoReceitaDedutora)) {
            $fkTesourariaArrecadacaoReceitaDedutora->setFkTesourariaArrecadacaoReceita($this);
            $this->fkTesourariaArrecadacaoReceitaDedutoras->add($fkTesourariaArrecadacaoReceitaDedutora);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoReceitaDedutora
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora $fkTesourariaArrecadacaoReceitaDedutora
     */
    public function removeFkTesourariaArrecadacaoReceitaDedutoras(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora $fkTesourariaArrecadacaoReceitaDedutora)
    {
        $this->fkTesourariaArrecadacaoReceitaDedutoras->removeElement($fkTesourariaArrecadacaoReceitaDedutora);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoReceitaDedutoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora
     */
    public function getFkTesourariaArrecadacaoReceitaDedutoras()
    {
        return $this->fkTesourariaArrecadacaoReceitaDedutoras;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     * @return ArrecadacaoReceita
     */
    public function setFkTesourariaArrecadacao(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        $this->codArrecadacao = $fkTesourariaArrecadacao->getCodArrecadacao();
        $this->exercicio = $fkTesourariaArrecadacao->getExercicio();
        $this->timestampArrecadacao = $fkTesourariaArrecadacao->getTimestampArrecadacao();
        $this->fkTesourariaArrecadacao = $fkTesourariaArrecadacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaArrecadacao
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    public function getFkTesourariaArrecadacao()
    {
        return $this->fkTesourariaArrecadacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return ArrecadacaoReceita
     */
    public function setFkOrcamentoReceita(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->exercicio = $fkOrcamentoReceita->getExercicio();
        $this->codReceita = $fkOrcamentoReceita->getCodReceita();
        $this->fkOrcamentoReceita = $fkOrcamentoReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceita()
    {
        return $this->fkOrcamentoReceita;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codReceita, $this->fkOrcamentoReceita->getFkOrcamentoContaReceita()->getDescricao());
    }
}
