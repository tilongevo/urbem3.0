<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * AcaoQuantidade
 */
class AcaoQuantidade
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
     * @var string
     */
    private $ano;

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
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ldo\AcaoValidada
     */
    private $fkLdoAcaoValidada;

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
        $this->timestampAcaoDados = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return AcaoQuantidade
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
     * @return AcaoQuantidade
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
     * Set ano
     *
     * @param string $ano
     * @return AcaoQuantidade
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return AcaoQuantidade
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
     * @return AcaoQuantidade
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
     * Set valor
     *
     * @param integer $valor
     * @return AcaoQuantidade
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return AcaoQuantidade
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
     * OneToOne (inverse side)
     * Set LdoAcaoValidada
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\AcaoValidada $fkLdoAcaoValidada
     * @return AcaoQuantidade
     */
    public function setFkLdoAcaoValidada(\Urbem\CoreBundle\Entity\Ldo\AcaoValidada $fkLdoAcaoValidada)
    {
        $fkLdoAcaoValidada->setFkPpaAcaoQuantidade($this);
        $this->fkLdoAcaoValidada = $fkLdoAcaoValidada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLdoAcaoValidada
     *
     * @return \Urbem\CoreBundle\Entity\Ldo\AcaoValidada
     */
    public function getFkLdoAcaoValidada()
    {
        return $this->fkLdoAcaoValidada;
    }

    /**
     * OneToOne (owning side)
     * Set PpaAcaoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoRecurso $fkPpaAcaoRecurso
     * @return AcaoQuantidade
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
