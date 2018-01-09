<?php
 
namespace Urbem\CoreBundle\Entity\Manad;

/**
 * ReceitaCaracPeculiarReceita
 */
class ReceitaCaracPeculiarReceita
{
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
    private $codCaracteristica;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Manad\CaracPeculiarReceita
     */
    private $fkManadCaracPeculiarReceita;


    /**
     * Set codReceita
     *
     * @param integer $codReceita
     * @return ReceitaCaracPeculiarReceita
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
     * @return ReceitaCaracPeculiarReceita
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
     * Set codCaracteristica
     *
     * @param integer $codCaracteristica
     * @return ReceitaCaracPeculiarReceita
     */
    public function setCodCaracteristica($codCaracteristica)
    {
        $this->codCaracteristica = $codCaracteristica;
        return $this;
    }

    /**
     * Get codCaracteristica
     *
     * @return integer
     */
    public function getCodCaracteristica()
    {
        return $this->codCaracteristica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkManadCaracPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Manad\CaracPeculiarReceita $fkManadCaracPeculiarReceita
     * @return ReceitaCaracPeculiarReceita
     */
    public function setFkManadCaracPeculiarReceita(\Urbem\CoreBundle\Entity\Manad\CaracPeculiarReceita $fkManadCaracPeculiarReceita)
    {
        $this->codCaracteristica = $fkManadCaracPeculiarReceita->getCodCaracteristica();
        $this->fkManadCaracPeculiarReceita = $fkManadCaracPeculiarReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkManadCaracPeculiarReceita
     *
     * @return \Urbem\CoreBundle\Entity\Manad\CaracPeculiarReceita
     */
    public function getFkManadCaracPeculiarReceita()
    {
        return $this->fkManadCaracPeculiarReceita;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return ReceitaCaracPeculiarReceita
     */
    public function setFkOrcamentoReceita(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->exercicio = $fkOrcamentoReceita->getExercicio();
        $this->codReceita = $fkOrcamentoReceita->getCodReceita();
        $this->fkOrcamentoReceita = $fkOrcamentoReceita;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceita()
    {
        return $this->fkOrcamentoReceita;
    }
}
