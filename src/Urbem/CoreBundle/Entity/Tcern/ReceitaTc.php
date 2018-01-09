<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * ReceitaTc
 */
class ReceitaTc
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
    private $codReceita;

    /**
     * @var string
     */
    private $codTc;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ReceitaTc
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
     * Set codReceita
     *
     * @param integer $codReceita
     * @return ReceitaTc
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
     * Set codTc
     *
     * @param string $codTc
     * @return ReceitaTc
     */
    public function setCodTc($codTc)
    {
        $this->codTc = $codTc;
        return $this;
    }

    /**
     * Get codTc
     *
     * @return string
     */
    public function getCodTc()
    {
        return $this->codTc;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return ReceitaTc
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
