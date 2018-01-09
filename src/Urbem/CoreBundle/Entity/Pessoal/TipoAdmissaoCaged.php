<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * TipoAdmissaoCaged
 */
class TipoAdmissaoCaged
{
    /**
     * PK
     * @var integer
     */
    private $codTipoAdmissao;

    /**
     * PK
     * @var integer
     */
    private $codCaged;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\TipoAdmissao
     */
    private $fkPessoalTipoAdmissao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Caged
     */
    private $fkPessoalCaged;


    /**
     * Set codTipoAdmissao
     *
     * @param integer $codTipoAdmissao
     * @return TipoAdmissaoCaged
     */
    public function setCodTipoAdmissao($codTipoAdmissao)
    {
        $this->codTipoAdmissao = $codTipoAdmissao;
        return $this;
    }

    /**
     * Get codTipoAdmissao
     *
     * @return integer
     */
    public function getCodTipoAdmissao()
    {
        return $this->codTipoAdmissao;
    }

    /**
     * Set codCaged
     *
     * @param integer $codCaged
     * @return TipoAdmissaoCaged
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
     * Set fkPessoalTipoAdmissao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TipoAdmissao $fkPessoalTipoAdmissao
     * @return TipoAdmissaoCaged
     */
    public function setFkPessoalTipoAdmissao(\Urbem\CoreBundle\Entity\Pessoal\TipoAdmissao $fkPessoalTipoAdmissao)
    {
        $this->codTipoAdmissao = $fkPessoalTipoAdmissao->getCodTipoAdmissao();
        $this->fkPessoalTipoAdmissao = $fkPessoalTipoAdmissao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalTipoAdmissao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\TipoAdmissao
     */
    public function getFkPessoalTipoAdmissao()
    {
        return $this->fkPessoalTipoAdmissao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCaged
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Caged $fkPessoalCaged
     * @return TipoAdmissaoCaged
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
