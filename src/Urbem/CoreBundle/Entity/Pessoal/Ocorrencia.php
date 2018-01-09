<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Ocorrencia
 */
class Ocorrencia
{
    /**
     * PK
     * @var integer
     */
    private $codOcorrencia;

    /**
     * @var integer
     */
    private $codRegimePrevidencia;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $numOcorrencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOcorrencia
     */
    private $fkPessoalContratoServidorOcorrencias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia
     */
    private $fkFolhapagamentoRegimePrevidencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalContratoServidorOcorrencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codOcorrencia
     *
     * @param integer $codOcorrencia
     * @return Ocorrencia
     */
    public function setCodOcorrencia($codOcorrencia)
    {
        $this->codOcorrencia = $codOcorrencia;
        return $this;
    }

    /**
     * Get codOcorrencia
     *
     * @return integer
     */
    public function getCodOcorrencia()
    {
        return $this->codOcorrencia;
    }

    /**
     * Set codRegimePrevidencia
     *
     * @param integer $codRegimePrevidencia
     * @return Ocorrencia
     */
    public function setCodRegimePrevidencia($codRegimePrevidencia)
    {
        $this->codRegimePrevidencia = $codRegimePrevidencia;
        return $this;
    }

    /**
     * Get codRegimePrevidencia
     *
     * @return integer
     */
    public function getCodRegimePrevidencia()
    {
        return $this->codRegimePrevidencia;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Ocorrencia
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
     * Set numOcorrencia
     *
     * @param integer $numOcorrencia
     * @return Ocorrencia
     */
    public function setNumOcorrencia($numOcorrencia = null)
    {
        $this->numOcorrencia = $numOcorrencia;
        return $this;
    }

    /**
     * Get numOcorrencia
     *
     * @return integer
     */
    public function getNumOcorrencia()
    {
        return $this->numOcorrencia;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorOcorrencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOcorrencia $fkPessoalContratoServidorOcorrencia
     * @return Ocorrencia
     */
    public function addFkPessoalContratoServidorOcorrencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOcorrencia $fkPessoalContratoServidorOcorrencia)
    {
        if (false === $this->fkPessoalContratoServidorOcorrencias->contains($fkPessoalContratoServidorOcorrencia)) {
            $fkPessoalContratoServidorOcorrencia->setFkPessoalOcorrencia($this);
            $this->fkPessoalContratoServidorOcorrencias->add($fkPessoalContratoServidorOcorrencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorOcorrencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOcorrencia $fkPessoalContratoServidorOcorrencia
     */
    public function removeFkPessoalContratoServidorOcorrencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOcorrencia $fkPessoalContratoServidorOcorrencia)
    {
        $this->fkPessoalContratoServidorOcorrencias->removeElement($fkPessoalContratoServidorOcorrencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorOcorrencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOcorrencia
     */
    public function getFkPessoalContratoServidorOcorrencias()
    {
        return $this->fkPessoalContratoServidorOcorrencias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoRegimePrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia $fkFolhapagamentoRegimePrevidencia
     * @return Ocorrencia
     */
    public function setFkFolhapagamentoRegimePrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia $fkFolhapagamentoRegimePrevidencia)
    {
        $this->codRegimePrevidencia = $fkFolhapagamentoRegimePrevidencia->getCodRegimePrevidencia();
        $this->fkFolhapagamentoRegimePrevidencia = $fkFolhapagamentoRegimePrevidencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoRegimePrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia
     */
    public function getFkFolhapagamentoRegimePrevidencia()
    {
        return $this->fkFolhapagamentoRegimePrevidencia;
    }
}
