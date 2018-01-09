<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * PaoPpaAcao
 */
class PaoPpaAcao
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
    private $numPao;

    /**
     * @var integer
     */
    private $codAcao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Pao
     */
    private $fkOrcamentoPao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Acao
     */
    private $fkPpaAcao;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PaoPpaAcao
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
     * Set numPao
     *
     * @param integer $numPao
     * @return PaoPpaAcao
     */
    public function setNumPao($numPao)
    {
        $this->numPao = $numPao;
        return $this;
    }

    /**
     * Get numPao
     *
     * @return integer
     */
    public function getNumPao()
    {
        return $this->numPao;
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return PaoPpaAcao
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao
     * @return PaoPpaAcao
     */
    public function setFkPpaAcao(\Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao)
    {
        $this->codAcao = $fkPpaAcao->getCodAcao();
        $this->fkPpaAcao = $fkPpaAcao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaAcao
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Acao
     */
    public function getFkPpaAcao()
    {
        return $this->fkPpaAcao;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoPao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Pao $fkOrcamentoPao
     * @return PaoPpaAcao
     */
    public function setFkOrcamentoPao(\Urbem\CoreBundle\Entity\Orcamento\Pao $fkOrcamentoPao)
    {
        $this->exercicio = $fkOrcamentoPao->getExercicio();
        $this->numPao = $fkOrcamentoPao->getNumPao();
        $this->fkOrcamentoPao = $fkOrcamentoPao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoPao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Pao
     */
    public function getFkOrcamentoPao()
    {
        return $this->fkOrcamentoPao;
    }
}
