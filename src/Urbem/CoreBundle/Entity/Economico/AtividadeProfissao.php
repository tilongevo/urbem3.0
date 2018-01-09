<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * AtividadeProfissao
 */
class AtividadeProfissao
{
    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $codProfissao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    private $fkEconomicoAtividade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Profissao
     */
    private $fkCseProfissao;


    /**
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return AtividadeProfissao
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set codProfissao
     *
     * @param integer $codProfissao
     * @return AtividadeProfissao
     */
    public function setCodProfissao($codProfissao)
    {
        $this->codProfissao = $codProfissao;
        return $this;
    }

    /**
     * Get codProfissao
     *
     * @return integer
     */
    public function getCodProfissao()
    {
        return $this->codProfissao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade
     * @return AtividadeProfissao
     */
    public function setFkEconomicoAtividade(\Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade)
    {
        $this->codAtividade = $fkEconomicoAtividade->getCodAtividade();
        $this->fkEconomicoAtividade = $fkEconomicoAtividade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtividade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    public function getFkEconomicoAtividade()
    {
        return $this->fkEconomicoAtividade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Profissao $fkCseProfissao
     * @return AtividadeProfissao
     */
    public function setFkCseProfissao(\Urbem\CoreBundle\Entity\Cse\Profissao $fkCseProfissao)
    {
        $this->codProfissao = $fkCseProfissao->getCodProfissao();
        $this->fkCseProfissao = $fkCseProfissao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseProfissao
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Profissao
     */
    public function getFkCseProfissao()
    {
        return $this->fkCseProfissao;
    }
}
