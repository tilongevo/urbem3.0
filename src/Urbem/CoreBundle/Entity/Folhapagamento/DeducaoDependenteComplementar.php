<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * DeducaoDependenteComplementar
 */
class DeducaoDependenteComplementar
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codComplementar;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente
     */
    private $fkFolhapagamentoDeducaoDependente;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Complementar
     */
    private $fkFolhapagamentoComplementar;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return DeducaoDependenteComplementar
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return DeducaoDependenteComplementar
     */
    public function setCodPeriodoMovimentacao($codPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $codPeriodoMovimentacao;
        return $this;
    }

    /**
     * Get codPeriodoMovimentacao
     *
     * @return integer
     */
    public function getCodPeriodoMovimentacao()
    {
        return $this->codPeriodoMovimentacao;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return DeducaoDependenteComplementar
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
     * Set codComplementar
     *
     * @param integer $codComplementar
     * @return DeducaoDependenteComplementar
     */
    public function setCodComplementar($codComplementar)
    {
        $this->codComplementar = $codComplementar;
        return $this;
    }

    /**
     * Get codComplementar
     *
     * @return integer
     */
    public function getCodComplementar()
    {
        return $this->codComplementar;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Complementar $fkFolhapagamentoComplementar
     * @return DeducaoDependenteComplementar
     */
    public function setFkFolhapagamentoComplementar(\Urbem\CoreBundle\Entity\Folhapagamento\Complementar $fkFolhapagamentoComplementar)
    {
        $this->codComplementar = $fkFolhapagamentoComplementar->getCodComplementar();
        $this->codPeriodoMovimentacao = $fkFolhapagamentoComplementar->getCodPeriodoMovimentacao();
        $this->fkFolhapagamentoComplementar = $fkFolhapagamentoComplementar;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoComplementar
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Complementar
     */
    public function getFkFolhapagamentoComplementar()
    {
        return $this->fkFolhapagamentoComplementar;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoDeducaoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente
     * @return DeducaoDependenteComplementar
     */
    public function setFkFolhapagamentoDeducaoDependente(\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente)
    {
        $this->numcgm = $fkFolhapagamentoDeducaoDependente->getNumcgm();
        $this->codPeriodoMovimentacao = $fkFolhapagamentoDeducaoDependente->getCodPeriodoMovimentacao();
        $this->codTipo = $fkFolhapagamentoDeducaoDependente->getCodTipo();
        $this->fkFolhapagamentoDeducaoDependente = $fkFolhapagamentoDeducaoDependente;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoDeducaoDependente
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente
     */
    public function getFkFolhapagamentoDeducaoDependente()
    {
        return $this->fkFolhapagamentoDeducaoDependente;
    }
}
