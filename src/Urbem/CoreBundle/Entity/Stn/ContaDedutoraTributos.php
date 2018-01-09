<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * ContaDedutoraTributos
 */
class ContaDedutoraTributos
{
    /**
     * PK
     * @var integer
     */
    private $codTributo;

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
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Stn\TributoAnexo8
     */
    private $fkStnTributoAnexo8;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codTributo
     *
     * @param integer $codTributo
     * @return ContaDedutoraTributos
     */
    public function setCodTributo($codTributo)
    {
        $this->codTributo = $codTributo;
        return $this;
    }

    /**
     * Get codTributo
     *
     * @return integer
     */
    public function getCodTributo()
    {
        return $this->codTributo;
    }

    /**
     * Set codReceita
     *
     * @param integer $codReceita
     * @return ContaDedutoraTributos
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
     * @return ContaDedutoraTributos
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ContaDedutoraTributos
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkStnTributoAnexo8
     *
     * @param \Urbem\CoreBundle\Entity\Stn\TributoAnexo8 $fkStnTributoAnexo8
     * @return ContaDedutoraTributos
     */
    public function setFkStnTributoAnexo8(\Urbem\CoreBundle\Entity\Stn\TributoAnexo8 $fkStnTributoAnexo8)
    {
        $this->codTributo = $fkStnTributoAnexo8->getCodTributo();
        $this->fkStnTributoAnexo8 = $fkStnTributoAnexo8;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkStnTributoAnexo8
     *
     * @return \Urbem\CoreBundle\Entity\Stn\TributoAnexo8
     */
    public function getFkStnTributoAnexo8()
    {
        return $this->fkStnTributoAnexo8;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return ContaDedutoraTributos
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
}
