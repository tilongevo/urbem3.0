<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * ConcessaoValeTransporteCalendario
 */
class ConcessaoValeTransporteCalendario
{
    /**
     * PK
     * @var integer
     */
    private $codMes;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codConcessao;

    /**
     * @var integer
     */
    private $codCalendario;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte
     */
    private $fkBeneficioConcessaoValeTransporte;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro
     */
    private $fkCalendarioCalendarioCadastro;


    /**
     * Set codMes
     *
     * @param integer $codMes
     * @return ConcessaoValeTransporteCalendario
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConcessaoValeTransporteCalendario
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
     * Set codConcessao
     *
     * @param integer $codConcessao
     * @return ConcessaoValeTransporteCalendario
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
     * Set codCalendario
     *
     * @param integer $codCalendario
     * @return ConcessaoValeTransporteCalendario
     */
    public function setCodCalendario($codCalendario)
    {
        $this->codCalendario = $codCalendario;
        return $this;
    }

    /**
     * Get codCalendario
     *
     * @return integer
     */
    public function getCodCalendario()
    {
        return $this->codCalendario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCalendarioCalendarioCadastro
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro $fkCalendarioCalendarioCadastro
     * @return ConcessaoValeTransporteCalendario
     */
    public function setFkCalendarioCalendarioCadastro(\Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro $fkCalendarioCalendarioCadastro)
    {
        $this->codCalendario = $fkCalendarioCalendarioCadastro->getCodCalendar();
        $this->fkCalendarioCalendarioCadastro = $fkCalendarioCalendarioCadastro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCalendarioCalendarioCadastro
     *
     * @return \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro
     */
    public function getFkCalendarioCalendarioCadastro()
    {
        return $this->fkCalendarioCalendarioCadastro;
    }

    /**
     * OneToOne (owning side)
     * Set BeneficioConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte
     * @return ConcessaoValeTransporteCalendario
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
     * OneToOne (owning side)
     * Get fkBeneficioConcessaoValeTransporte
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte
     */
    public function getFkBeneficioConcessaoValeTransporte()
    {
        return $this->fkBeneficioConcessaoValeTransporte;
    }
}
