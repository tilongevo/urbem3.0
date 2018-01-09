<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * GradeHorario
 */
class GradeHorario
{
    /**
     * PK
     * @var integer
     */
    private $codGrade;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\FaixaTurno
     */
    private $fkPessoalFaixaTurnos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    private $fkEstagioEstagiarioEstagios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalFaixaTurnos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEstagioEstagiarioEstagios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrade
     *
     * @param integer $codGrade
     * @return GradeHorario
     */
    public function setCodGrade($codGrade)
    {
        $this->codGrade = $codGrade;
        return $this;
    }

    /**
     * Get codGrade
     *
     * @return integer
     */
    public function getCodGrade()
    {
        return $this->codGrade;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return GradeHorario
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
     * @param \Doctrine\Common\Collections\Collection $fkPessoalFaixaTurnos
     */
    public function setFkPessoalFaixaTurnos(\Doctrine\Common\Collections\Collection $fkPessoalFaixaTurnos)
    {
        $this->fkPessoalFaixaTurnos = $fkPessoalFaixaTurnos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalFaixaTurno
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\FaixaTurno $fkPessoalFaixaTurno
     * @return GradeHorario
     */
    public function addFkPessoalFaixaTurnos(\Urbem\CoreBundle\Entity\Pessoal\FaixaTurno $fkPessoalFaixaTurno)
    {
        if (false === $this->fkPessoalFaixaTurnos->contains($fkPessoalFaixaTurno)) {
            $fkPessoalFaixaTurno->setFkPessoalGradeHorario($this);
            $this->fkPessoalFaixaTurnos->add($fkPessoalFaixaTurno);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalFaixaTurno
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\FaixaTurno $fkPessoalFaixaTurno
     */
    public function removeFkPessoalFaixaTurnos(\Urbem\CoreBundle\Entity\Pessoal\FaixaTurno $fkPessoalFaixaTurno)
    {
        $this->fkPessoalFaixaTurnos->removeElement($fkPessoalFaixaTurno);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalFaixaTurnos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\FaixaTurno
     */
    public function getFkPessoalFaixaTurnos()
    {
        return $this->fkPessoalFaixaTurnos;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio
     * @return GradeHorario
     */
    public function addFkEstagioEstagiarioEstagios(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio)
    {
        if (false === $this->fkEstagioEstagiarioEstagios->contains($fkEstagioEstagiarioEstagio)) {
            $fkEstagioEstagiarioEstagio->setFkPessoalGradeHorario($this);
            $this->fkEstagioEstagiarioEstagios->add($fkEstagioEstagiarioEstagio);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio
     */
    public function removeFkEstagioEstagiarioEstagios(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio)
    {
        $this->fkEstagioEstagiarioEstagios->removeElement($fkEstagioEstagiarioEstagio);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioEstagiarioEstagios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    public function getFkEstagioEstagiarioEstagios()
    {
        return $this->fkEstagioEstagiarioEstagios;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return GradeHorario
     */
    public function addFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        if (false === $this->fkPessoalContratoServidores->contains($fkPessoalContratoServidor)) {
            $fkPessoalContratoServidor->setFkPessoalGradeHorario($this);
            $this->fkPessoalContratoServidores->add($fkPessoalContratoServidor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     */
    public function removeFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->fkPessoalContratoServidores->removeElement($fkPessoalContratoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidores()
    {
        return $this->fkPessoalContratoServidores;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return trim($this->descricao);
    }
}
