<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * VinculoRecurso
 */
class VinculoRecurso
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * PK
     * @var integer
     */
    private $numUnidade;

    /**
     * PK
     * @var integer
     */
    private $codRecurso;

    /**
     * PK
     * @var integer
     */
    private $codVinculo;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    private $fkOrcamentoRecurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Stn\VinculoStnRecurso
     */
    private $fkStnVinculoStnRecurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Stn\TipoVinculoRecurso
     */
    private $fkStnTipoVinculoRecurso;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return VinculoRecurso
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return VinculoRecurso
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
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return VinculoRecurso
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
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return VinculoRecurso
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return VinculoRecurso
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
     * Set codVinculo
     *
     * @param integer $codVinculo
     * @return VinculoRecurso
     */
    public function setCodVinculo($codVinculo)
    {
        $this->codVinculo = $codVinculo;
        return $this;
    }

    /**
     * Get codVinculo
     *
     * @return integer
     */
    public function getCodVinculo()
    {
        return $this->codVinculo;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return VinculoRecurso
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return VinculoRecurso
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
     * Set fkOrcamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso
     * @return VinculoRecurso
     */
    public function setFkOrcamentoRecurso(\Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso)
    {
        $this->exercicio = $fkOrcamentoRecurso->getExercicio();
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return VinculoRecurso
     */
    public function setFkOrcamentoUnidade(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->exercicio = $fkOrcamentoUnidade->getExercicio();
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
     * ManyToOne (inverse side)
     * Set fkStnVinculoStnRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoStnRecurso $fkStnVinculoStnRecurso
     * @return VinculoRecurso
     */
    public function setFkStnVinculoStnRecurso(\Urbem\CoreBundle\Entity\Stn\VinculoStnRecurso $fkStnVinculoStnRecurso)
    {
        $this->codVinculo = $fkStnVinculoStnRecurso->getCodVinculo();
        $this->fkStnVinculoStnRecurso = $fkStnVinculoStnRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkStnVinculoStnRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Stn\VinculoStnRecurso
     */
    public function getFkStnVinculoStnRecurso()
    {
        return $this->fkStnVinculoStnRecurso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkStnTipoVinculoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Stn\TipoVinculoRecurso $fkStnTipoVinculoRecurso
     * @return VinculoRecurso
     */
    public function setFkStnTipoVinculoRecurso(\Urbem\CoreBundle\Entity\Stn\TipoVinculoRecurso $fkStnTipoVinculoRecurso)
    {
        $this->codTipo = $fkStnTipoVinculoRecurso->getCodTipo();
        $this->fkStnTipoVinculoRecurso = $fkStnTipoVinculoRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkStnTipoVinculoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Stn\TipoVinculoRecurso
     */
    public function getFkStnTipoVinculoRecurso()
    {
        return $this->fkStnTipoVinculoRecurso;
    }
}
