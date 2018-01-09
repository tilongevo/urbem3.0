<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * EntidadeRh
 */
class EntidadeRh
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
    private $schemaCod;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\SchemaRh
     */
    private $fkAdministracaoSchemaRh;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return EntidadeRh
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
     * @return EntidadeRh
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
     * Set schemaCod
     *
     * @param integer $schemaCod
     * @return EntidadeRh
     */
    public function setSchemaCod($schemaCod)
    {
        $this->schemaCod = $schemaCod;
        return $this;
    }

    /**
     * Get schemaCod
     *
     * @return integer
     */
    public function getSchemaCod()
    {
        return $this->schemaCod;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return EntidadeRh
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
     * Set fkAdministracaoSchemaRh
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\SchemaRh $fkAdministracaoSchemaRh
     * @return EntidadeRh
     */
    public function setFkAdministracaoSchemaRh(\Urbem\CoreBundle\Entity\Administracao\SchemaRh $fkAdministracaoSchemaRh)
    {
        $this->schemaCod = $fkAdministracaoSchemaRh->getSchemaCod();
        $this->fkAdministracaoSchemaRh = $fkAdministracaoSchemaRh;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoSchemaRh
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\SchemaRh
     */
    public function getFkAdministracaoSchemaRh()
    {
        return $this->fkAdministracaoSchemaRh;
    }
}
