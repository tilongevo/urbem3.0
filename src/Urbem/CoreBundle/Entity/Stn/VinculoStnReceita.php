<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * VinculoStnReceita
 */
class VinculoStnReceita
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
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Stn\TipoVinculoStnReceita
     */
    private $fkStnTipoVinculoStnReceita;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return VinculoStnReceita
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
     * @return VinculoStnReceita
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return VinculoStnReceita
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return VinculoStnReceita
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
     * ManyToOne (inverse side)
     * Set fkStnTipoVinculoStnReceita
     *
     * @param \Urbem\CoreBundle\Entity\Stn\TipoVinculoStnReceita $fkStnTipoVinculoStnReceita
     * @return VinculoStnReceita
     */
    public function setFkStnTipoVinculoStnReceita(\Urbem\CoreBundle\Entity\Stn\TipoVinculoStnReceita $fkStnTipoVinculoStnReceita)
    {
        $this->codTipo = $fkStnTipoVinculoStnReceita->getCodTipo();
        $this->fkStnTipoVinculoStnReceita = $fkStnTipoVinculoStnReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkStnTipoVinculoStnReceita
     *
     * @return \Urbem\CoreBundle\Entity\Stn\TipoVinculoStnReceita
     */
    public function getFkStnTipoVinculoStnReceita()
    {
        return $this->fkStnTipoVinculoStnReceita;
    }
}
