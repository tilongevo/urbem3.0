<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * ProgramaIndicadores
 */
class ProgramaIndicadores
{
    /**
     * PK
     * @var integer
     */
    private $codPrograma;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampProgramaDados;

    /**
     * PK
     * @var integer
     */
    private $codIndicador;

    /**
     * @var integer
     */
    private $codPeriodicidade;

    /**
     * @var integer
     */
    private $codUnidade;

    /**
     * @var integer
     */
    private $codGrandeza;

    /**
     * @var integer
     */
    private $indiceRecente;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $indiceDesejado;

    /**
     * @var string
     */
    private $fonte;

    /**
     * @var string
     */
    private $baseGeografica;

    /**
     * @var string
     */
    private $formaCalculo;

    /**
     * @var \DateTime
     */
    private $dtIndiceRecente;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\ProgramaDados
     */
    private $fkPpaProgramaDados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Periodicidade
     */
    private $fkPpaPeriodicidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    private $fkAdministracaoUnidadeMedida;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampProgramaDados = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->dtIndiceRecente = new \DateTime;
    }

    /**
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return ProgramaIndicadores
     */
    public function setCodPrograma($codPrograma)
    {
        $this->codPrograma = $codPrograma;
        return $this;
    }

    /**
     * Get codPrograma
     *
     * @return integer
     */
    public function getCodPrograma()
    {
        return $this->codPrograma;
    }

    /**
     * Set timestampProgramaDados
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampProgramaDados
     * @return ProgramaIndicadores
     */
    public function setTimestampProgramaDados(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampProgramaDados)
    {
        $this->timestampProgramaDados = $timestampProgramaDados;
        return $this;
    }

    /**
     * Get timestampProgramaDados
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampProgramaDados()
    {
        return $this->timestampProgramaDados;
    }

    /**
     * Set codIndicador
     *
     * @param integer $codIndicador
     * @return ProgramaIndicadores
     */
    public function setCodIndicador($codIndicador)
    {
        $this->codIndicador = $codIndicador;
        return $this;
    }

    /**
     * Get codIndicador
     *
     * @return integer
     */
    public function getCodIndicador()
    {
        return $this->codIndicador;
    }

    /**
     * Set codPeriodicidade
     *
     * @param integer $codPeriodicidade
     * @return ProgramaIndicadores
     */
    public function setCodPeriodicidade($codPeriodicidade)
    {
        $this->codPeriodicidade = $codPeriodicidade;
        return $this;
    }

    /**
     * Get codPeriodicidade
     *
     * @return integer
     */
    public function getCodPeriodicidade()
    {
        return $this->codPeriodicidade;
    }

    /**
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return ProgramaIndicadores
     */
    public function setCodUnidade($codUnidade)
    {
        $this->codUnidade = $codUnidade;
        return $this;
    }

    /**
     * Get codUnidade
     *
     * @return integer
     */
    public function getCodUnidade()
    {
        return $this->codUnidade;
    }

    /**
     * Set codGrandeza
     *
     * @param integer $codGrandeza
     * @return ProgramaIndicadores
     */
    public function setCodGrandeza($codGrandeza)
    {
        $this->codGrandeza = $codGrandeza;
        return $this;
    }

    /**
     * Get codGrandeza
     *
     * @return integer
     */
    public function getCodGrandeza()
    {
        return $this->codGrandeza;
    }

    /**
     * Set indiceRecente
     *
     * @param integer $indiceRecente
     * @return ProgramaIndicadores
     */
    public function setIndiceRecente($indiceRecente)
    {
        $this->indiceRecente = $indiceRecente;
        return $this;
    }

    /**
     * Get indiceRecente
     *
     * @return integer
     */
    public function getIndiceRecente()
    {
        return $this->indiceRecente;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ProgramaIndicadores
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set indiceDesejado
     *
     * @param integer $indiceDesejado
     * @return ProgramaIndicadores
     */
    public function setIndiceDesejado($indiceDesejado = null)
    {
        $this->indiceDesejado = $indiceDesejado;
        return $this;
    }

    /**
     * Get indiceDesejado
     *
     * @return integer
     */
    public function getIndiceDesejado()
    {
        return $this->indiceDesejado;
    }

    /**
     * Set fonte
     *
     * @param string $fonte
     * @return ProgramaIndicadores
     */
    public function setFonte($fonte)
    {
        $this->fonte = $fonte;
        return $this;
    }

    /**
     * Get fonte
     *
     * @return string
     */
    public function getFonte()
    {
        return $this->fonte;
    }

    /**
     * Set baseGeografica
     *
     * @param string $baseGeografica
     * @return ProgramaIndicadores
     */
    public function setBaseGeografica($baseGeografica)
    {
        $this->baseGeografica = $baseGeografica;
        return $this;
    }

    /**
     * Get baseGeografica
     *
     * @return string
     */
    public function getBaseGeografica()
    {
        return $this->baseGeografica;
    }

    /**
     * Set formaCalculo
     *
     * @param string $formaCalculo
     * @return ProgramaIndicadores
     */
    public function setFormaCalculo($formaCalculo)
    {
        $this->formaCalculo = $formaCalculo;
        return $this;
    }

    /**
     * Get formaCalculo
     *
     * @return string
     */
    public function getFormaCalculo()
    {
        return $this->formaCalculo;
    }

    /**
     * Set dtIndiceRecente
     *
     * @param \DateTime $dtIndiceRecente
     * @return ProgramaIndicadores
     */
    public function setDtIndiceRecente(\DateTime $dtIndiceRecente)
    {
        $this->dtIndiceRecente = $dtIndiceRecente;
        return $this;
    }

    /**
     * Get dtIndiceRecente
     *
     * @return \DateTime
     */
    public function getDtIndiceRecente()
    {
        return $this->dtIndiceRecente;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaProgramaDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados
     * @return ProgramaIndicadores
     */
    public function setFkPpaProgramaDados(\Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados)
    {
        $this->codPrograma = $fkPpaProgramaDados->getCodPrograma();
        $this->timestampProgramaDados = $fkPpaProgramaDados->getTimestampProgramaDados();
        $this->fkPpaProgramaDados = $fkPpaProgramaDados;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaProgramaDados
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\ProgramaDados
     */
    public function getFkPpaProgramaDados()
    {
        return $this->fkPpaProgramaDados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaPeriodicidade
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Periodicidade $fkPpaPeriodicidade
     * @return ProgramaIndicadores
     */
    public function setFkPpaPeriodicidade(\Urbem\CoreBundle\Entity\Ppa\Periodicidade $fkPpaPeriodicidade)
    {
        $this->codPeriodicidade = $fkPpaPeriodicidade->getCodPeriodicidade();
        $this->fkPpaPeriodicidade = $fkPpaPeriodicidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaPeriodicidade
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Periodicidade
     */
    public function getFkPpaPeriodicidade()
    {
        return $this->fkPpaPeriodicidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUnidadeMedida
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida
     * @return ProgramaIndicadores
     */
    public function setFkAdministracaoUnidadeMedida(\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida)
    {
        $this->codUnidade = $fkAdministracaoUnidadeMedida->getCodUnidade();
        $this->codGrandeza = $fkAdministracaoUnidadeMedida->getCodGrandeza();
        $this->fkAdministracaoUnidadeMedida = $fkAdministracaoUnidadeMedida;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUnidadeMedida
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    public function getFkAdministracaoUnidadeMedida()
    {
        return $this->fkAdministracaoUnidadeMedida;
    }

    public function __toString()
    {
        return (string) $this->descricao;
    }
}
