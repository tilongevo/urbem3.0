<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ServidorDependente
 */
class ServidorDependente
{
    /**
     * PK
     * @var integer
     */
    private $codServidor;

    /**
     * PK
     * @var integer
     */
    private $codDependente;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\DependenteExcluido
     */
    private $fkPessoalDependenteExcluido;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Pensao
     */
    private $fkPessoalPensoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    private $fkPessoalServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Dependente
     */
    private $fkPessoalDependente;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalPensoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtInicio = new \DateTime();
    }

    /**
     * Set codServidor
     *
     * @param integer $codServidor
     * @return ServidorDependente
     */
    public function setCodServidor($codServidor)
    {
        $this->codServidor = $codServidor;
        return $this;
    }

    /**
     * Get codServidor
     *
     * @return integer
     */
    public function getCodServidor()
    {
        return $this->codServidor;
    }

    /**
     * Set codDependente
     *
     * @param integer $codDependente
     * @return ServidorDependente
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
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return ServidorDependente
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalPensao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Pensao $fkPessoalPensao
     * @return ServidorDependente
     */
    public function addFkPessoalPensoes(\Urbem\CoreBundle\Entity\Pessoal\Pensao $fkPessoalPensao)
    {
        if (false === $this->fkPessoalPensoes->contains($fkPessoalPensao)) {
            $fkPessoalPensao->setFkPessoalServidorDependente($this);
            $this->fkPessoalPensoes->add($fkPessoalPensao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalPensao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Pensao $fkPessoalPensao
     */
    public function removeFkPessoalPensoes(\Urbem\CoreBundle\Entity\Pessoal\Pensao $fkPessoalPensao)
    {
        $this->fkPessoalPensoes->removeElement($fkPessoalPensao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalPensoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Pensao
     */
    public function getFkPessoalPensoes()
    {
        return $this->fkPessoalPensoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor
     * @return ServidorDependente
     */
    public function setFkPessoalServidor(\Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor)
    {
        $this->codServidor = $fkPessoalServidor->getCodServidor();
        $this->fkPessoalServidor = $fkPessoalServidor;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    public function getFkPessoalServidor()
    {
        return $this->fkPessoalServidor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente
     * @return ServidorDependente
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
     * OneToOne (inverse side)
     * Set PessoalDependenteExcluido
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DependenteExcluido $fkPessoalDependenteExcluido
     * @return ServidorDependente
     */
    public function setFkPessoalDependenteExcluido(\Urbem\CoreBundle\Entity\Pessoal\DependenteExcluido $fkPessoalDependenteExcluido)
    {
        $fkPessoalDependenteExcluido->setFkPessoalServidorDependente($this);
        $this->fkPessoalDependenteExcluido = $fkPessoalDependenteExcluido;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalDependenteExcluido
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\DependenteExcluido
     */
    public function getFkPessoalDependenteExcluido()
    {
        return $this->fkPessoalDependenteExcluido;
    }

    public function __toString()
    {
        return (string) $this->getFkPessoalDependente();
    }
}
