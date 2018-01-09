<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * InstituicaoEntidade
 */
class InstituicaoEntidade
{
    /**
     * PK
     * @var integer
     */
    private $cgmInstituicao;

    /**
     * PK
     * @var integer
     */
    private $cgmEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino
     */
    private $fkEstagioInstituicaoEnsino;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora
     */
    private $fkEstagioEntidadeIntermediadora;


    /**
     * Set cgmInstituicao
     *
     * @param integer $cgmInstituicao
     * @return InstituicaoEntidade
     */
    public function setCgmInstituicao($cgmInstituicao)
    {
        $this->cgmInstituicao = $cgmInstituicao;
        return $this;
    }

    /**
     * Get cgmInstituicao
     *
     * @return integer
     */
    public function getCgmInstituicao()
    {
        return $this->cgmInstituicao;
    }

    /**
     * Set cgmEntidade
     *
     * @param integer $cgmEntidade
     * @return InstituicaoEntidade
     */
    public function setCgmEntidade($cgmEntidade)
    {
        $this->cgmEntidade = $cgmEntidade;
        return $this;
    }

    /**
     * Get cgmEntidade
     *
     * @return integer
     */
    public function getCgmEntidade()
    {
        return $this->cgmEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioInstituicaoEnsino
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino $fkEstagioInstituicaoEnsino
     * @return InstituicaoEntidade
     */
    public function setFkEstagioInstituicaoEnsino(\Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino $fkEstagioInstituicaoEnsino)
    {
        $this->cgmInstituicao = $fkEstagioInstituicaoEnsino->getNumcgm();
        $this->fkEstagioInstituicaoEnsino = $fkEstagioInstituicaoEnsino;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEstagioInstituicaoEnsino
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino
     */
    public function getFkEstagioInstituicaoEnsino()
    {
        return $this->fkEstagioInstituicaoEnsino;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioEntidadeIntermediadora
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora $fkEstagioEntidadeIntermediadora
     * @return InstituicaoEntidade
     */
    public function setFkEstagioEntidadeIntermediadora(\Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora $fkEstagioEntidadeIntermediadora)
    {
        $this->cgmEntidade = $fkEstagioEntidadeIntermediadora->getNumcgm();
        $this->fkEstagioEntidadeIntermediadora = $fkEstagioEntidadeIntermediadora;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEstagioEntidadeIntermediadora
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora
     */
    public function getFkEstagioEntidadeIntermediadora()
    {
        return $this->fkEstagioEntidadeIntermediadora;
    }
}
