<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * EditalImpugnado
 */
class EditalImpugnado
{
    /**
     * PK
     * @var integer
     */
    private $numEdital;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var string
     */
    private $exercicioProcesso;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\AnulacaoImpugnacaoEdital
     */
    private $fkLicitacaoAnulacaoImpugnacaoEdital;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    private $fkLicitacaoEdital;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;


    /**
     * Set numEdital
     *
     * @param integer $numEdital
     * @return EditalImpugnado
     */
    public function setNumEdital($numEdital)
    {
        $this->numEdital = $numEdital;
        return $this;
    }

    /**
     * Get numEdital
     *
     * @return integer
     */
    public function getNumEdital()
    {
        return $this->numEdital;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return EditalImpugnado
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
     * Set exercicioProcesso
     *
     * @param string $exercicioProcesso
     * @return EditalImpugnado
     */
    public function setExercicioProcesso($exercicioProcesso)
    {
        $this->exercicioProcesso = $exercicioProcesso;
        return $this;
    }

    /**
     * Get exercicioProcesso
     *
     * @return string
     */
    public function getExercicioProcesso()
    {
        return $this->exercicioProcesso;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return EditalImpugnado
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital
     * @return EditalImpugnado
     */
    public function setFkLicitacaoEdital(\Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital)
    {
        $this->numEdital = $fkLicitacaoEdital->getNumEdital();
        $this->exercicio = $fkLicitacaoEdital->getExercicio();
        $this->fkLicitacaoEdital = $fkLicitacaoEdital;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoEdital
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    public function getFkLicitacaoEdital()
    {
        return $this->fkLicitacaoEdital;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return EditalImpugnado
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->exercicioProcesso = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoAnulacaoImpugnacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\AnulacaoImpugnacaoEdital $fkLicitacaoAnulacaoImpugnacaoEdital
     * @return EditalImpugnado
     */
    public function setFkLicitacaoAnulacaoImpugnacaoEdital(\Urbem\CoreBundle\Entity\Licitacao\AnulacaoImpugnacaoEdital $fkLicitacaoAnulacaoImpugnacaoEdital)
    {
        $fkLicitacaoAnulacaoImpugnacaoEdital->setFkLicitacaoEditalImpugnado($this);
        $this->fkLicitacaoAnulacaoImpugnacaoEdital = $fkLicitacaoAnulacaoImpugnacaoEdital;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoAnulacaoImpugnacaoEdital
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\AnulacaoImpugnacaoEdital
     */
    public function getFkLicitacaoAnulacaoImpugnacaoEdital()
    {
        return $this->fkLicitacaoAnulacaoImpugnacaoEdital;
    }
}
