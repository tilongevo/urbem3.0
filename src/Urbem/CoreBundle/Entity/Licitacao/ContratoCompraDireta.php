<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ContratoCompraDireta
 */
class ContratoCompraDireta
{
    /**
     * PK
     * @var integer
     */
    private $numContrato;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codCompraDireta;

    /**
     * @var integer
     */
    private $codModalidade;

    /**
     * @var string
     */
    private $exercicioCompraDireta;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    private $fkComprasCompraDireta;


    /**
     * Set numContrato
     *
     * @param integer $numContrato
     * @return ContratoCompraDireta
     */
    public function setNumContrato($numContrato)
    {
        $this->numContrato = $numContrato;
        return $this;
    }

    /**
     * Get numContrato
     *
     * @return integer
     */
    public function getNumContrato()
    {
        return $this->numContrato;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ContratoCompraDireta
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContratoCompraDireta
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
     * Set codCompraDireta
     *
     * @param integer $codCompraDireta
     * @return ContratoCompraDireta
     */
    public function setCodCompraDireta($codCompraDireta)
    {
        $this->codCompraDireta = $codCompraDireta;
        return $this;
    }

    /**
     * Get codCompraDireta
     *
     * @return integer
     */
    public function getCodCompraDireta()
    {
        return $this->codCompraDireta;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ContratoCompraDireta
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set exercicioCompraDireta
     *
     * @param string $exercicioCompraDireta
     * @return ContratoCompraDireta
     */
    public function setExercicioCompraDireta($exercicioCompraDireta)
    {
        $this->exercicioCompraDireta = $exercicioCompraDireta;
        return $this;
    }

    /**
     * Get exercicioCompraDireta
     *
     * @return string
     */
    public function getExercicioCompraDireta()
    {
        return $this->exercicioCompraDireta;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     * @return ContratoCompraDireta
     */
    public function setFkComprasCompraDireta(\Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta)
    {
        $this->codCompraDireta = $fkComprasCompraDireta->getCodCompraDireta();
        $this->codEntidade = $fkComprasCompraDireta->getCodEntidade();
        $this->exercicioCompraDireta = $fkComprasCompraDireta->getExercicioEntidade();
        $this->codModalidade = $fkComprasCompraDireta->getCodModalidade();
        $this->fkComprasCompraDireta = $fkComprasCompraDireta;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasCompraDireta
     *
     * @return \Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    public function getFkComprasCompraDireta()
    {
        return $this->fkComprasCompraDireta;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return ContratoCompraDireta
     */
    public function setFkLicitacaoContrato(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->exercicio = $fkLicitacaoContrato->getExercicio();
        $this->codEntidade = $fkLicitacaoContrato->getCodEntidade();
        $this->numContrato = $fkLicitacaoContrato->getNumContrato();
        $this->fkLicitacaoContrato = $fkLicitacaoContrato;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoContrato
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContrato()
    {
        return $this->fkLicitacaoContrato;
    }
}
