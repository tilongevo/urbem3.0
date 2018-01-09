<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ArquivoCodigoVantagensDescontos
 */
class ArquivoCodigoVantagensDescontos
{
    /**
     * PK
     * @var string
     */
    private $codVantagemDesconto;

    /**
     * @var string
     */
    private $periodo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;


    /**
     * Set codVantagemDesconto
     *
     * @param string $codVantagemDesconto
     * @return ArquivoCodigoVantagensDescontos
     */
    public function setCodVantagemDesconto($codVantagemDesconto)
    {
        $this->codVantagemDesconto = $codVantagemDesconto;
        return $this;
    }

    /**
     * Get codVantagemDesconto
     *
     * @return string
     */
    public function getCodVantagemDesconto()
    {
        return $this->codVantagemDesconto;
    }

    /**
     * Set periodo
     *
     * @param string $periodo
     * @return ArquivoCodigoVantagensDescontos
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
        return $this;
    }

    /**
     * Get periodo
     *
     * @return string
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return ArquivoCodigoVantagensDescontos
     */
    public function setFkFolhapagamentoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->codVantagemDesconto = $fkFolhapagamentoEvento->getCodigo();
        $this->fkFolhapagamentoEvento = $fkFolhapagamentoEvento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento()
    {
        return $this->fkFolhapagamentoEvento;
    }
}
