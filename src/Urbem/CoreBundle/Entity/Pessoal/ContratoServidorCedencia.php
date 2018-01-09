<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorCedencia
 */
class ContratoServidorCedencia
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\TipoCedencia
     */
    private $fkPessoalTipoCedencia;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorCedencia
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ContratoServidorCedencia
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
     * Set fkPessoalTipoCedencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TipoCedencia $fkPessoalTipoCedencia
     * @return ContratoServidorCedencia
     */
    public function setFkPessoalTipoCedencia(\Urbem\CoreBundle\Entity\Pessoal\TipoCedencia $fkPessoalTipoCedencia)
    {
        $this->codTipo = $fkPessoalTipoCedencia->getCodTipo();
        $this->fkPessoalTipoCedencia = $fkPessoalTipoCedencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalTipoCedencia
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\TipoCedencia
     */
    public function getFkPessoalTipoCedencia()
    {
        return $this->fkPessoalTipoCedencia;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorCedencia
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
