<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CausaRescisaoCaged
 */
class CausaRescisaoCaged
{
    /**
     * PK
     * @var integer
     */
    private $codCausaRescisao;

    /**
     * PK
     * @var integer
     */
    private $codCaged;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\CausaRescisao
     */
    private $fkPessoalCausaRescisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Caged
     */
    private $fkPessoalCaged;


    /**
     * Set codCausaRescisao
     *
     * @param integer $codCausaRescisao
     * @return CausaRescisaoCaged
     */
    public function setCodCausaRescisao($codCausaRescisao)
    {
        $this->codCausaRescisao = $codCausaRescisao;
        return $this;
    }

    /**
     * Get codCausaRescisao
     *
     * @return integer
     */
    public function getCodCausaRescisao()
    {
        return $this->codCausaRescisao;
    }

    /**
     * Set codCaged
     *
     * @param integer $codCaged
     * @return CausaRescisaoCaged
     */
    public function setCodCaged($codCaged)
    {
        $this->codCaged = $codCaged;
        return $this;
    }

    /**
     * Get codCaged
     *
     * @return integer
     */
    public function getCodCaged()
    {
        return $this->codCaged;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCausaRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao
     * @return CausaRescisaoCaged
     */
    public function setFkPessoalCausaRescisao(\Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao)
    {
        $this->codCausaRescisao = $fkPessoalCausaRescisao->getCodCausaRescisao();
        $this->fkPessoalCausaRescisao = $fkPessoalCausaRescisao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCausaRescisao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\CausaRescisao
     */
    public function getFkPessoalCausaRescisao()
    {
        return $this->fkPessoalCausaRescisao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCaged
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Caged $fkPessoalCaged
     * @return CausaRescisaoCaged
     */
    public function setFkPessoalCaged(\Urbem\CoreBundle\Entity\Pessoal\Caged $fkPessoalCaged)
    {
        $this->codCaged = $fkPessoalCaged->getCodCaged();
        $this->fkPessoalCaged = $fkPessoalCaged;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCaged
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Caged
     */
    public function getFkPessoalCaged()
    {
        return $this->fkPessoalCaged;
    }
}
