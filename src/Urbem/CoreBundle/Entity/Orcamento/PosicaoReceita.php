<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * PosicaoReceita
 */
class PosicaoReceita
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codPosicao;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $mascara;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita
     */
    private $fkOrcamentoClassificacaoReceitas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\TipoContaReceita
     */
    private $fkOrcamentoTipoContaReceita;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoClassificacaoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PosicaoReceita
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
     * Set codPosicao
     *
     * @param integer $codPosicao
     * @return PosicaoReceita
     */
    public function setCodPosicao($codPosicao)
    {
        $this->codPosicao = $codPosicao;
        return $this;
    }

    /**
     * Get codPosicao
     *
     * @return integer
     */
    public function getCodPosicao()
    {
        return $this->codPosicao;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return PosicaoReceita
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set mascara
     *
     * @param string $mascara
     * @return PosicaoReceita
     */
    public function setMascara($mascara)
    {
        $this->mascara = $mascara;
        return $this;
    }

    /**
     * Get mascara
     *
     * @return string
     */
    public function getMascara()
    {
        return $this->mascara;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoClassificacaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita $fkOrcamentoClassificacaoReceita
     * @return PosicaoReceita
     */
    public function addFkOrcamentoClassificacaoReceitas(\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita $fkOrcamentoClassificacaoReceita)
    {
        if (false === $this->fkOrcamentoClassificacaoReceitas->contains($fkOrcamentoClassificacaoReceita)) {
            $fkOrcamentoClassificacaoReceita->setFkOrcamentoPosicaoReceita($this);
            $this->fkOrcamentoClassificacaoReceitas->add($fkOrcamentoClassificacaoReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoClassificacaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita $fkOrcamentoClassificacaoReceita
     */
    public function removeFkOrcamentoClassificacaoReceitas(\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita $fkOrcamentoClassificacaoReceita)
    {
        $this->fkOrcamentoClassificacaoReceitas->removeElement($fkOrcamentoClassificacaoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoClassificacaoReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita
     */
    public function getFkOrcamentoClassificacaoReceitas()
    {
        return $this->fkOrcamentoClassificacaoReceitas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoTipoContaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\TipoContaReceita $fkOrcamentoTipoContaReceita
     * @return PosicaoReceita
     */
    public function setFkOrcamentoTipoContaReceita(\Urbem\CoreBundle\Entity\Orcamento\TipoContaReceita $fkOrcamentoTipoContaReceita)
    {
        $this->codTipo = $fkOrcamentoTipoContaReceita->getCodTipo();
        $this->fkOrcamentoTipoContaReceita = $fkOrcamentoTipoContaReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoTipoContaReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\TipoContaReceita
     */
    public function getFkOrcamentoTipoContaReceita()
    {
        return $this->fkOrcamentoTipoContaReceita;
    }
}
