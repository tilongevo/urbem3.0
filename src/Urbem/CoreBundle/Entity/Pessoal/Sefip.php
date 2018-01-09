<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Sefip
 */
class Sefip
{
    /**
     * PK
     * @var integer
     */
    private $codSefip;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $numSefip;

    /**
     * @var boolean
     */
    private $repetirMensal = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida
     */
    private $fkPessoalMovSefipSaida;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\MovSefipRetorno
     */
    private $fkPessoalMovSefipRetorno;


    /**
     * Set codSefip
     *
     * @param integer $codSefip
     * @return Sefip
     */
    public function setCodSefip($codSefip)
    {
        $this->codSefip = $codSefip;
        return $this;
    }

    /**
     * Get codSefip
     *
     * @return integer
     */
    public function getCodSefip()
    {
        return $this->codSefip;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Sefip
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set numSefip
     *
     * @param string $numSefip
     * @return Sefip
     */
    public function setNumSefip($numSefip)
    {
        $this->numSefip = $numSefip;
        return $this;
    }

    /**
     * Get numSefip
     *
     * @return string
     */
    public function getNumSefip()
    {
        return $this->numSefip;
    }

    /**
     * Set repetirMensal
     *
     * @param boolean $repetirMensal
     * @return Sefip
     */
    public function setRepetirMensal($repetirMensal = null)
    {
        $this->repetirMensal = $repetirMensal;
        return $this;
    }

    /**
     * Get repetirMensal
     *
     * @return boolean
     */
    public function getRepetirMensal()
    {
        return $this->repetirMensal;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalMovSefipSaida
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida $fkPessoalMovSefipSaida
     * @return Sefip
     */
    public function setFkPessoalMovSefipSaida(\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida $fkPessoalMovSefipSaida)
    {
        $fkPessoalMovSefipSaida->setFkPessoalSefip($this);
        $this->fkPessoalMovSefipSaida = $fkPessoalMovSefipSaida;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalMovSefipSaida
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida
     */
    public function getFkPessoalMovSefipSaida()
    {
        return $this->fkPessoalMovSefipSaida;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalMovSefipRetorno
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipRetorno $fkPessoalMovSefipRetorno
     * @return Sefip
     */
    public function setFkPessoalMovSefipRetorno(\Urbem\CoreBundle\Entity\Pessoal\MovSefipRetorno $fkPessoalMovSefipRetorno)
    {
        $fkPessoalMovSefipRetorno->setFkPessoalSefip($this);
        $this->fkPessoalMovSefipRetorno = $fkPessoalMovSefipRetorno;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalMovSefipRetorno
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\MovSefipRetorno
     */
    public function getFkPessoalMovSefipRetorno()
    {
        return $this->fkPessoalMovSefipRetorno;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
