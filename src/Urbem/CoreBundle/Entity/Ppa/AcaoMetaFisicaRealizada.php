<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * AcaoMetaFisicaRealizada
 */
class AcaoMetaFisicaRealizada
{
    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampAcaoDados;

    /**
     * PK
     * @var integer
     */
    private $codRecurso;

    /**
     * PK
     * @var string
     */
    private $exercicioRecurso;

    /**
     * PK
     * @var string
     */
    private $ano;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ppa\AcaoRecurso
     */
    private $fkPpaAcaoRecurso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampAcaoDados = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return AcaoMetaFisicaRealizada
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set timestampAcaoDados
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAcaoDados
     * @return AcaoMetaFisicaRealizada
     */
    public function setTimestampAcaoDados(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAcaoDados)
    {
        $this->timestampAcaoDados = $timestampAcaoDados;
        return $this;
    }

    /**
     * Get timestampAcaoDados
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampAcaoDados()
    {
        return $this->timestampAcaoDados;
    }

    /**
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return AcaoMetaFisicaRealizada
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Set exercicioRecurso
     *
     * @param string $exercicioRecurso
     * @return AcaoMetaFisicaRealizada
     */
    public function setExercicioRecurso($exercicioRecurso)
    {
        $this->exercicioRecurso = $exercicioRecurso;
        return $this;
    }

    /**
     * Get exercicioRecurso
     *
     * @return string
     */
    public function getExercicioRecurso()
    {
        return $this->exercicioRecurso;
    }

    /**
     * Set ano
     *
     * @param string $ano
     * @return AcaoMetaFisicaRealizada
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
     * Set valor
     *
     * @param integer $valor
     * @return AcaoMetaFisicaRealizada
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return AcaoMetaFisicaRealizada
     */
    public function setJustificativa($justificativa = null)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * OneToOne (owning side)
     * Set PpaAcaoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoRecurso $fkPpaAcaoRecurso
     * @return AcaoMetaFisicaRealizada
     */
    public function setFkPpaAcaoRecurso(\Urbem\CoreBundle\Entity\Ppa\AcaoRecurso $fkPpaAcaoRecurso)
    {
        $this->codAcao = $fkPpaAcaoRecurso->getCodAcao();
        $this->timestampAcaoDados = $fkPpaAcaoRecurso->getTimestampAcaoDados();
        $this->codRecurso = $fkPpaAcaoRecurso->getCodRecurso();
        $this->exercicioRecurso = $fkPpaAcaoRecurso->getExercicioRecurso();
        $this->ano = $fkPpaAcaoRecurso->getAno();
        $this->fkPpaAcaoRecurso = $fkPpaAcaoRecurso;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPpaAcaoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\AcaoRecurso
     */
    public function getFkPpaAcaoRecurso()
    {
        return $this->fkPpaAcaoRecurso;
    }
}
