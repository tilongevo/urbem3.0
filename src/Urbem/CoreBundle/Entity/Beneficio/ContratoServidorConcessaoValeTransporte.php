<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * ContratoServidorConcessaoValeTransporte
 */
class ContratoServidorConcessaoValeTransporte
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
    private $codMes;

    /**
     * PK
     * @var integer
     */
    private $codConcessao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte
     */
    private $fkBeneficioConcessaoValeTransporte;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorConcessaoValeTransporte
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
     * Set codMes
     *
     * @param integer $codMes
     * @return ContratoServidorConcessaoValeTransporte
     */
    public function setCodMes($codMes)
    {
        $this->codMes = $codMes;
        return $this;
    }

    /**
     * Get codMes
     *
     * @return integer
     */
    public function getCodMes()
    {
        return $this->codMes;
    }

    /**
     * Set codConcessao
     *
     * @param integer $codConcessao
     * @return ContratoServidorConcessaoValeTransporte
     */
    public function setCodConcessao($codConcessao)
    {
        $this->codConcessao = $codConcessao;
        return $this;
    }

    /**
     * Get codConcessao
     *
     * @return integer
     */
    public function getCodConcessao()
    {
        return $this->codConcessao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContratoServidorConcessaoValeTransporte
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
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return ContratoServidorConcessaoValeTransporte
     */
    public function setVigencia(\DateTime $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorConcessaoValeTransporte
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
     * Set fkBeneficioConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte
     * @return ContratoServidorConcessaoValeTransporte
     */
    public function setFkBeneficioConcessaoValeTransporte(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte)
    {
        $this->codConcessao = $fkBeneficioConcessaoValeTransporte->getCodConcessao();
        $this->codMes = $fkBeneficioConcessaoValeTransporte->getCodMes();
        $this->exercicio = $fkBeneficioConcessaoValeTransporte->getExercicio();
        $this->fkBeneficioConcessaoValeTransporte = $fkBeneficioConcessaoValeTransporte;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioConcessaoValeTransporte
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte
     */
    public function getFkBeneficioConcessaoValeTransporte()
    {
        return $this->fkBeneficioConcessaoValeTransporte;
    }
}
