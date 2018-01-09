<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorEspecialidadeCargo
 */
class ContratoServidorEspecialidadeCargo
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codEspecialidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Especialidade
     */
    private $fkPessoalEspecialidade;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorEspecialidadeCargo
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
     * Set codEspecialidade
     *
     * @param integer $codEspecialidade
     * @return ContratoServidorEspecialidadeCargo
     */
    public function setCodEspecialidade($codEspecialidade)
    {
        $this->codEspecialidade = $codEspecialidade;
        return $this;
    }

    /**
     * Get codEspecialidade
     *
     * @return integer
     */
    public function getCodEspecialidade()
    {
        return $this->codEspecialidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorEspecialidadeCargo
     */
    public function setFkPessoalContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->codContrato = $fkPessoalContratoServidor->getCodContrato();
        $this->fkPessoalContratoServidor = $fkPessoalContratoServidor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidor()
    {
        return $this->fkPessoalContratoServidor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Especialidade $fkPessoalEspecialidade
     * @return ContratoServidorEspecialidadeCargo
     */
    public function setFkPessoalEspecialidade(\Urbem\CoreBundle\Entity\Pessoal\Especialidade $fkPessoalEspecialidade)
    {
        $this->codEspecialidade = $fkPessoalEspecialidade->getCodEspecialidade();
        $this->fkPessoalEspecialidade = $fkPessoalEspecialidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalEspecialidade
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Especialidade
     */
    public function getFkPessoalEspecialidade()
    {
        return $this->fkPessoalEspecialidade;
    }
}
