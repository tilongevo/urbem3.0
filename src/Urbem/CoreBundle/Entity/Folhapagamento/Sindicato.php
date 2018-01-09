<?php

namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * Sindicato
 */
class Sindicato
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $dataBase;

    /**
     * @var integer
     */
    private $codEvento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\SindicatoFuncao
     */
    private $fkFolhapagamentoSindicatoFuncao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridica;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSindicato
     */
    private $fkPessoalContratoServidorSindicatos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalContratoServidorSindicatos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Sindicato
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set dataBase
     *
     * @param integer $dataBase
     * @return Sindicato
     */
    public function setDataBase($dataBase = null)
    {
        $this->dataBase = $dataBase;
        return $this;
    }

    /**
     * Get dataBase
     *
     * @return integer
     */
    public function getDataBase()
    {
        return $this->dataBase;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return Sindicato
     */
    public function setCodEvento($codEvento)
    {
        $this->codEvento = $codEvento;
        return $this;
    }

    /**
     * Get codEvento
     *
     * @return integer
     */
    public function getCodEvento()
    {
        return $this->codEvento;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorSindicato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSindicato $fkPessoalContratoServidorSindicato
     * @return Sindicato
     */
    public function addFkPessoalContratoServidorSindicatos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSindicato $fkPessoalContratoServidorSindicato)
    {
        if (false === $this->fkPessoalContratoServidorSindicatos->contains($fkPessoalContratoServidorSindicato)) {
            $fkPessoalContratoServidorSindicato->setFkFolhapagamentoSindicato($this);
            $this->fkPessoalContratoServidorSindicatos->add($fkPessoalContratoServidorSindicato);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorSindicato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSindicato $fkPessoalContratoServidorSindicato
     */
    public function removeFkPessoalContratoServidorSindicatos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSindicato $fkPessoalContratoServidorSindicato)
    {
        $this->fkPessoalContratoServidorSindicatos->removeElement($fkPessoalContratoServidorSindicato);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorSindicatos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSindicato
     */
    public function getFkPessoalContratoServidorSindicatos()
    {
        return $this->fkPessoalContratoServidorSindicatos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return Sindicato
     */
    public function setFkFolhapagamentoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->codEvento = $fkFolhapagamentoEvento->getCodEvento();
        $this->fkFolhapagamentoEvento = $fkFolhapagamentoEvento;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento()
    {
        return $this->fkFolhapagamentoEvento;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoSindicatoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SindicatoFuncao $fkFolhapagamentoSindicatoFuncao
     * @return Sindicato
     */
    public function setFkFolhapagamentoSindicatoFuncao(\Urbem\CoreBundle\Entity\Folhapagamento\SindicatoFuncao $fkFolhapagamentoSindicatoFuncao)
    {
        $fkFolhapagamentoSindicatoFuncao->setFkFolhapagamentoSindicato($this);
        $this->fkFolhapagamentoSindicatoFuncao = $fkFolhapagamentoSindicatoFuncao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoSindicatoFuncao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\SindicatoFuncao
     */
    public function getFkFolhapagamentoSindicatoFuncao()
    {
        return $this->fkFolhapagamentoSindicatoFuncao;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return Sindicato
     */
    public function setFkSwCgmPessoaJuridica(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        $this->numcgm = $fkSwCgmPessoaJuridica->getNumcgm();
        $this->fkSwCgmPessoaJuridica = $fkSwCgmPessoaJuridica;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgmPessoaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    public function getFkSwCgmPessoaJuridica()
    {
        return $this->fkSwCgmPessoaJuridica;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->fkSwCgmPessoaJuridica, $this->fkFolhapagamentoEvento);
    }
}
