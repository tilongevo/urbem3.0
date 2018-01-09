<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * AcaoRecurso
 */
class AcaoRecurso
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
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ppa\AcaoMetaFisicaRealizada
     */
    private $fkPpaAcaoMetaFisicaRealizada;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ppa\AcaoQuantidade
     */
    private $fkPpaAcaoQuantidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    private $fkPpaAcaoDados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    private $fkOrcamentoRecurso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampAcaoDados = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return AcaoRecurso
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
     * @return AcaoRecurso
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
     * @return AcaoRecurso
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
     * @return AcaoRecurso
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
     * @return AcaoRecurso
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
     * @return AcaoRecurso
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
     * ManyToOne (inverse side)
     * Set fkPpaAcaoDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados
     * @return AcaoRecurso
     */
    public function setFkPpaAcaoDados(\Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados)
    {
        $this->codAcao = $fkPpaAcaoDados->getCodAcao();
        $this->timestampAcaoDados = $fkPpaAcaoDados->getTimestampAcaoDados();
        $this->fkPpaAcaoDados = $fkPpaAcaoDados;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaAcaoDados
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    public function getFkPpaAcaoDados()
    {
        return $this->fkPpaAcaoDados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso
     * @return AcaoRecurso
     */
    public function setFkOrcamentoRecurso(\Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso)
    {
        $this->exercicioRecurso = $fkOrcamentoRecurso->getExercicio();
        $this->codRecurso = $fkOrcamentoRecurso->getCodRecurso();
        $this->fkOrcamentoRecurso = $fkOrcamentoRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    public function getFkOrcamentoRecurso()
    {
        return $this->fkOrcamentoRecurso;
    }

    /**
     * OneToOne (inverse side)
     * Set PpaAcaoMetaFisicaRealizada
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoMetaFisicaRealizada $fkPpaAcaoMetaFisicaRealizada
     * @return AcaoRecurso
     */
    public function setFkPpaAcaoMetaFisicaRealizada(\Urbem\CoreBundle\Entity\Ppa\AcaoMetaFisicaRealizada $fkPpaAcaoMetaFisicaRealizada)
    {
        $fkPpaAcaoMetaFisicaRealizada->setFkPpaAcaoRecurso($this);
        $this->fkPpaAcaoMetaFisicaRealizada = $fkPpaAcaoMetaFisicaRealizada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPpaAcaoMetaFisicaRealizada
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\AcaoMetaFisicaRealizada
     */
    public function getFkPpaAcaoMetaFisicaRealizada()
    {
        return $this->fkPpaAcaoMetaFisicaRealizada;
    }

    /**
     * OneToOne (inverse side)
     * Set PpaAcaoQuantidade
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoQuantidade $fkPpaAcaoQuantidade
     * @return AcaoRecurso
     */
    public function setFkPpaAcaoQuantidade(\Urbem\CoreBundle\Entity\Ppa\AcaoQuantidade $fkPpaAcaoQuantidade)
    {
        $fkPpaAcaoQuantidade->setFkPpaAcaoRecurso($this);
        $this->fkPpaAcaoQuantidade = $fkPpaAcaoQuantidade;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPpaAcaoQuantidade
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\AcaoQuantidade
     */
    public function getFkPpaAcaoQuantidade()
    {
        return $this->fkPpaAcaoQuantidade;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s/%s', $this->codAcao, $this->codRecurso, $this->exercicioRecurso);
    }
}
