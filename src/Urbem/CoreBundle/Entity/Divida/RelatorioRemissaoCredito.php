<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * RelatorioRemissaoCredito
 */
class RelatorioRemissaoCredito
{
    /**
     * PK
     * @var integer
     */
    private $codLancamento;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento
     */
    private $fkArrecadacaoLancamento;


    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return RelatorioRemissaoCredito
     */
    public function setCodLancamento($codLancamento)
    {
        $this->codLancamento = $codLancamento;
        return $this;
    }

    /**
     * Get codLancamento
     *
     * @return integer
     */
    public function getCodLancamento()
    {
        return $this->codLancamento;
    }

    /**
     * OneToOne (owning side)
     * Set ArrecadacaoLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento $fkArrecadacaoLancamento
     * @return RelatorioRemissaoCredito
     */
    public function setFkArrecadacaoLancamento(\Urbem\CoreBundle\Entity\Arrecadacao\Lancamento $fkArrecadacaoLancamento)
    {
        $this->codLancamento = $fkArrecadacaoLancamento->getCodLancamento();
        $this->fkArrecadacaoLancamento = $fkArrecadacaoLancamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento
     */
    public function getFkArrecadacaoLancamento()
    {
        return $this->fkArrecadacaoLancamento;
    }
}
