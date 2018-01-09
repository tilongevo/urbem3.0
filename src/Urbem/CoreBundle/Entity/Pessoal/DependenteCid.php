<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * DependenteCid
 */
class DependenteCid
{
    /**
     * PK
     * @var integer
     */
    private $codDependente;

    /**
     * PK
     * @var integer
     */
    private $codCid;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Dependente
     */
    private $fkPessoalDependente;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cid
     */
    private $fkPessoalCid;


    /**
     * Set codDependente
     *
     * @param integer $codDependente
     * @return DependenteCid
     */
    public function setCodDependente($codDependente)
    {
        $this->codDependente = $codDependente;
        return $this;
    }

    /**
     * Get codDependente
     *
     * @return integer
     */
    public function getCodDependente()
    {
        return $this->codDependente;
    }

    /**
     * Set codCid
     *
     * @param integer $codCid
     * @return DependenteCid
     */
    public function setCodCid($codCid)
    {
        $this->codCid = $codCid;
        return $this;
    }

    /**
     * Get codCid
     *
     * @return integer
     */
    public function getCodCid()
    {
        return $this->codCid;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente
     * @return DependenteCid
     */
    public function setFkPessoalDependente(\Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente)
    {
        $this->codDependente = $fkPessoalDependente->getCodDependente();
        $this->fkPessoalDependente = $fkPessoalDependente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalDependente
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Dependente
     */
    public function getFkPessoalDependente()
    {
        return $this->fkPessoalDependente;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cid $fkPessoalCid
     * @return DependenteCid
     */
    public function setFkPessoalCid(\Urbem\CoreBundle\Entity\Pessoal\Cid $fkPessoalCid)
    {
        $this->codCid = $fkPessoalCid->getCodCid();
        $this->fkPessoalCid = $fkPessoalCid;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCid
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cid
     */
    public function getFkPessoalCid()
    {
        return $this->fkPessoalCid;
    }
}
