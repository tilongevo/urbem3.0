<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * VinculoRegimeSubdivisao
 */
class VinculoRegimeSubdivisao
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codSubDivisao;

    /**
     * @var integer
     */
    private $codTipoRegime;

    /**
     * @var integer
     */
    private $codTipoVinculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    private $fkPessoalSubDivisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepe\TipoRegimeTrabalho
     */
    private $fkTcepeTipoRegimeTrabalho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepe\TipoVinculo
     */
    private $fkTcepeTipoVinculo;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return VinculoRegimeSubdivisao
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return VinculoRegimeSubdivisao
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
     * Set codTipoRegime
     *
     * @param integer $codTipoRegime
     * @return VinculoRegimeSubdivisao
     */
    public function setCodTipoRegime($codTipoRegime)
    {
        $this->codTipoRegime = $codTipoRegime;
        return $this;
    }

    /**
     * Get codTipoRegime
     *
     * @return integer
     */
    public function getCodTipoRegime()
    {
        return $this->codTipoRegime;
    }

    /**
     * Set codTipoVinculo
     *
     * @param integer $codTipoVinculo
     * @return VinculoRegimeSubdivisao
     */
    public function setCodTipoVinculo($codTipoVinculo)
    {
        $this->codTipoVinculo = $codTipoVinculo;
        return $this;
    }

    /**
     * Get codTipoVinculo
     *
     * @return integer
     */
    public function getCodTipoVinculo()
    {
        return $this->codTipoVinculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     * @return VinculoRegimeSubdivisao
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
     * Set fkTcepeTipoRegimeTrabalho
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoRegimeTrabalho $fkTcepeTipoRegimeTrabalho
     * @return VinculoRegimeSubdivisao
     */
    public function setFkTcepeTipoRegimeTrabalho(\Urbem\CoreBundle\Entity\Tcepe\TipoRegimeTrabalho $fkTcepeTipoRegimeTrabalho)
    {
        $this->codTipoRegime = $fkTcepeTipoRegimeTrabalho->getCodTipoRegime();
        $this->fkTcepeTipoRegimeTrabalho = $fkTcepeTipoRegimeTrabalho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepeTipoRegimeTrabalho
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\TipoRegimeTrabalho
     */
    public function getFkTcepeTipoRegimeTrabalho()
    {
        return $this->fkTcepeTipoRegimeTrabalho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepeTipoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoVinculo $fkTcepeTipoVinculo
     * @return VinculoRegimeSubdivisao
     */
    public function setFkTcepeTipoVinculo(\Urbem\CoreBundle\Entity\Tcepe\TipoVinculo $fkTcepeTipoVinculo)
    {
        $this->codTipoVinculo = $fkTcepeTipoVinculo->getCodTipoVinculo();
        $this->fkTcepeTipoVinculo = $fkTcepeTipoVinculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepeTipoVinculo
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\TipoVinculo
     */
    public function getFkTcepeTipoVinculo()
    {
        return $this->fkTcepeTipoVinculo;
    }
}
