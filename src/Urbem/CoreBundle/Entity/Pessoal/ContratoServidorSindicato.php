<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorSindicato
 */
class ContratoServidorSindicato
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $numcgmSindicato;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Sindicato
     */
    private $fkFolhapagamentoSindicato;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorSindicato
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set numcgmSindicato
     *
     * @param integer $numcgmSindicato
     * @return ContratoServidorSindicato
     */
    public function setNumcgmSindicato($numcgmSindicato)
    {
        $this->numcgmSindicato = $numcgmSindicato;
        return $this;
    }

    /**
     * Get numcgmSindicato
     *
     * @return integer
     */
    public function getNumcgmSindicato()
    {
        return $this->numcgmSindicato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoSindicato
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Sindicato $fkFolhapagamentoSindicato
     * @return ContratoServidorSindicato
     */
    public function setFkFolhapagamentoSindicato(\Urbem\CoreBundle\Entity\Folhapagamento\Sindicato $fkFolhapagamentoSindicato)
    {
        $this->numcgmSindicato = $fkFolhapagamentoSindicato->getNumcgm();
        $this->fkFolhapagamentoSindicato = $fkFolhapagamentoSindicato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoSindicato
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Sindicato
     */
    public function getFkFolhapagamentoSindicato()
    {
        return $this->fkFolhapagamentoSindicato;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorSindicato
     */
    public function setFkPessoalContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->codContrato = $fkPessoalContratoServidor->getCodContrato();
        $this->fkPessoalContratoServidor = $fkPessoalContratoServidor;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidor()
    {
        return $this->fkPessoalContratoServidor;
    }
}
