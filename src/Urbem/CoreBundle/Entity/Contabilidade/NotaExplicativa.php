<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * NotaExplicativa
 */
class NotaExplicativa
{
    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtInicial;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtFinal;

    /**
     * @var string
     */
    private $notaExplicativa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Rota
     */
    private $fkContabilidadeNotaExplicativaRota;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtInicial = new \Urbem\CoreBundle\Helper\DatePK;
        $this->dtFinal = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return NotaExplicativa
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
     * Set dtInicial
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInicial
     * @return NotaExplicativa
     */
    public function setDtInicial(\Urbem\CoreBundle\Helper\DatePK $dtInicial)
    {
        $this->dtInicial = $dtInicial;
        return $this;
    }

    /**
     * Get dtInicial
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtInicial()
    {
        return $this->dtInicial;
    }

    /**
     * Set dtFinal
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtFinal
     * @return NotaExplicativa
     */
    public function setDtFinal(\Urbem\CoreBundle\Helper\DatePK $dtFinal)
    {
        $this->dtFinal = $dtFinal;
        return $this;
    }

    /**
     * Get dtFinal
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtFinal()
    {
        return $this->dtFinal;
    }

    /**
     * Set notaExplicativa
     *
     * @param string $notaExplicativa
     * @return NotaExplicativa
     */
    public function setNotaExplicativa($notaExplicativa)
    {
        $this->notaExplicativa = $notaExplicativa;
        return $this;
    }

    /**
     * Get notaExplicativa
     *
     * @return string
     */
    public function getNotaExplicativa()
    {
        return $this->notaExplicativa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeNotaExplicativaRota
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\NotaExplicativaRota $fkContabilidadeNotaExplicativaRota
     * @return NotaExplicativa
     */
    public function setFkContabilidadeNotaExplicativaRota(\Urbem\CoreBundle\Entity\Administracao\Rota $fkContabilidadeNotaExplicativaRota)
    {
        $this->codAcao = $fkContabilidadeNotaExplicativaRota->getCodRota();
        $this->fkContabilidadeNotaExplicativaRota = $fkContabilidadeNotaExplicativaRota;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeNotaExplicativaRota
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\NotaExplicativaRota
     */
    public function getFkContabilidadeNotaExplicativaRota()
    {
        return $this->fkContabilidadeNotaExplicativaRota;
    }
}
