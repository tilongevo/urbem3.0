<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CasoCausaSubDivisao
 */
class CasoCausaSubDivisao
{
    /**
     * PK
     * @var integer
     */
    private $codSubDivisao;

    /**
     * PK
     * @var integer
     */
    private $codCasoCausa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    private $fkPessoalSubDivisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\CasoCausa
     */
    private $fkPessoalCasoCausa;


    /**
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return CasoCausaSubDivisao
     */
    public function setCodSubDivisao($codSubDivisao)
    {
        $this->codSubDivisao = $codSubDivisao;
        return $this;
    }

    /**
     * Get codSubDivisao
     *
     * @return integer
     */
    public function getCodSubDivisao()
    {
        return $this->codSubDivisao;
    }

    /**
     * Set codCasoCausa
     *
     * @param integer $codCasoCausa
     * @return CasoCausaSubDivisao
     */
    public function setCodCasoCausa($codCasoCausa)
    {
        $this->codCasoCausa = $codCasoCausa;
        return $this;
    }

    /**
     * Get codCasoCausa
     *
     * @return integer
     */
    public function getCodCasoCausa()
    {
        return $this->codCasoCausa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     * @return CasoCausaSubDivisao
     */
    public function setFkPessoalSubDivisao(\Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao)
    {
        $this->codSubDivisao = $fkPessoalSubDivisao->getCodSubDivisao();
        $this->fkPessoalSubDivisao = $fkPessoalSubDivisao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalSubDivisao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    public function getFkPessoalSubDivisao()
    {
        return $this->fkPessoalSubDivisao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CasoCausa $fkPessoalCasoCausa
     * @return CasoCausaSubDivisao
     */
    public function setFkPessoalCasoCausa(\Urbem\CoreBundle\Entity\Pessoal\CasoCausa $fkPessoalCasoCausa)
    {
        $this->codCasoCausa = $fkPessoalCasoCausa->getCodCasoCausa();
        $this->fkPessoalCasoCausa = $fkPessoalCasoCausa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCasoCausa
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\CasoCausa
     */
    public function getFkPessoalCasoCausa()
    {
        return $this->fkPessoalCasoCausa;
    }
}
