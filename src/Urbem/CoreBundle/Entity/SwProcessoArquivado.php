<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwProcessoArquivado
 */
class SwProcessoArquivado
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * @var integer
     */
    private $codHistorico;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampArquivamento;

    /**
     * @var string
     */
    private $textoComplementar;

    /**
     * @var integer
     */
    private $cgmArquivador;

    /**
     * @var string
     */
    private $localizacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwHistoricoArquivamento
     */
    private $fkSwHistoricoArquivamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampArquivamento = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwProcessoArquivado
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return SwProcessoArquivado
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return SwProcessoArquivado
     */
    public function setCodHistorico($codHistorico)
    {
        $this->codHistorico = $codHistorico;
        return $this;
    }

    /**
     * Get codHistorico
     *
     * @return integer
     */
    public function getCodHistorico()
    {
        return $this->codHistorico;
    }

    /**
     * Set timestampArquivamento
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArquivamento
     * @return SwProcessoArquivado
     */
    public function setTimestampArquivamento(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArquivamento)
    {
        $this->timestampArquivamento = $timestampArquivamento;
        return $this;
    }

    /**
     * Get timestampArquivamento
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampArquivamento()
    {
        return $this->timestampArquivamento;
    }

    /**
     * Set textoComplementar
     *
     * @param string $textoComplementar
     * @return SwProcessoArquivado
     */
    public function setTextoComplementar($textoComplementar = null)
    {
        $this->textoComplementar = $textoComplementar;
        return $this;
    }

    /**
     * Get textoComplementar
     *
     * @return string
     */
    public function getTextoComplementar()
    {
        return $this->textoComplementar;
    }

    /**
     * Set cgmArquivador
     *
     * @param integer $cgmArquivador
     * @return SwProcessoArquivado
     */
    public function setCgmArquivador($cgmArquivador)
    {
        $this->cgmArquivador = $cgmArquivador;
        return $this;
    }

    /**
     * Get cgmArquivador
     *
     * @return integer
     */
    public function getCgmArquivador()
    {
        return $this->cgmArquivador;
    }

    /**
     * Set localizacao
     *
     * @param string $localizacao
     * @return SwProcessoArquivado
     */
    public function setLocalizacao($localizacao = null)
    {
        $this->localizacao = $localizacao;
        return $this;
    }

    /**
     * Get localizacao
     *
     * @return string
     */
    public function getLocalizacao()
    {
        return $this->localizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwHistoricoArquivamento
     *
     * @param \Urbem\CoreBundle\Entity\SwHistoricoArquivamento $fkSwHistoricoArquivamento
     * @return SwProcessoArquivado
     */
    public function setFkSwHistoricoArquivamento(\Urbem\CoreBundle\Entity\SwHistoricoArquivamento $fkSwHistoricoArquivamento)
    {
        $this->codHistorico = $fkSwHistoricoArquivamento->getCodHistorico();
        $this->fkSwHistoricoArquivamento = $fkSwHistoricoArquivamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwHistoricoArquivamento
     *
     * @return \Urbem\CoreBundle\Entity\SwHistoricoArquivamento
     */
    public function getFkSwHistoricoArquivamento()
    {
        return $this->fkSwHistoricoArquivamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return SwProcessoArquivado
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmArquivador = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * OneToOne (owning side)
     * Set SwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return SwProcessoArquivado
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }
}
