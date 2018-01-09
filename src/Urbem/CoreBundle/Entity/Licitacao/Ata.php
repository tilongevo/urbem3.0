<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * Ata
 */
class Ata
{
    /**
     * PK
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $numEdital;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $numAta;

    /**
     * @var string
     */
    private $exercicioAta;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $dtValidadeAta;

    /**
     * @var integer
     */
    private $tipoAdesao = 0;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoAta
     */
    private $fkLicitacaoPublicacaoAtas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    private $fkLicitacaoEdital;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\TipoAdesaoAta
     */
    private $fkLicitacaoTipoAdesaoAta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoPublicacaoAtas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Ata
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numEdital
     *
     * @param integer $numEdital
     * @return Ata
     */
    public function setNumEdital($numEdital)
    {
        $this->numEdital = $numEdital;
        return $this;
    }

    /**
     * Get numEdital
     *
     * @return integer
     */
    public function getNumEdital()
    {
        return $this->numEdital;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Ata
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
     * Set numAta
     *
     * @param integer $numAta
     * @return Ata
     */
    public function setNumAta($numAta)
    {
        $this->numAta = $numAta;
        return $this;
    }

    /**
     * Get numAta
     *
     * @return integer
     */
    public function getNumAta()
    {
        return $this->numAta;
    }

    /**
     * Set exercicioAta
     *
     * @param string $exercicioAta
     * @return Ata
     */
    public function setExercicioAta($exercicioAta)
    {
        $this->exercicioAta = $exercicioAta;
        return $this;
    }

    /**
     * Get exercicioAta
     *
     * @return string
     */
    public function getExercicioAta()
    {
        return $this->exercicioAta;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return Ata
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Ata
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
     * Set dtValidadeAta
     *
     * @param \DateTime $dtValidadeAta
     * @return Ata
     */
    public function setDtValidadeAta(\DateTime $dtValidadeAta)
    {
        $this->dtValidadeAta = $dtValidadeAta;
        return $this;
    }

    /**
     * Get dtValidadeAta
     *
     * @return \DateTime
     */
    public function getDtValidadeAta()
    {
        return $this->dtValidadeAta;
    }

    /**
     * Set tipoAdesao
     *
     * @param integer $tipoAdesao
     * @return Ata
     */
    public function setTipoAdesao($tipoAdesao)
    {
        $this->tipoAdesao = $tipoAdesao;
        return $this;
    }

    /**
     * Get tipoAdesao
     *
     * @return integer
     */
    public function getTipoAdesao()
    {
        return $this->tipoAdesao;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoPublicacaoAta
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoAta $fkLicitacaoPublicacaoAta
     * @return Ata
     */
    public function addFkLicitacaoPublicacaoAtas(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoAta $fkLicitacaoPublicacaoAta)
    {
        if (false === $this->fkLicitacaoPublicacaoAtas->contains($fkLicitacaoPublicacaoAta)) {
            $fkLicitacaoPublicacaoAta->setFkLicitacaoAta($this);
            $this->fkLicitacaoPublicacaoAtas->add($fkLicitacaoPublicacaoAta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoAta
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoAta $fkLicitacaoPublicacaoAta
     */
    public function removeFkLicitacaoPublicacaoAtas(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoAta $fkLicitacaoPublicacaoAta)
    {
        $this->fkLicitacaoPublicacaoAtas->removeElement($fkLicitacaoPublicacaoAta);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoAtas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoAta
     */
    public function getFkLicitacaoPublicacaoAtas()
    {
        return $this->fkLicitacaoPublicacaoAtas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital
     * @return Ata
     */
    public function setFkLicitacaoEdital(\Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital)
    {
        $this->numEdital = $fkLicitacaoEdital->getNumEdital();
        $this->exercicio = $fkLicitacaoEdital->getExercicio();
        $this->fkLicitacaoEdital = $fkLicitacaoEdital;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoEdital
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    public function getFkLicitacaoEdital()
    {
        return $this->fkLicitacaoEdital;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoTipoAdesaoAta
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\TipoAdesaoAta $fkLicitacaoTipoAdesaoAta
     * @return Ata
     */
    public function setFkLicitacaoTipoAdesaoAta(TipoAdesaoAta $fkLicitacaoTipoAdesaoAta)
    {
        $this->tipoAdesao = $fkLicitacaoTipoAdesaoAta->getCodigo();
        $this->fkLicitacaoTipoAdesaoAta = $fkLicitacaoTipoAdesaoAta;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoTipoAdesaoAta
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\TipoAdesaoAta
     */
    public function getFkLicitacaoTipoAdesaoAta()
    {
        return $this->fkLicitacaoTipoAdesaoAta;
    }

    /**
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return "{$this->numAta} - {$this->exercicioAta}";
    }
}
