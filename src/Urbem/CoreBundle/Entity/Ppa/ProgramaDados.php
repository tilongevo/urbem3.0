<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * ProgramaDados
 */
class ProgramaDados
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
     * @var integer
     */
    private $codTipoPrograma;

    /**
     * @var string
     */
    private $identificacao;

    /**
     * @var string
     */
    private $diagnostico;

    /**
     * @var string
     */
    private $objetivo;

    /**
     * @var string
     */
    private $diretriz;

    /**
     * @var boolean
     */
    private $continuo = true;

    /**
     * @var string
     */
    private $publicoAlvo;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var string
     */
    private $exercicioUnidade;

    /**
     * @var integer
     */
    private $numUnidade;

    /**
     * @var integer
     */
    private $numOrgao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ppa\ProgramaTemporarioVigencia
     */
    private $fkPpaProgramaTemporarioVigencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaNorma
     */
    private $fkPpaProgramaNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores
     */
    private $fkPpaProgramaIndicadoreses;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Programa
     */
    private $fkPpaPrograma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\TipoPrograma
     */
    private $fkPpaTipoPrograma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPpaProgramaNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaProgramaIndicadoreses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampProgramaDados = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK();
    }

    /**
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return ProgramaDados
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
     * @return ProgramaDados
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
     * Set codTipoPrograma
     *
     * @param integer $codTipoPrograma
     * @return ProgramaDados
     */
    public function setCodTipoPrograma($codTipoPrograma)
    {
        $this->codTipoPrograma = $codTipoPrograma;
        return $this;
    }

    /**
     * Get codTipoPrograma
     *
     * @return integer
     */
    public function getCodTipoPrograma()
    {
        return $this->codTipoPrograma;
    }

    /**
     * Set identificacao
     *
     * @param string $identificacao
     * @return ProgramaDados
     */
    public function setIdentificacao($identificacao)
    {
        $this->identificacao = $identificacao;
        return $this;
    }

    /**
     * Get identificacao
     *
     * @return string
     */
    public function getIdentificacao()
    {
        return $this->identificacao;
    }

    /**
     * Set diagnostico
     *
     * @param string $diagnostico
     * @return ProgramaDados
     */
    public function setDiagnostico($diagnostico)
    {
        $this->diagnostico = $diagnostico;
        return $this;
    }

    /**
     * Get diagnostico
     *
     * @return string
     */
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    /**
     * Set objetivo
     *
     * @param string $objetivo
     * @return ProgramaDados
     */
    public function setObjetivo($objetivo)
    {
        $this->objetivo = $objetivo;
        return $this;
    }

    /**
     * Get objetivo
     *
     * @return string
     */
    public function getObjetivo()
    {
        return $this->objetivo;
    }

    /**
     * Set diretriz
     *
     * @param string $diretriz
     * @return ProgramaDados
     */
    public function setDiretriz($diretriz)
    {
        $this->diretriz = $diretriz;
        return $this;
    }

    /**
     * Get diretriz
     *
     * @return string
     */
    public function getDiretriz()
    {
        return $this->diretriz;
    }

    /**
     * Set continuo
     *
     * @param boolean $continuo
     * @return ProgramaDados
     */
    public function setContinuo($continuo)
    {
        $this->continuo = $continuo;
        return $this;
    }

    /**
     * Get continuo
     *
     * @return boolean
     */
    public function getContinuo()
    {
        return $this->continuo;
    }

    /**
     * Set publicoAlvo
     *
     * @param string $publicoAlvo
     * @return ProgramaDados
     */
    public function setPublicoAlvo($publicoAlvo = null)
    {
        $this->publicoAlvo = $publicoAlvo;
        return $this;
    }

    /**
     * Get publicoAlvo
     *
     * @return string
     */
    public function getPublicoAlvo()
    {
        return $this->publicoAlvo;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return ProgramaDados
     */
    public function setJustificativa($justificativa)
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
     * Set exercicioUnidade
     *
     * @param string $exercicioUnidade
     * @return ProgramaDados
     */
    public function setExercicioUnidade($exercicioUnidade)
    {
        $this->exercicioUnidade = $exercicioUnidade;
        return $this;
    }

    /**
     * Get exercicioUnidade
     *
     * @return string
     */
    public function getExercicioUnidade()
    {
        return $this->exercicioUnidade;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return ProgramaDados
     */
    public function setNumUnidade($numUnidade)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return ProgramaDados
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * OneToMany (owning side)
     * Add PpaProgramaNorma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaNorma $fkPpaProgramaNorma
     * @return ProgramaDados
     */
    public function addFkPpaProgramaNormas(\Urbem\CoreBundle\Entity\Ppa\ProgramaNorma $fkPpaProgramaNorma)
    {
        if (false === $this->fkPpaProgramaNormas->contains($fkPpaProgramaNorma)) {
            $fkPpaProgramaNorma->setFkPpaProgramaDados($this);
            $this->fkPpaProgramaNormas->add($fkPpaProgramaNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaProgramaNorma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaNorma $fkPpaProgramaNorma
     */
    public function removeFkPpaProgramaNormas(\Urbem\CoreBundle\Entity\Ppa\ProgramaNorma $fkPpaProgramaNorma)
    {
        $this->fkPpaProgramaNormas->removeElement($fkPpaProgramaNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaProgramaNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaNorma
     */
    public function getFkPpaProgramaNormas()
    {
        return $this->fkPpaProgramaNormas;
    }

    /**
     * @param $fkPpaProgramaNormas
     */
    public function setFkPpaProgramaNormas($fkPpaProgramaNormas)
    {
        $this->fkPpaProgramaNormas = $fkPpaProgramaNormas;
    }

    /**
     * OneToMany (owning side)
     * Add PpaProgramaIndicadores
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores $fkPpaProgramaIndicadores
     * @return ProgramaDados
     */
    public function addFkPpaProgramaIndicadoreses(\Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores $fkPpaProgramaIndicadores)
    {
        if (false === $this->fkPpaProgramaIndicadoreses->contains($fkPpaProgramaIndicadores)) {
            $fkPpaProgramaIndicadores->setFkPpaProgramaDados($this);
            $this->fkPpaProgramaIndicadoreses->add($fkPpaProgramaIndicadores);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaProgramaIndicadores
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores $fkPpaProgramaIndicadores
     */
    public function removeFkPpaProgramaIndicadoreses(\Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores $fkPpaProgramaIndicadores)
    {
        $this->fkPpaProgramaIndicadoreses->removeElement($fkPpaProgramaIndicadores);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaProgramaIndicadoreses
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores
     */
    public function getFkPpaProgramaIndicadoreses()
    {
        return $this->fkPpaProgramaIndicadoreses;
    }

    /**
     * @param $fkPpaProgramaIndicadores
     */
    public function setFkPpaProgramaIndicadoreses($fkPpaProgramaIndicadores)
    {
        $this->fkPpaProgramaIndicadoreses = $fkPpaProgramaIndicadores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Programa $fkPpaPrograma
     * @return ProgramaDados
     */
    public function setFkPpaPrograma(\Urbem\CoreBundle\Entity\Ppa\Programa $fkPpaPrograma)
    {
        $this->codPrograma = $fkPpaPrograma->getCodPrograma();
        $this->fkPpaPrograma = $fkPpaPrograma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaPrograma
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Programa
     */
    public function getFkPpaPrograma()
    {
        return $this->fkPpaPrograma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaTipoPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\TipoPrograma $fkPpaTipoPrograma
     * @return ProgramaDados
     */
    public function setFkPpaTipoPrograma(\Urbem\CoreBundle\Entity\Ppa\TipoPrograma $fkPpaTipoPrograma)
    {
        $this->codTipoPrograma = $fkPpaTipoPrograma->getCodTipoPrograma();
        $this->fkPpaTipoPrograma = $fkPpaTipoPrograma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaTipoPrograma
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\TipoPrograma
     */
    public function getFkPpaTipoPrograma()
    {
        return $this->fkPpaTipoPrograma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return ProgramaDados
     */
    public function setFkOrcamentoUnidade(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->exercicioUnidade = $fkOrcamentoUnidade->getExercicio();
        $this->numUnidade = $fkOrcamentoUnidade->getNumUnidade();
        $this->numOrgao = $fkOrcamentoUnidade->getNumOrgao();
        $this->fkOrcamentoUnidade = $fkOrcamentoUnidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoUnidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function getFkOrcamentoUnidade()
    {
        return $this->fkOrcamentoUnidade;
    }

    /**
     * OneToOne (inverse side)
     * Set PpaProgramaTemporarioVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaTemporarioVigencia $fkPpaProgramaTemporarioVigencia
     * @return ProgramaDados
     */
    public function setFkPpaProgramaTemporarioVigencia(\Urbem\CoreBundle\Entity\Ppa\ProgramaTemporarioVigencia $fkPpaProgramaTemporarioVigencia)
    {
        $fkPpaProgramaTemporarioVigencia->setFkPpaProgramaDados($this);
        $this->fkPpaProgramaTemporarioVigencia = $fkPpaProgramaTemporarioVigencia;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPpaProgramaTemporarioVigencia
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\ProgramaTemporarioVigencia
     */
    public function getFkPpaProgramaTemporarioVigencia()
    {
        return $this->fkPpaProgramaTemporarioVigencia;
    }
}
