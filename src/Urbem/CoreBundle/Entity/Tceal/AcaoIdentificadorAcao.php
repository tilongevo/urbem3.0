<?php
 
namespace Urbem\CoreBundle\Entity\Tceal;

/**
 * AcaoIdentificadorAcao
 */
class AcaoIdentificadorAcao
{
    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * @var integer
     */
    private $codIdentificador;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ppa\Acao
     */
    private $fkPpaAcao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceal\IdentificadorAcao
     */
    private $fkTcealIdentificadorAcao;


    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return AcaoIdentificadorAcao
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set codIdentificador
     *
     * @param integer $codIdentificador
     * @return AcaoIdentificadorAcao
     */
    public function setCodIdentificador($codIdentificador)
    {
        $this->codIdentificador = $codIdentificador;
        return $this;
    }

    /**
     * Get codIdentificador
     *
     * @return integer
     */
    public function getCodIdentificador()
    {
        return $this->codIdentificador;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcealIdentificadorAcao
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\IdentificadorAcao $fkTcealIdentificadorAcao
     * @return AcaoIdentificadorAcao
     */
    public function setFkTcealIdentificadorAcao(\Urbem\CoreBundle\Entity\Tceal\IdentificadorAcao $fkTcealIdentificadorAcao)
    {
        $this->codIdentificador = $fkTcealIdentificadorAcao->getCodIdentificador();
        $this->fkTcealIdentificadorAcao = $fkTcealIdentificadorAcao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcealIdentificadorAcao
     *
     * @return \Urbem\CoreBundle\Entity\Tceal\IdentificadorAcao
     */
    public function getFkTcealIdentificadorAcao()
    {
        return $this->fkTcealIdentificadorAcao;
    }

    /**
     * OneToOne (owning side)
     * Set PpaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao
     * @return AcaoIdentificadorAcao
     */
    public function setFkPpaAcao(\Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao)
    {
        $this->codAcao = $fkPpaAcao->getCodAcao();
        $this->fkPpaAcao = $fkPpaAcao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPpaAcao
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Acao
     */
    public function getFkPpaAcao()
    {
        return $this->fkPpaAcao;
    }
}
