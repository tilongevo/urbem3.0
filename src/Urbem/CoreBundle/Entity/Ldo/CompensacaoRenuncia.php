<?php
 
namespace Urbem\CoreBundle\Entity\Ldo;

/**
 * CompensacaoRenuncia
 */
class CompensacaoRenuncia
{
    /**
     * PK
     * @var integer
     */
    private $codCompensacao;

    /**
     * PK
     * @var integer
     */
    private $codPpa;

    /**
     * PK
     * @var string
     */
    private $ano;

    /**
     * @var string
     */
    private $tributo;

    /**
     * @var string
     */
    private $modalidade;

    /**
     * @var string
     */
    private $setoresProgramas;

    /**
     * @var integer
     */
    private $valorAnoLdo;

    /**
     * @var integer
     */
    private $valorAnoLdo1;

    /**
     * @var integer
     */
    private $valorAnoLdo2;

    /**
     * @var string
     */
    private $compensacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ldo\Ldo
     */
    private $fkLdoLdo;


    /**
     * Set codCompensacao
     *
     * @param integer $codCompensacao
     * @return CompensacaoRenuncia
     */
    public function setCodCompensacao($codCompensacao)
    {
        $this->codCompensacao = $codCompensacao;
        return $this;
    }

    /**
     * Get codCompensacao
     *
     * @return integer
     */
    public function getCodCompensacao()
    {
        return $this->codCompensacao;
    }

    /**
     * Set codPpa
     *
     * @param integer $codPpa
     * @return CompensacaoRenuncia
     */
    public function setCodPpa($codPpa)
    {
        $this->codPpa = $codPpa;
        return $this;
    }

    /**
     * Get codPpa
     *
     * @return integer
     */
    public function getCodPpa()
    {
        return $this->codPpa;
    }

    /**
     * Set ano
     *
     * @param string $ano
     * @return CompensacaoRenuncia
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
        return $this;
    }

    /**
     * Get ano
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set tributo
     *
     * @param string $tributo
     * @return CompensacaoRenuncia
     */
    public function setTributo($tributo)
    {
        $this->tributo = $tributo;
        return $this;
    }

    /**
     * Get tributo
     *
     * @return string
     */
    public function getTributo()
    {
        return $this->tributo;
    }

    /**
     * Set modalidade
     *
     * @param string $modalidade
     * @return CompensacaoRenuncia
     */
    public function setModalidade($modalidade)
    {
        $this->modalidade = $modalidade;
        return $this;
    }

    /**
     * Get modalidade
     *
     * @return string
     */
    public function getModalidade()
    {
        return $this->modalidade;
    }

    /**
     * Set setoresProgramas
     *
     * @param string $setoresProgramas
     * @return CompensacaoRenuncia
     */
    public function setSetoresProgramas($setoresProgramas)
    {
        $this->setoresProgramas = $setoresProgramas;
        return $this;
    }

    /**
     * Get setoresProgramas
     *
     * @return string
     */
    public function getSetoresProgramas()
    {
        return $this->setoresProgramas;
    }

    /**
     * Set valorAnoLdo
     *
     * @param integer $valorAnoLdo
     * @return CompensacaoRenuncia
     */
    public function setValorAnoLdo($valorAnoLdo = null)
    {
        $this->valorAnoLdo = $valorAnoLdo;
        return $this;
    }

    /**
     * Get valorAnoLdo
     *
     * @return integer
     */
    public function getValorAnoLdo()
    {
        return $this->valorAnoLdo;
    }

    /**
     * Set valorAnoLdo1
     *
     * @param integer $valorAnoLdo1
     * @return CompensacaoRenuncia
     */
    public function setValorAnoLdo1($valorAnoLdo1 = null)
    {
        $this->valorAnoLdo1 = $valorAnoLdo1;
        return $this;
    }

    /**
     * Get valorAnoLdo1
     *
     * @return integer
     */
    public function getValorAnoLdo1()
    {
        return $this->valorAnoLdo1;
    }

    /**
     * Set valorAnoLdo2
     *
     * @param integer $valorAnoLdo2
     * @return CompensacaoRenuncia
     */
    public function setValorAnoLdo2($valorAnoLdo2 = null)
    {
        $this->valorAnoLdo2 = $valorAnoLdo2;
        return $this;
    }

    /**
     * Get valorAnoLdo2
     *
     * @return integer
     */
    public function getValorAnoLdo2()
    {
        return $this->valorAnoLdo2;
    }

    /**
     * Set compensacao
     *
     * @param string $compensacao
     * @return CompensacaoRenuncia
     */
    public function setCompensacao($compensacao)
    {
        $this->compensacao = $compensacao;
        return $this;
    }

    /**
     * Get compensacao
     *
     * @return string
     */
    public function getCompensacao()
    {
        return $this->compensacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLdoLdo
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Ldo $fkLdoLdo
     * @return CompensacaoRenuncia
     */
    public function setFkLdoLdo(\Urbem\CoreBundle\Entity\Ldo\Ldo $fkLdoLdo)
    {
        $this->codPpa = $fkLdoLdo->getCodPpa();
        $this->ano = $fkLdoLdo->getAno();
        $this->fkLdoLdo = $fkLdoLdo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLdoLdo
     *
     * @return \Urbem\CoreBundle\Entity\Ldo\Ldo
     */
    public function getFkLdoLdo()
    {
        return $this->fkLdoLdo;
    }

    /**
     * @return string
     */
    public function getDescricaoPpa()
    {
        $ppa = $this->fkLdoLdo->getFkPpaPpa();

        return sprintf('%s - %s a %s', $this->codPpa, $ppa->getAnoInicio(), $ppa->getAnoFinal());
    }

    /**
     * @return int
     */
    public function getExercicioLdo()
    {
        $anoInicio = (int) $this->fkLdoLdo->getFkPpaPpa()->getAnoInicio();
        $anoFinal = (int) $this->fkLdoLdo->getFkPpaPpa()->getAnoFinal();

        $ano = 1;

        for ($i = $anoInicio; $i <= $anoFinal; $i++) {
            if ($this->getAno() == $ano) {
                return $i;
            }

            $ano++;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codCompensacao;
    }
}
