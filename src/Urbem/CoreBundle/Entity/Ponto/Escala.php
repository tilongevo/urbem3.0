<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * Escala
 */
class Escala
{
    /**
     * PK
     * @var integer
     */
    private $codEscala;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $ultimoTimestamp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\EscalaExclusao
     */
    private $fkPontoEscalaExclusao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\EscalaTurno
     */
    private $fkPontoEscalaTurnos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\EscalaContrato
     */
    private $fkPontoEscalaContratos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoEscalaTurnos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoEscalaContratos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEscala
     *
     * @param integer $codEscala
     * @return Escala
     */
    public function setCodEscala($codEscala)
    {
        $this->codEscala = $codEscala;
        return $this;
    }

    /**
     * Get codEscala
     *
     * @return integer
     */
    public function getCodEscala()
    {
        return $this->codEscala;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Escala
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
     * Set ultimoTimestamp
     *
     * @param \DateTime $ultimoTimestamp
     * @return Escala
     */
    public function setUltimoTimestamp(\DateTime $ultimoTimestamp)
    {
        $this->ultimoTimestamp = $ultimoTimestamp;
        return $this;
    }

    /**
     * Get ultimoTimestamp
     *
     * @return \DateTime
     */
    public function getUltimoTimestamp()
    {
        return $this->ultimoTimestamp;
    }

    /**
     * OneToMany (owning side)
     * Add PontoEscalaTurno
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\EscalaTurno $fkPontoEscalaTurno
     * @return Escala
     */
    public function addFkPontoEscalaTurnos(\Urbem\CoreBundle\Entity\Ponto\EscalaTurno $fkPontoEscalaTurno)
    {
        if (false === $this->fkPontoEscalaTurnos->contains($fkPontoEscalaTurno)) {
            $fkPontoEscalaTurno->setFkPontoEscala($this);
            $this->fkPontoEscalaTurnos->add($fkPontoEscalaTurno);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoEscalaTurno
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\EscalaTurno $fkPontoEscalaTurno
     */
    public function removeFkPontoEscalaTurnos(\Urbem\CoreBundle\Entity\Ponto\EscalaTurno $fkPontoEscalaTurno)
    {
        $this->fkPontoEscalaTurnos->removeElement($fkPontoEscalaTurno);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoEscalaTurnos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\EscalaTurno
     */
    public function getFkPontoEscalaTurnos()
    {
        return $this->fkPontoEscalaTurnos;
    }

    /**
     * OneToMany (owning side)
     * Add PontoEscalaContrato
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\EscalaContrato $fkPontoEscalaContrato
     * @return Escala
     */
    public function addFkPontoEscalaContratos(\Urbem\CoreBundle\Entity\Ponto\EscalaContrato $fkPontoEscalaContrato)
    {
        if (false === $this->fkPontoEscalaContratos->contains($fkPontoEscalaContrato)) {
            $fkPontoEscalaContrato->setFkPontoEscala($this);
            $this->fkPontoEscalaContratos->add($fkPontoEscalaContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoEscalaContrato
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\EscalaContrato $fkPontoEscalaContrato
     */
    public function removeFkPontoEscalaContratos(\Urbem\CoreBundle\Entity\Ponto\EscalaContrato $fkPontoEscalaContrato)
    {
        $this->fkPontoEscalaContratos->removeElement($fkPontoEscalaContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoEscalaContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\EscalaContrato
     */
    public function getFkPontoEscalaContratos()
    {
        return $this->fkPontoEscalaContratos;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoEscalaExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\EscalaExclusao $fkPontoEscalaExclusao
     * @return Escala
     */
    public function setFkPontoEscalaExclusao(\Urbem\CoreBundle\Entity\Ponto\EscalaExclusao $fkPontoEscalaExclusao)
    {
        $fkPontoEscalaExclusao->setFkPontoEscala($this);
        $this->fkPontoEscalaExclusao = $fkPontoEscalaExclusao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoEscalaExclusao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\EscalaExclusao
     */
    public function getFkPontoEscalaExclusao()
    {
        return $this->fkPontoEscalaExclusao;
    }
}
