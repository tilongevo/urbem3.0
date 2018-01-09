<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorContaSalario
 */
class ContratoServidorContaSalario
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $codAgencia;

    /**
     * @var integer
     */
    private $codBanco;

    /**
     * @var string
     */
    private $nrConta;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    private $fkMonetarioAgencia;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorContaSalario
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
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return ContratoServidorContaSalario
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return ContratoServidorContaSalario
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set nrConta
     *
     * @param string $nrConta
     * @return ContratoServidorContaSalario
     */
    public function setNrConta($nrConta)
    {
        $this->nrConta = $nrConta;
        return $this;
    }

    /**
     * Get nrConta
     *
     * @return string
     */
    public function getNrConta()
    {
        return $this->nrConta;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia
     * @return ContratoServidorContaSalario
     */
    public function setFkMonetarioAgencia(\Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia)
    {
        $this->codBanco = $fkMonetarioAgencia->getCodBanco();
        $this->codAgencia = $fkMonetarioAgencia->getCodAgencia();
        $this->fkMonetarioAgencia = $fkMonetarioAgencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioAgencia
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    public function getFkMonetarioAgencia()
    {
        return $this->fkMonetarioAgencia;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorContaSalario
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
