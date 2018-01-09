<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * NaturezaEstabelecimento
 */
class NaturezaEstabelecimento
{
    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * @var string
     */
    private $exercicioVigencia;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    private $fkImaConfiguracaoDirfs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaConfiguracaoDirfs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return NaturezaEstabelecimento
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set exercicioVigencia
     *
     * @param string $exercicioVigencia
     * @return NaturezaEstabelecimento
     */
    public function setExercicioVigencia($exercicioVigencia)
    {
        $this->exercicioVigencia = $exercicioVigencia;
        return $this;
    }

    /**
     * Get exercicioVigencia
     *
     * @return string
     */
    public function getExercicioVigencia()
    {
        return $this->exercicioVigencia;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return NaturezaEstabelecimento
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
     * Add ImaConfiguracaoDirf
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf
     * @return NaturezaEstabelecimento
     */
    public function addFkImaConfiguracaoDirfs(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf)
    {
        if (false === $this->fkImaConfiguracaoDirfs->contains($fkImaConfiguracaoDirf)) {
            $fkImaConfiguracaoDirf->setFkImaNaturezaEstabelecimento($this);
            $this->fkImaConfiguracaoDirfs->add($fkImaConfiguracaoDirf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoDirf
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf
     */
    public function removeFkImaConfiguracaoDirfs(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf)
    {
        $this->fkImaConfiguracaoDirfs->removeElement($fkImaConfiguracaoDirf);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoDirfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    public function getFkImaConfiguracaoDirfs()
    {
        return $this->fkImaConfiguracaoDirfs;
    }
}
