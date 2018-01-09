<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * MovSefipSaidaMovSefipRetorno
 */
class MovSefipSaidaMovSefipRetorno
{
    /**
     * PK
     * @var integer
     */
    private $codSefipSaida;

    /**
     * @var integer
     */
    private $codSefipRetorno;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida
     */
    private $fkPessoalMovSefipSaida;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\MovSefipRetorno
     */
    private $fkPessoalMovSefipRetorno;


    /**
     * Set codSefipSaida
     *
     * @param integer $codSefipSaida
     * @return MovSefipSaidaMovSefipRetorno
     */
    public function setCodSefipSaida($codSefipSaida)
    {
        $this->codSefipSaida = $codSefipSaida;
        return $this;
    }

    /**
     * Get codSefipSaida
     *
     * @return integer
     */
    public function getCodSefipSaida()
    {
        return $this->codSefipSaida;
    }

    /**
     * Set codSefipRetorno
     *
     * @param integer $codSefipRetorno
     * @return MovSefipSaidaMovSefipRetorno
     */
    public function setCodSefipRetorno($codSefipRetorno)
    {
        $this->codSefipRetorno = $codSefipRetorno;
        return $this;
    }

    /**
     * Get codSefipRetorno
     *
     * @return integer
     */
    public function getCodSefipRetorno()
    {
        return $this->codSefipRetorno;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalMovSefipRetorno
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipRetorno $fkPessoalMovSefipRetorno
     * @return MovSefipSaidaMovSefipRetorno
     */
    public function setFkPessoalMovSefipRetorno(\Urbem\CoreBundle\Entity\Pessoal\MovSefipRetorno $fkPessoalMovSefipRetorno)
    {
        $this->codSefipRetorno = $fkPessoalMovSefipRetorno->getCodSefipRetorno();
        $this->fkPessoalMovSefipRetorno = $fkPessoalMovSefipRetorno;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalMovSefipRetorno
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\MovSefipRetorno
     */
    public function getFkPessoalMovSefipRetorno()
    {
        return $this->fkPessoalMovSefipRetorno;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalMovSefipSaida
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida $fkPessoalMovSefipSaida
     * @return MovSefipSaidaMovSefipRetorno
     */
    public function setFkPessoalMovSefipSaida(\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida $fkPessoalMovSefipSaida)
    {
        $this->codSefipSaida = $fkPessoalMovSefipSaida->getCodSefipSaida();
        $this->fkPessoalMovSefipSaida = $fkPessoalMovSefipSaida;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalMovSefipSaida
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida
     */
    public function getFkPessoalMovSefipSaida()
    {
        return $this->fkPessoalMovSefipSaida;
    }
}
