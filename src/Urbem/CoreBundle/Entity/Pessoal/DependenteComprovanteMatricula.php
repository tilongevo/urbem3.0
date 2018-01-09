<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * DependenteComprovanteMatricula
 */
class DependenteComprovanteMatricula
{
    /**
     * PK
     * @var integer
     */
    private $codDependente;

    /**
     * PK
     * @var integer
     */
    private $codComprovante;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Dependente
     */
    private $fkPessoalDependente;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ComprovanteMatricula
     */
    private $fkPessoalComprovanteMatricula;


    /**
     * Set codDependente
     *
     * @param integer $codDependente
     * @return DependenteComprovanteMatricula
     */
    public function setCodDependente($codDependente)
    {
        $this->codDependente = $codDependente;
        return $this;
    }

    /**
     * Get codDependente
     *
     * @return integer
     */
    public function getCodDependente()
    {
        return $this->codDependente;
    }

    /**
     * Set codComprovante
     *
     * @param integer $codComprovante
     * @return DependenteComprovanteMatricula
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
     * ManyToOne (inverse side)
     * Set fkPessoalDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente
     * @return DependenteComprovanteMatricula
     */
    public function setFkPessoalDependente(\Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente)
    {
        $this->codDependente = $fkPessoalDependente->getCodDependente();
        $this->fkPessoalDependente = $fkPessoalDependente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalDependente
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Dependente
     */
    public function getFkPessoalDependente()
    {
        return $this->fkPessoalDependente;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalComprovanteMatricula
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ComprovanteMatricula $fkPessoalComprovanteMatricula
     * @return DependenteComprovanteMatricula
     */
    public function setFkPessoalComprovanteMatricula(\Urbem\CoreBundle\Entity\Pessoal\ComprovanteMatricula $fkPessoalComprovanteMatricula)
    {
        $this->codComprovante = $fkPessoalComprovanteMatricula->getCodComprovante();
        $this->fkPessoalComprovanteMatricula = $fkPessoalComprovanteMatricula;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalComprovanteMatricula
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ComprovanteMatricula
     */
    public function getFkPessoalComprovanteMatricula()
    {
        return $this->fkPessoalComprovanteMatricula;
    }
}
