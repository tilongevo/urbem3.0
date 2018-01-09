<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorConselho
 */
class ContratoServidorConselho
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $codConselho;

    /**
     * @var \DateTime
     */
    private $dtValidade;

    /**
     * @var string
     */
    private $nrConselho;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Conselho
     */
    private $fkPessoalConselho;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorConselho
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
     * Set codConselho
     *
     * @param integer $codConselho
     * @return ContratoServidorConselho
     */
    public function setCodConselho($codConselho)
    {
        $this->codConselho = $codConselho;
        return $this;
    }

    /**
     * Get codConselho
     *
     * @return integer
     */
    public function getCodConselho()
    {
        return $this->codConselho;
    }

    /**
     * Set dtValidade
     *
     * @param \DateTime $dtValidade
     * @return ContratoServidorConselho
     */
    public function setDtValidade(\DateTime $dtValidade)
    {
        $this->dtValidade = $dtValidade;
        return $this;
    }

    /**
     * Get dtValidade
     *
     * @return \DateTime
     */
    public function getDtValidade()
    {
        return $this->dtValidade;
    }

    /**
     * Set nrConselho
     *
     * @param string $nrConselho
     * @return ContratoServidorConselho
     */
    public function setNrConselho($nrConselho)
    {
        $this->nrConselho = $nrConselho;
        return $this;
    }

    /**
     * Get nrConselho
     *
     * @return string
     */
    public function getNrConselho()
    {
        return $this->nrConselho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalConselho
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Conselho $fkPessoalConselho
     * @return ContratoServidorConselho
     */
    public function setFkPessoalConselho(\Urbem\CoreBundle\Entity\Pessoal\Conselho $fkPessoalConselho)
    {
        $this->codConselho = $fkPessoalConselho->getCodConselho();
        $this->fkPessoalConselho = $fkPessoalConselho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalConselho
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Conselho
     */
    public function getFkPessoalConselho()
    {
        return $this->fkPessoalConselho;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorConselho
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
