<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * MembroAdicional
 */
class MembroAdicional
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $codLicitacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $cargo;

    /**
     * @var integer
     */
    private $naturezaCargo = 0;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\NaturezaCargo
     */
    private $fkLicitacaoNaturezaCargo;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return MembroAdicional
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
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return MembroAdicional
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return MembroAdicional
     */
    public function setCodLicitacao($codLicitacao)
    {
        $this->codLicitacao = $codLicitacao;
        return $this;
    }

    /**
     * Get codLicitacao
     *
     * @return integer
     */
    public function getCodLicitacao()
    {
        return $this->codLicitacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return MembroAdicional
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return MembroAdicional
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     * @return MembroAdicional
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set naturezaCargo
     *
     * @param integer $naturezaCargo
     * @return MembroAdicional
     */
    public function setNaturezaCargo($naturezaCargo)
    {
        $this->naturezaCargo = $naturezaCargo;
        return $this;
    }

    /**
     * Get naturezaCargo
     *
     * @return integer
     */
    public function getNaturezaCargo()
    {
        return $this->naturezaCargo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return MembroAdicional
     */
    public function setFkLicitacaoLicitacao(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->codLicitacao = $fkLicitacaoLicitacao->getCodLicitacao();
        $this->codModalidade = $fkLicitacaoLicitacao->getCodModalidade();
        $this->codEntidade = $fkLicitacaoLicitacao->getCodEntidade();
        $this->exercicio = $fkLicitacaoLicitacao->getExercicio();
        $this->fkLicitacaoLicitacao = $fkLicitacaoLicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacao()
    {
        return $this->fkLicitacaoLicitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return MembroAdicional
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
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
     * ManyToOne (inverse side)
     * Set fkLicitacaoNaturezaCargo
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\NaturezaCargo $fkLicitacaoNaturezaCargo
     * @return MembroAdicional
     */
    public function setFkLicitacaoNaturezaCargo(\Urbem\CoreBundle\Entity\Licitacao\NaturezaCargo $fkLicitacaoNaturezaCargo)
    {
        $this->naturezaCargo = $fkLicitacaoNaturezaCargo->getCodigo();
        $this->fkLicitacaoNaturezaCargo = $fkLicitacaoNaturezaCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoNaturezaCargo
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\NaturezaCargo
     */
    public function getFkLicitacaoNaturezaCargo()
    {
        return $this->fkLicitacaoNaturezaCargo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->fkSwCgm} - {$this->cargo} - {$this->fkLicitacaoNaturezaCargo}";
    }
}
