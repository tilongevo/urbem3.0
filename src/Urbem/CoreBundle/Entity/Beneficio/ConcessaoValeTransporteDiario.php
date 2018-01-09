<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * ConcessaoValeTransporteDiario
 */
class ConcessaoValeTransporteDiario
{
    /**
     * PK
     * @var integer
     */
    private $codConcessao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtDia;

    /**
     * PK
     * @var integer
     */
    private $codMes;

    /**
     * PK
     * @var integer
     */
    private $codDia;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var boolean
     */
    private $obrigatorio = false;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal
     */
    private $fkBeneficioConcessaoValeTransporteSemanal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtDia = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codConcessao
     *
     * @param integer $codConcessao
     * @return ConcessaoValeTransporteDiario
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
     * Set dtDia
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtDia
     * @return ConcessaoValeTransporteDiario
     */
    public function setDtDia(\Urbem\CoreBundle\Helper\DatePK $dtDia)
    {
        $this->dtDia = $dtDia;
        return $this;
    }

    /**
     * Get dtDia
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtDia()
    {
        return $this->dtDia;
    }

    /**
     * Set codMes
     *
     * @param integer $codMes
     * @return ConcessaoValeTransporteDiario
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
     * Set codDia
     *
     * @param integer $codDia
     * @return ConcessaoValeTransporteDiario
     */
    public function setCodDia($codDia)
    {
        $this->codDia = $codDia;
        return $this;
    }

    /**
     * Get codDia
     *
     * @return integer
     */
    public function getCodDia()
    {
        return $this->codDia;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConcessaoValeTransporteDiario
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
     * Set obrigatorio
     *
     * @param boolean $obrigatorio
     * @return ConcessaoValeTransporteDiario
     */
    public function setObrigatorio($obrigatorio)
    {
        $this->obrigatorio = $obrigatorio;
        return $this;
    }

    /**
     * Get obrigatorio
     *
     * @return boolean
     */
    public function getObrigatorio()
    {
        return $this->obrigatorio;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return ConcessaoValeTransporteDiario
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkBeneficioConcessaoValeTransporteSemanal
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal $fkBeneficioConcessaoValeTransporteSemanal
     * @return ConcessaoValeTransporteDiario
     */
    public function setFkBeneficioConcessaoValeTransporteSemanal(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal $fkBeneficioConcessaoValeTransporteSemanal)
    {
        $this->codDia = $fkBeneficioConcessaoValeTransporteSemanal->getCodDia();
        $this->codMes = $fkBeneficioConcessaoValeTransporteSemanal->getCodMes();
        $this->codConcessao = $fkBeneficioConcessaoValeTransporteSemanal->getCodConcessao();
        $this->exercicio = $fkBeneficioConcessaoValeTransporteSemanal->getExercicio();
        $this->fkBeneficioConcessaoValeTransporteSemanal = $fkBeneficioConcessaoValeTransporteSemanal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioConcessaoValeTransporteSemanal
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal
     */
    public function getFkBeneficioConcessaoValeTransporteSemanal()
    {
        return $this->fkBeneficioConcessaoValeTransporteSemanal;
    }
}
