<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * CategoriaSefip
 */
class CategoriaSefip
{
    /**
     * PK
     * @var integer
     */
    private $codCategoria;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Categoria
     */
    private $fkPessoalCategoria;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ModalidadeRecolhimento
     */
    private $fkImaModalidadeRecolhimento;


    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return CategoriaSefip
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return CategoriaSefip
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCategoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Categoria $fkPessoalCategoria
     * @return CategoriaSefip
     */
    public function setFkPessoalCategoria(\Urbem\CoreBundle\Entity\Pessoal\Categoria $fkPessoalCategoria)
    {
        $this->codCategoria = $fkPessoalCategoria->getCodCategoria();
        $this->fkPessoalCategoria = $fkPessoalCategoria;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCategoria
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Categoria
     */
    public function getFkPessoalCategoria()
    {
        return $this->fkPessoalCategoria;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaModalidadeRecolhimento
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ModalidadeRecolhimento $fkImaModalidadeRecolhimento
     * @return CategoriaSefip
     */
    public function setFkImaModalidadeRecolhimento(\Urbem\CoreBundle\Entity\Ima\ModalidadeRecolhimento $fkImaModalidadeRecolhimento)
    {
        $this->codModalidade = $fkImaModalidadeRecolhimento->getCodModalidade();
        $this->fkImaModalidadeRecolhimento = $fkImaModalidadeRecolhimento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaModalidadeRecolhimento
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ModalidadeRecolhimento
     */
    public function getFkImaModalidadeRecolhimento()
    {
        return $this->fkImaModalidadeRecolhimento;
    }
}
