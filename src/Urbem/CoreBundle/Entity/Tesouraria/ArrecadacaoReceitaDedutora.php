<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ArrecadacaoReceitaDedutora
 */
class ArrecadacaoReceitaDedutora
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
     * @var integer
     */
    private $codReceitaDedutora;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $vlDeducao = 0;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutoraEstornada
     */
    private $fkTesourariaArrecadacaoReceitaDedutoraEstornadas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita
     */
    private $fkTesourariaArrecadacaoReceita;

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
        $this->fkTesourariaArrecadacaoReceitaDedutoraEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampArrecadacao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codArrecadacao
     *
     * @param integer $codArrecadacao
     * @return ArrecadacaoReceitaDedutora
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
     * @return ArrecadacaoReceitaDedutora
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
     * @return ArrecadacaoReceitaDedutora
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
     * Set codReceitaDedutora
     *
     * @param integer $codReceitaDedutora
     * @return ArrecadacaoReceitaDedutora
     */
    public function setCodReceitaDedutora($codReceitaDedutora)
    {
        $this->codReceitaDedutora = $codReceitaDedutora;
        return $this;
    }

    /**
     * Get codReceitaDedutora
     *
     * @return integer
     */
    public function getCodReceitaDedutora()
    {
        return $this->codReceitaDedutora;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ArrecadacaoReceitaDedutora
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
     * Set vlDeducao
     *
     * @param integer $vlDeducao
     * @return ArrecadacaoReceitaDedutora
     */
    public function setVlDeducao($vlDeducao)
    {
        $this->vlDeducao = $vlDeducao;
        return $this;
    }

    /**
     * Get vlDeducao
     *
     * @return integer
     */
    public function getVlDeducao()
    {
        return $this->vlDeducao;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoReceitaDedutoraEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutoraEstornada $fkTesourariaArrecadacaoReceitaDedutoraEstornada
     * @return ArrecadacaoReceitaDedutora
     */
    public function addFkTesourariaArrecadacaoReceitaDedutoraEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutoraEstornada $fkTesourariaArrecadacaoReceitaDedutoraEstornada)
    {
        if (false === $this->fkTesourariaArrecadacaoReceitaDedutoraEstornadas->contains($fkTesourariaArrecadacaoReceitaDedutoraEstornada)) {
            $fkTesourariaArrecadacaoReceitaDedutoraEstornada->setFkTesourariaArrecadacaoReceitaDedutora($this);
            $this->fkTesourariaArrecadacaoReceitaDedutoraEstornadas->add($fkTesourariaArrecadacaoReceitaDedutoraEstornada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoReceitaDedutoraEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutoraEstornada $fkTesourariaArrecadacaoReceitaDedutoraEstornada
     */
    public function removeFkTesourariaArrecadacaoReceitaDedutoraEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutoraEstornada $fkTesourariaArrecadacaoReceitaDedutoraEstornada)
    {
        $this->fkTesourariaArrecadacaoReceitaDedutoraEstornadas->removeElement($fkTesourariaArrecadacaoReceitaDedutoraEstornada);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoReceitaDedutoraEstornadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutoraEstornada
     */
    public function getFkTesourariaArrecadacaoReceitaDedutoraEstornadas()
    {
        return $this->fkTesourariaArrecadacaoReceitaDedutoraEstornadas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaArrecadacaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita $fkTesourariaArrecadacaoReceita
     * @return ArrecadacaoReceitaDedutora
     */
    public function setFkTesourariaArrecadacaoReceita(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita $fkTesourariaArrecadacaoReceita)
    {
        $this->codArrecadacao = $fkTesourariaArrecadacaoReceita->getCodArrecadacao();
        $this->timestampArrecadacao = $fkTesourariaArrecadacaoReceita->getTimestampArrecadacao();
        $this->codReceita = $fkTesourariaArrecadacaoReceita->getCodReceita();
        $this->exercicio = $fkTesourariaArrecadacaoReceita->getExercicio();
        $this->fkTesourariaArrecadacaoReceita = $fkTesourariaArrecadacaoReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaArrecadacaoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita
     */
    public function getFkTesourariaArrecadacaoReceita()
    {
        return $this->fkTesourariaArrecadacaoReceita;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return ArrecadacaoReceitaDedutora
     */
    public function setFkOrcamentoReceita(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->exercicio = $fkOrcamentoReceita->getExercicio();
        $this->codReceitaDedutora = $fkOrcamentoReceita->getCodReceita();
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
}
