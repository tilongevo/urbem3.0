<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Servidor
 */
class Servidor
{
    /**
     * PK
     * @var integer
     */
    private $codServidor;

    /**
     * @var integer
     */
    private $codUf;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $nomePai;

    /**
     * @var string
     */
    private $nomeMae;

    /**
     * @var string
     */
    private $zonaTitulo;

    /**
     * @var string
     */
    private $secaoTitulo;

    /**
     * @var string
     */
    private $caminhoFoto;

    /**
     * @var string
     */
    private $nrTituloEleitor;

    /**
     * @var integer
     */
    private $codEstadoCivil;

    /**
     * @var integer
     */
    private $codRaca;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ServidorReservista
     */
    private $fkPessoalServidorReservista;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorPisPasep
     */
    private $fkPessoalServidorPisPaseps;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorDependente
     */
    private $fkPessoalServidorDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorConjuge
     */
    private $fkPessoalServidorConjuges;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorCtps
     */
    private $fkPessoalServidorCtps;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorCid
     */
    private $fkPessoalServidorCids;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor
     */
    private $fkPessoalServidorContratoServidores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorDocumentoDigital
     */
    private $fkPessoalServidorDocumentoDigitais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\EstadoCivil
     */
    private $fkCseEstadoCivil;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Raca
     */
    private $fkCseRaca;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalServidorPisPaseps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalServidorDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalServidorConjuges = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalServidorCtps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalServidorCids = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalServidorContratoServidores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codServidor
     *
     * @param integer $codServidor
     * @return Servidor
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
     * Set codUf
     *
     * @param integer $codUf
     * @return Servidor
     */
    public function setCodUf($codUf = null)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return Servidor
     */
    public function setCodMunicipio($codMunicipio = null)
    {
        $this->codMunicipio = $codMunicipio;
        return $this;
    }

    /**
     * Get codMunicipio
     *
     * @return integer
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Servidor
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
     * Set nomePai
     *
     * @param string $nomePai
     * @return Servidor
     */
    public function setNomePai($nomePai = null)
    {
        $this->nomePai = $nomePai;
        return $this;
    }

    /**
     * Get nomePai
     *
     * @return string
     */
    public function getNomePai()
    {
        return $this->nomePai;
    }

    /**
     * Set nomeMae
     *
     * @param string $nomeMae
     * @return Servidor
     */
    public function setNomeMae($nomeMae)
    {
        $this->nomeMae = $nomeMae;
        return $this;
    }

    /**
     * Get nomeMae
     *
     * @return string
     */
    public function getNomeMae()
    {
        return $this->nomeMae;
    }

    /**
     * Set zonaTitulo
     *
     * @param string $zonaTitulo
     * @return Servidor
     */
    public function setZonaTitulo($zonaTitulo)
    {
        $this->zonaTitulo = $zonaTitulo;
        return $this;
    }

    /**
     * Get zonaTitulo
     *
     * @return string
     */
    public function getZonaTitulo()
    {
        return $this->zonaTitulo;
    }

    /**
     * Set secaoTitulo
     *
     * @param string $secaoTitulo
     * @return Servidor
     */
    public function setSecaoTitulo($secaoTitulo)
    {
        $this->secaoTitulo = $secaoTitulo;
        return $this;
    }

    /**
     * Get secaoTitulo
     *
     * @return string
     */
    public function getSecaoTitulo()
    {
        return $this->secaoTitulo;
    }

    /**
     * Set caminhoFoto
     *
     * @param string $caminhoFoto
     * @return Servidor
     */
    public function setCaminhoFoto($caminhoFoto = null)
    {
        $this->caminhoFoto = $caminhoFoto;
        return $this;
    }

    /**
     * Get caminhoFoto
     *
     * @return string
     */
    public function getCaminhoFoto()
    {
        return $this->caminhoFoto;
    }

    /**
     * Set nrTituloEleitor
     *
     * @param string $nrTituloEleitor
     * @return Servidor
     */
    public function setNrTituloEleitor($nrTituloEleitor)
    {
        $this->nrTituloEleitor = $nrTituloEleitor;
        return $this;
    }

    /**
     * Get nrTituloEleitor
     *
     * @return string
     */
    public function getNrTituloEleitor()
    {
        return $this->nrTituloEleitor;
    }

    /**
     * Set codEstadoCivil
     *
     * @param integer $codEstadoCivil
     * @return Servidor
     */
    public function setCodEstadoCivil($codEstadoCivil)
    {
        $this->codEstadoCivil = $codEstadoCivil;
        return $this;
    }

    /**
     * Get codEstadoCivil
     *
     * @return integer
     */
    public function getCodEstadoCivil()
    {
        return $this->codEstadoCivil;
    }

    /**
     * Set codRaca
     *
     * @param integer $codRaca
     * @return Servidor
     */
    public function setCodRaca($codRaca)
    {
        $this->codRaca = $codRaca;
        return $this;
    }

    /**
     * Get codRaca
     *
     * @return integer
     */
    public function getCodRaca()
    {
        return $this->codRaca;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalServidorPisPasep
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorPisPasep $fkPessoalServidorPisPasep
     * @return Servidor
     */
    public function addFkPessoalServidorPisPaseps(\Urbem\CoreBundle\Entity\Pessoal\ServidorPisPasep $fkPessoalServidorPisPasep)
    {
        if (false === $this->fkPessoalServidorPisPaseps->contains($fkPessoalServidorPisPasep)) {
            $fkPessoalServidorPisPasep->setFkPessoalServidor($this);
            $this->fkPessoalServidorPisPaseps->add($fkPessoalServidorPisPasep);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidorPisPasep
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorPisPasep $fkPessoalServidorPisPasep
     */
    public function removeFkPessoalServidorPisPaseps(\Urbem\CoreBundle\Entity\Pessoal\ServidorPisPasep $fkPessoalServidorPisPasep)
    {
        $this->fkPessoalServidorPisPaseps->removeElement($fkPessoalServidorPisPasep);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidorPisPaseps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorPisPasep
     */
    public function getFkPessoalServidorPisPaseps()
    {
        return $this->fkPessoalServidorPisPaseps;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalServidorDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorDependente $fkPessoalServidorDependente
     * @return Servidor
     */
    public function addFkPessoalServidorDependentes(\Urbem\CoreBundle\Entity\Pessoal\ServidorDependente $fkPessoalServidorDependente)
    {
        if (false === $this->fkPessoalServidorDependentes->contains($fkPessoalServidorDependente)) {
            $fkPessoalServidorDependente->setFkPessoalServidor($this);
            $this->fkPessoalServidorDependentes->add($fkPessoalServidorDependente);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidorDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorDependente $fkPessoalServidorDependente
     */
    public function removeFkPessoalServidorDependentes(\Urbem\CoreBundle\Entity\Pessoal\ServidorDependente $fkPessoalServidorDependente)
    {
        $this->fkPessoalServidorDependentes->removeElement($fkPessoalServidorDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidorDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorDependente
     */
    public function getFkPessoalServidorDependentes()
    {
        return $this->fkPessoalServidorDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalServidorConjuge
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorConjuge $fkPessoalServidorConjuge
     * @return Servidor
     */
    public function addFkPessoalServidorConjuges(\Urbem\CoreBundle\Entity\Pessoal\ServidorConjuge $fkPessoalServidorConjuge)
    {
        if (false === $this->fkPessoalServidorConjuges->contains($fkPessoalServidorConjuge)) {
            $fkPessoalServidorConjuge->setFkPessoalServidor($this);
            $this->fkPessoalServidorConjuges->add($fkPessoalServidorConjuge);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidorConjuge
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorConjuge $fkPessoalServidorConjuge
     */
    public function removeFkPessoalServidorConjuges(\Urbem\CoreBundle\Entity\Pessoal\ServidorConjuge $fkPessoalServidorConjuge)
    {
        $this->fkPessoalServidorConjuges->removeElement($fkPessoalServidorConjuge);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidorConjuges
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorConjuge
     */
    public function getFkPessoalServidorConjuges()
    {
        return $this->fkPessoalServidorConjuges;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalServidorCtps
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorCtps $fkPessoalServidorCtps
     * @return Servidor
     */
    public function addFkPessoalServidorCtps(\Urbem\CoreBundle\Entity\Pessoal\ServidorCtps $fkPessoalServidorCtps)
    {
        if (false === $this->fkPessoalServidorCtps->contains($fkPessoalServidorCtps)) {
            $fkPessoalServidorCtps->setFkPessoalServidor($this);
            $this->fkPessoalServidorCtps->add($fkPessoalServidorCtps);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * @param \Doctrine\Common\Collections\Collection $fkPessoalServidorCtps
     * @return $this
     */
    public function setFkPessoalServidorCtps(\Doctrine\Common\Collections\Collection $fkPessoalServidorCtps)
    {
        $this->fkPessoalServidorCtps = $fkPessoalServidorCtps;

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidorCtps
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorCtps $fkPessoalServidorCtps
     */
    public function removeFkPessoalServidorCtps(\Urbem\CoreBundle\Entity\Pessoal\ServidorCtps $fkPessoalServidorCtps)
    {
        $this->fkPessoalServidorCtps->removeElement($fkPessoalServidorCtps);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidorCtps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorCtps
     */
    public function getFkPessoalServidorCtps()
    {
        return $this->fkPessoalServidorCtps;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalServidorCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorCid $fkPessoalServidorCid
     * @return Servidor
     */
    public function addFkPessoalServidorCids(\Urbem\CoreBundle\Entity\Pessoal\ServidorCid $fkPessoalServidorCid)
    {
        if (false === $this->fkPessoalServidorCids->contains($fkPessoalServidorCid)) {
            $fkPessoalServidorCid->setFkPessoalServidor($this);
            $this->fkPessoalServidorCids->add($fkPessoalServidorCid);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidorCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorCid $fkPessoalServidorCid
     */
    public function removeFkPessoalServidorCids(\Urbem\CoreBundle\Entity\Pessoal\ServidorCid $fkPessoalServidorCid)
    {
        $this->fkPessoalServidorCids->removeElement($fkPessoalServidorCid);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidorCids
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorCid
     */
    public function getFkPessoalServidorCids()
    {
        return $this->fkPessoalServidorCids;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalServidorContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor $fkPessoalServidorContratoServidor
     * @return Servidor
     */
    public function addFkPessoalServidorContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor $fkPessoalServidorContratoServidor)
    {
        if (false === $this->fkPessoalServidorContratoServidores->contains($fkPessoalServidorContratoServidor)) {
            $fkPessoalServidorContratoServidor->setFkPessoalServidor($this);
            $this->fkPessoalServidorContratoServidores->add($fkPessoalServidorContratoServidor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidorContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor $fkPessoalServidorContratoServidor
     */
    public function removeFkPessoalServidorContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor $fkPessoalServidorContratoServidor)
    {
        $this->fkPessoalServidorContratoServidores->removeElement($fkPessoalServidorContratoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidorContratoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor
     */
    public function getFkPessoalServidorContratoServidores()
    {
        return $this->fkPessoalServidorContratoServidores;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalServidorDocumentoDigital
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorDocumentoDigital $fkPessoalServidorDocumentoDigital
     * @return Servidor
     */
    public function addFkPessoalServidorDocumentoDigitais(\Urbem\CoreBundle\Entity\Pessoal\ServidorDocumentoDigital $fkPessoalServidorDocumentoDigital)
    {
        if (false === $this->fkPessoalServidorDocumentoDigitais->contains($fkPessoalServidorDocumentoDigital)) {
            $fkPessoalServidorDocumentoDigital->setFkPessoalServidor($this);
            $this->fkPessoalServidorDocumentoDigitais->add($fkPessoalServidorDocumentoDigital);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidorDocumentoDigital
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorDocumentoDigital $fkPessoalServidorDocumentoDigital
     */
    public function removeFkPessoalServidorDocumentoDigitais(\Urbem\CoreBundle\Entity\Pessoal\ServidorDocumentoDigital $fkPessoalServidorDocumentoDigital)
    {
        $this->fkPessoalServidorDocumentoDigitais->removeElement($fkPessoalServidorDocumentoDigital);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidorDocumentoDigitais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorDocumentoDigital
     */
    public function getFkPessoalServidorDocumentoDigitais()
    {
        return $this->fkPessoalServidorDocumentoDigitais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     * @return Servidor
     */
    public function setFkSwMunicipio(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio)
    {
        $this->codMunicipio = $fkSwMunicipio->getCodMunicipio();
        $this->codUf = $fkSwMunicipio->getCodUf();
        $this->fkSwMunicipio = $fkSwMunicipio;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwMunicipio
     *
     * @return \Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipio()
    {
        return $this->fkSwMunicipio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseEstadoCivil
     *
     * @param \Urbem\CoreBundle\Entity\Cse\EstadoCivil $fkCseEstadoCivil
     * @return Servidor
     */
    public function setFkCseEstadoCivil(\Urbem\CoreBundle\Entity\Cse\EstadoCivil $fkCseEstadoCivil)
    {
        $this->codEstadoCivil = $fkCseEstadoCivil->getCodEstado();
        $this->fkCseEstadoCivil = $fkCseEstadoCivil;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseEstadoCivil
     *
     * @return \Urbem\CoreBundle\Entity\Cse\EstadoCivil
     */
    public function getFkCseEstadoCivil()
    {
        return $this->fkCseEstadoCivil;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseRaca
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Raca $fkCseRaca
     * @return Servidor
     */
    public function setFkCseRaca(\Urbem\CoreBundle\Entity\Cse\Raca $fkCseRaca)
    {
        $this->codRaca = $fkCseRaca->getCodRaca();
        $this->fkCseRaca = $fkCseRaca;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseRaca
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Raca
     */
    public function getFkCseRaca()
    {
        return $this->fkCseRaca;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalServidorReservista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorReservista $fkPessoalServidorReservista
     * @return Servidor
     */
    public function setFkPessoalServidorReservista(\Urbem\CoreBundle\Entity\Pessoal\ServidorReservista $fkPessoalServidorReservista)
    {
        $fkPessoalServidorReservista->setFkPessoalServidor($this);
        $this->fkPessoalServidorReservista = $fkPessoalServidorReservista;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalServidorReservista
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ServidorReservista
     */
    public function getFkPessoalServidorReservista()
    {
        return $this->fkPessoalServidorReservista;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Servidor
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * Retorna o registro/matricula do servidor
     * @return string
     */
    public function getMatricula()
    {
        $servidorContratoServidores = $this->getFkPessoalServidorContratoServidores();
        if (! $servidorContratoServidores->isEmpty()) {
            return $servidorContratoServidores->last()
            ->getFkPessoalContratoServidor()->getFkPessoalContrato()
            ->getRegistro();
        }
        return '';
    }

    /**
     * Retorna o CGM do Servidor
     * @return string
     */
    public function getCgm()
    {
        return $this->getFkSwCgmPessoaFisica()
            ->getNumcgm()
            . " - "
            . $this->getFkSwCgmPessoaFisica()
            ->getFkSwCgm()
            ->getNomCgm();
    }

    /**
     * Retorna a data de admissao do servidor
     * @return string
     */
    public function getDtAdmissao()
    {
        $servidorContratoServidores = $this->getFkPessoalServidorContratoServidores();
        if (! $servidorContratoServidores->isEmpty()) {
            return $servidorContratoServidores->last()
            ->getFkPessoalContratoServidor()->getFkPessoalContratoServidorNomeacaoPosses()->last()
            ->getDtAdmissao();
        }
        return '';
    }

    /**
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function __toString()
    {
        /** @var ServidorContratoServidor $servidorContrato */
        $servidorContrato = $this->getFkPessoalServidorContratoServidores()->last();

        if (is_object($servidorContrato)) {
            $result = $servidorContrato->getFkPessoalContratoServidor()->getMatricula().' - ';
            $result .= $this->getFkSwCgmPessoaFisica();
        } else {
            $result = $this->getFkSwCgmPessoaFisica();
        }

        return (string) $result;
    }
}
