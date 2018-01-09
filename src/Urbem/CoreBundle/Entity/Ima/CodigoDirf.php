<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * CodigoDirf
 */
class CodigoDirf
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
    private $codDirf;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador
     */
    private $fkImaConfiguracaoDirfPrestadores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaConfiguracaoDirfPrestadores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return CodigoDirf
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
     * Set codDirf
     *
     * @param integer $codDirf
     * @return CodigoDirf
     */
    public function setCodDirf($codDirf)
    {
        $this->codDirf = $codDirf;
        return $this;
    }

    /**
     * Get codDirf
     *
     * @return integer
     */
    public function getCodDirf()
    {
        return $this->codDirf;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return CodigoDirf
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return CodigoDirf
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
     * OneToMany (owning side)
     * Add ImaConfiguracaoDirfPrestador
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador $fkImaConfiguracaoDirfPrestador
     * @return CodigoDirf
     */
    public function addFkImaConfiguracaoDirfPrestadores(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador $fkImaConfiguracaoDirfPrestador)
    {
        if (false === $this->fkImaConfiguracaoDirfPrestadores->contains($fkImaConfiguracaoDirfPrestador)) {
            $fkImaConfiguracaoDirfPrestador->setFkImaCodigoDirf($this);
            $this->fkImaConfiguracaoDirfPrestadores->add($fkImaConfiguracaoDirfPrestador);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoDirfPrestador
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador $fkImaConfiguracaoDirfPrestador
     */
    public function removeFkImaConfiguracaoDirfPrestadores(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador $fkImaConfiguracaoDirfPrestador)
    {
        $this->fkImaConfiguracaoDirfPrestadores->removeElement($fkImaConfiguracaoDirfPrestador);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoDirfPrestadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPrestador
     */
    public function getFkImaConfiguracaoDirfPrestadores()
    {
        return $this->fkImaConfiguracaoDirfPrestadores;
    }
}
