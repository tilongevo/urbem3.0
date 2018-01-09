<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Pensionista
 */
class Pensionista
{
    /**
     * PK
     * @var integer
     */
    private $codPensionista;

    /**
     * PK
     * @var integer
     */
    private $codContratoCedente;

    /**
     * @var integer
     */
    private $codProfissao;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codGrau;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\PensionistaCid
     */
    private $fkPessoalPensionistaCid;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    private $fkPessoalContratoPensionistas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Profissao
     */
    private $fkCseProfissao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\GrauParentesco
     */
    private $fkCseGrauParentesco;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalContratoPensionistas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPensionista
     *
     * @param integer $codPensionista
     * @return Pensionista
     */
    public function setCodPensionista($codPensionista)
    {
        $this->codPensionista = $codPensionista;
        return $this;
    }

    /**
     * Get codPensionista
     *
     * @return integer
     */
    public function getCodPensionista()
    {
        return $this->codPensionista;
    }

    /**
     * Set codContratoCedente
     *
     * @param integer $codContratoCedente
     * @return Pensionista
     */
    public function setCodContratoCedente($codContratoCedente)
    {
        $this->codContratoCedente = $codContratoCedente;
        return $this;
    }

    /**
     * Get codContratoCedente
     *
     * @return integer
     */
    public function getCodContratoCedente()
    {
        return $this->codContratoCedente;
    }

    /**
     * Set codProfissao
     *
     * @param integer $codProfissao
     * @return Pensionista
     */
    public function setCodProfissao($codProfissao)
    {
        $this->codProfissao = $codProfissao;
        return $this;
    }

    /**
     * Get codProfissao
     *
     * @return integer
     */
    public function getCodProfissao()
    {
        return $this->codProfissao;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Pensionista
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
     * Set codGrau
     *
     * @param integer $codGrau
     * @return Pensionista
     */
    public function setCodGrau($codGrau)
    {
        $this->codGrau = $codGrau;
        return $this;
    }

    /**
     * Get codGrau
     *
     * @return integer
     */
    public function getCodGrau()
    {
        return $this->codGrau;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista
     * @return Pensionista
     */
    public function addFkPessoalContratoPensionistas(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista)
    {
        if (false === $this->fkPessoalContratoPensionistas->contains($fkPessoalContratoPensionista)) {
            $fkPessoalContratoPensionista->setFkPessoalPensionista($this);
            $this->fkPessoalContratoPensionistas->add($fkPessoalContratoPensionista);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista
     */
    public function removeFkPessoalContratoPensionistas(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista)
    {
        $this->fkPessoalContratoPensionistas->removeElement($fkPessoalContratoPensionista);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoPensionistas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    public function getFkPessoalContratoPensionistas()
    {
        return $this->fkPessoalContratoPensionistas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return Pensionista
     */
    public function setFkPessoalContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->codContratoCedente = $fkPessoalContratoServidor->getCodContrato();
        $this->fkPessoalContratoServidor = $fkPessoalContratoServidor;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidor()
    {
        return $this->fkPessoalContratoServidor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Profissao $fkCseProfissao
     * @return Pensionista
     */
    public function setFkCseProfissao(\Urbem\CoreBundle\Entity\Cse\Profissao $fkCseProfissao)
    {
        $this->codProfissao = $fkCseProfissao->getCodProfissao();
        $this->fkCseProfissao = $fkCseProfissao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseProfissao
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Profissao
     */
    public function getFkCseProfissao()
    {
        return $this->fkCseProfissao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Pensionista
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseGrauParentesco
     *
     * @param \Urbem\CoreBundle\Entity\Cse\GrauParentesco $fkCseGrauParentesco
     * @return Pensionista
     */
    public function setFkCseGrauParentesco(\Urbem\CoreBundle\Entity\Cse\GrauParentesco $fkCseGrauParentesco)
    {
        $this->codGrau = $fkCseGrauParentesco->getCodGrau();
        $this->fkCseGrauParentesco = $fkCseGrauParentesco;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseGrauParentesco
     *
     * @return \Urbem\CoreBundle\Entity\Cse\GrauParentesco
     */
    public function getFkCseGrauParentesco()
    {
        return $this->fkCseGrauParentesco;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalPensionistaCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensionistaCid $fkPessoalPensionistaCid
     * @return Pensionista
     */
    public function setFkPessoalPensionistaCid(\Urbem\CoreBundle\Entity\Pessoal\PensionistaCid $fkPessoalPensionistaCid)
    {
        $fkPessoalPensionistaCid->setFkPessoalPensionista($this);
        $this->fkPessoalPensionistaCid = $fkPessoalPensionistaCid;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalPensionistaCid
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\PensionistaCid
     */
    public function getFkPessoalPensionistaCid()
    {
        return $this->fkPessoalPensionistaCid;
    }

    /**
     * Retorna a matrícula do pensionista
     * @return null|string
     */
    public function getMatriculaPensionista()
    {
        if (! $this->getFkPessoalContratoPensionistas()->isEmpty()) {
            return $this->getFkPessoalContratoPensionistas()
            ->last()
            ->getFkPessoalContrato()
            ->getRegistro();
        }
        return null;
    }

    /**
     * Retorna os dados do pensionista
     * @return string
     */
    public function getPensionista()
    {
        if ($this->getFkSwCgmPessoaFisica()) {
            return $this->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNumcgm()
            . " - "
            . $this->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
        }
        return '';
    }

    /**
     * Retorna a matricula do servidor
     * @return string
     */
    public function getMatriculaServidor()
    {
        return $this->getFkPessoalContratoServidor()
        ->getFkPessoalContrato()
        ->getRegistro();
    }

    /**
     * Retorna os dados do servidor
     * @return string
     */
    public function getServidor()
    {
        $swCgm = $this->getFkPessoalContratoServidor()
        ->getFkPessoalServidorContratoServidores()
        ->last()
        ->getFkPessoalServidor()
        ->getFkSwCgmPessoaFisica()
        ->getFkSwCgm()
        ;

        return $swCgm->getNumcgm()
        . " - "
        . $swCgm->getNomCgm()
        ;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getPensionista();
    }
}
