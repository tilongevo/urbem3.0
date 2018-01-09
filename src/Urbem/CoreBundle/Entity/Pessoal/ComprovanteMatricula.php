<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ComprovanteMatricula
 */
class ComprovanteMatricula
{
    /**
     * PK
     * @var integer
     */
    private $codComprovante;

    /**
     * @var \DateTime
     */
    private $dtApresentacao;

    /**
     * @var boolean
     */
    private $apresentada;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula
     */
    private $fkPessoalDependenteComprovanteMatriculas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalDependenteComprovanteMatriculas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codComprovante
     *
     * @param integer $codComprovante
     * @return ComprovanteMatricula
     */
    public function setCodComprovante($codComprovante)
    {
        $this->codComprovante = $codComprovante;
        return $this;
    }

    /**
     * Get codComprovante
     *
     * @return integer
     */
    public function getCodComprovante()
    {
        return $this->codComprovante;
    }

    /**
     * Set dtApresentacao
     *
     * @param \DateTime $dtApresentacao
     * @return ComprovanteMatricula
     */
    public function setDtApresentacao(\DateTime $dtApresentacao)
    {
        $this->dtApresentacao = $dtApresentacao;
        return $this;
    }

    /**
     * Get dtApresentacao
     *
     * @return \DateTime
     */
    public function getDtApresentacao()
    {
        return $this->dtApresentacao;
    }

    /**
     * Set apresentada
     *
     * @param boolean $apresentada
     * @return ComprovanteMatricula
     */
    public function setApresentada($apresentada)
    {
        $this->apresentada = $apresentada;
        return $this;
    }

    /**
     * Get apresentada
     *
     * @return boolean
     */
    public function getApresentada()
    {
        return $this->apresentada;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDependenteComprovanteMatricula
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula $fkPessoalDependenteComprovanteMatricula
     * @return ComprovanteMatricula
     */
    public function addFkPessoalDependenteComprovanteMatriculas(\Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula $fkPessoalDependenteComprovanteMatricula)
    {
        if (false === $this->fkPessoalDependenteComprovanteMatriculas->contains($fkPessoalDependenteComprovanteMatricula)) {
            $fkPessoalDependenteComprovanteMatricula->setFkPessoalComprovanteMatricula($this);
            $this->fkPessoalDependenteComprovanteMatriculas->add($fkPessoalDependenteComprovanteMatricula);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDependenteComprovanteMatricula
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula $fkPessoalDependenteComprovanteMatricula
     */
    public function removeFkPessoalDependenteComprovanteMatriculas(\Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula $fkPessoalDependenteComprovanteMatricula)
    {
        $this->fkPessoalDependenteComprovanteMatriculas->removeElement($fkPessoalDependenteComprovanteMatricula);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDependenteComprovanteMatriculas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula
     */
    public function getFkPessoalDependenteComprovanteMatriculas()
    {
        return $this->fkPessoalDependenteComprovanteMatriculas;
    }
}
