<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * TransporteEscolar
 */
class TransporteEscolar
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $mes;

    /**
     * PK
     * @var integer
     */
    private $codVeiculo;

    /**
     * PK
     * @var integer
     */
    private $cgmEscola;

    /**
     * @var integer
     */
    private $passageiros = 0;

    /**
     * @var integer
     */
    private $distancia = 0;

    /**
     * @var integer
     */
    private $diasRodados = 0;

    /**
     * @var integer
     */
    private $codTurno = 0;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Mes
     */
    private $fkAdministracaoMes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Escola
     */
    private $fkFrotaEscola;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Turno
     */
    private $fkFrotaTurno;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TransporteEscolar
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
     * Set mes
     *
     * @param integer $mes
     * @return TransporteEscolar
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return TransporteEscolar
     */
    public function setCodVeiculo($codVeiculo)
    {
        $this->codVeiculo = $codVeiculo;
        return $this;
    }

    /**
     * Get codVeiculo
     *
     * @return integer
     */
    public function getCodVeiculo()
    {
        return $this->codVeiculo;
    }

    /**
     * Set cgmEscola
     *
     * @param integer $cgmEscola
     * @return TransporteEscolar
     */
    public function setCgmEscola($cgmEscola)
    {
        $this->cgmEscola = $cgmEscola;
        return $this;
    }

    /**
     * Get cgmEscola
     *
     * @return integer
     */
    public function getCgmEscola()
    {
        return $this->cgmEscola;
    }

    /**
     * Set passageiros
     *
     * @param integer $passageiros
     * @return TransporteEscolar
     */
    public function setPassageiros($passageiros)
    {
        $this->passageiros = $passageiros;
        return $this;
    }

    /**
     * Get passageiros
     *
     * @return integer
     */
    public function getPassageiros()
    {
        return $this->passageiros;
    }

    /**
     * Set distancia
     *
     * @param integer $distancia
     * @return TransporteEscolar
     */
    public function setDistancia($distancia)
    {
        $this->distancia = $distancia;
        return $this;
    }

    /**
     * Get distancia
     *
     * @return integer
     */
    public function getDistancia()
    {
        return $this->distancia;
    }

    /**
     * Set diasRodados
     *
     * @param integer $diasRodados
     * @return TransporteEscolar
     */
    public function setDiasRodados($diasRodados)
    {
        $this->diasRodados = $diasRodados;
        return $this;
    }

    /**
     * Get diasRodados
     *
     * @return integer
     */
    public function getDiasRodados()
    {
        return $this->diasRodados;
    }

    /**
     * Set codTurno
     *
     * @param integer $codTurno
     * @return TransporteEscolar
     */
    public function setCodTurno($codTurno)
    {
        $this->codTurno = $codTurno;
        return $this;
    }

    /**
     * Get codTurno
     *
     * @return integer
     */
    public function getCodTurno()
    {
        return $this->codTurno;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoMes
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Mes $fkAdministracaoMes
     * @return TransporteEscolar
     */
    public function setFkAdministracaoMes(\Urbem\CoreBundle\Entity\Administracao\Mes $fkAdministracaoMes)
    {
        $this->mes = $fkAdministracaoMes->getCodMes();
        $this->fkAdministracaoMes = $fkAdministracaoMes;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoMes
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Mes
     */
    public function getFkAdministracaoMes()
    {
        return $this->fkAdministracaoMes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return TransporteEscolar
     */
    public function setFkFrotaVeiculo(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        $this->codVeiculo = $fkFrotaVeiculo->getCodVeiculo();
        $this->fkFrotaVeiculo = $fkFrotaVeiculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    public function getFkFrotaVeiculo()
    {
        return $this->fkFrotaVeiculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaEscola
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Escola $fkFrotaEscola
     * @return TransporteEscolar
     */
    public function setFkFrotaEscola(\Urbem\CoreBundle\Entity\Frota\Escola $fkFrotaEscola)
    {
        $this->cgmEscola = $fkFrotaEscola->getNumcgm();
        $this->fkFrotaEscola = $fkFrotaEscola;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaEscola
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Escola
     */
    public function getFkFrotaEscola()
    {
        return $this->fkFrotaEscola;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaTurno
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Turno $fkFrotaTurno
     * @return TransporteEscolar
     */
    public function setFkFrotaTurno(\Urbem\CoreBundle\Entity\Frota\Turno $fkFrotaTurno)
    {
        $this->codTurno = $fkFrotaTurno->getCodTurno();
        $this->fkFrotaTurno = $fkFrotaTurno;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaTurno
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Turno
     */
    public function getFkFrotaTurno()
    {
        return $this->fkFrotaTurno;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s / %s / %s / %s',
            $this->exercicio,
            $this->fkAdministracaoMes,
            $this->fkFrotaVeiculo,
            $this->fkFrotaEscola
        );
    }
}
