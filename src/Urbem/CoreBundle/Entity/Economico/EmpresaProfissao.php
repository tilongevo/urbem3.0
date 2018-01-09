<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * EmpresaProfissao
 */
class EmpresaProfissao
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var integer
     */
    private $codProfissao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Responsavel
     */
    private $fkEconomicoResponsavel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Profissao
     */
    private $fkCseProfissao;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return EmpresaProfissao
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return EmpresaProfissao
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set codProfissao
     *
     * @param integer $codProfissao
     * @return EmpresaProfissao
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
     * Set fkEconomicoResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Responsavel $fkEconomicoResponsavel
     * @return EmpresaProfissao
     */
    public function setFkEconomicoResponsavel(\Urbem\CoreBundle\Entity\Economico\Responsavel $fkEconomicoResponsavel)
    {
        $this->numcgm = $fkEconomicoResponsavel->getNumcgm();
        $this->sequencia = $fkEconomicoResponsavel->getSequencia();
        $this->fkEconomicoResponsavel = $fkEconomicoResponsavel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoResponsavel
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Responsavel
     */
    public function getFkEconomicoResponsavel()
    {
        return $this->fkEconomicoResponsavel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Profissao $fkCseProfissao
     * @return EmpresaProfissao
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
