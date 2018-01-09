<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TetoRemuneratorio
 */
class TetoRemuneratorio
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $vigencia;

    /**
     * @var integer
     */
    private $teto;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var integer
     */
    private $codEvento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorioControle
     */
    private $fkTcemgTetoRemuneratorioControle;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vigencia = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return TetoRemuneratorio
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TetoRemuneratorio
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
     * @param \Urbem\CoreBundle\Helper\DatePK $vigencia
     * @return TetoRemuneratorio
     */
    public function setVigencia(\Urbem\CoreBundle\Helper\DatePK $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * Set teto
     *
     * @param integer $teto
     * @return TetoRemuneratorio
     */
    public function setTeto($teto)
    {
        $this->teto = $teto;
        return $this;
    }

    /**
     * Get teto
     *
     * @return integer
     */
    public function getTeto()
    {
        return $this->teto;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return TetoRemuneratorio
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return TetoRemuneratorio
     */
    public function setCodEvento($codEvento = null)
    {
        $this->codEvento = $codEvento;
        return $this;
    }

    /**
     * Get codEvento
     *
     * @return integer
     */
    public function getCodEvento()
    {
        return $this->codEvento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return TetoRemuneratorio
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return TetoRemuneratorio
     */
    public function setFkFolhapagamentoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->codEvento = $fkFolhapagamentoEvento->getCodEvento();
        $this->fkFolhapagamentoEvento = $fkFolhapagamentoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento()
    {
        return $this->fkFolhapagamentoEvento;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgTetoRemuneratorioControle
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorioControle $fkTcemgTetoRemuneratorioControle
     * @return TetoRemuneratorio
     */
    public function setFkTcemgTetoRemuneratorioControle(\Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorioControle $fkTcemgTetoRemuneratorioControle)
    {
        $fkTcemgTetoRemuneratorioControle->setFkTcemgTetoRemuneratorio($this);
        $this->fkTcemgTetoRemuneratorioControle = $fkTcemgTetoRemuneratorioControle;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgTetoRemuneratorioControle
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorioControle
     */
    public function getFkTcemgTetoRemuneratorioControle()
    {
        return $this->fkTcemgTetoRemuneratorioControle;
    }
}
