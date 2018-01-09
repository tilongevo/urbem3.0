<?php

namespace Urbem\CoreBundle\Entity;

/**
 * SwMunicipio
 */
class SwMunicipio
{
    /**
     * PK
     * @var integer
     */
    private $codMunicipio;

    /**
     * PK
     * @var integer
     */
    private $codUf;

    /**
     * @var string
     */
    private $nomMunicipio;

    /**
     * @var string
     */
    private $codIbge;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao
     */
    private $fkArrecadacaoServicoComRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota
     */
    private $fkArrecadacaoRetencaoNotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Itinerario
     */
    private $fkBeneficioItinerarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Itinerario
     */
    private $fkBeneficioItinerarios1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    private $fkCseCidadoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Domicilio
     */
    private $fkCseDomicilios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota
     */
    private $fkFiscalizacaoRetencaoNotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao
     */
    private $fkFiscalizacaoServicoComRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    private $fkPessoalServidores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwBairro
     */
    private $fkSwBairros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCga
     */
    private $fkSwCgas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCga
     */
    private $fkSwCgas1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwLogradouro
     */
    private $fkSwLogradouros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\Diaria
     */
    private $fkDiariasDiarias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Sefazrs\MunicipiosIptu
     */
    private $fkSefazrsMunicipiosIptus;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgns1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwUf
     */
    private $fkSwUf;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoServicoComRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoRetencaoNotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioItinerarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioItinerarios1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCseCidadoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCseDomicilios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoRetencaoNotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoServicoComRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalServidores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwBairros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgas1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDiariasDiarias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSefazrsMunicipiosIptus = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgns1 = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return SwMunicipio
     */
    public function setCodMunicipio($codMunicipio)
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
     * Set codUf
     *
     * @param integer $codUf
     * @return SwMunicipio
     */
    public function setCodUf($codUf)
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
     * Set nomMunicipio
     *
     * @param string $nomMunicipio
     * @return SwMunicipio
     */
    public function setNomMunicipio($nomMunicipio)
    {
        $this->nomMunicipio = $nomMunicipio;
        return $this;
    }

    /**
     * Get nomMunicipio
     *
     * @return string
     */
    public function getNomMunicipio()
    {
        return $this->nomMunicipio;
    }

    /**
     * Set codIbge
     *
     * @param string $codIbge
     * @return SwMunicipio
     */
    public function setCodIbge($codIbge)
    {
        $this->codIbge = $codIbge;
        return $this;
    }

    /**
     * Get codIbge
     *
     * @return string
     */
    public function getCodIbge()
    {
        return $this->codIbge;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoServicoComRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao $fkArrecadacaoServicoComRetencao
     * @return SwMunicipio
     */
    public function addFkArrecadacaoServicoComRetencoes(\Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao $fkArrecadacaoServicoComRetencao)
    {
        if (false === $this->fkArrecadacaoServicoComRetencoes->contains($fkArrecadacaoServicoComRetencao)) {
            $fkArrecadacaoServicoComRetencao->setFkSwMunicipio($this);
            $this->fkArrecadacaoServicoComRetencoes->add($fkArrecadacaoServicoComRetencao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoServicoComRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao $fkArrecadacaoServicoComRetencao
     */
    public function removeFkArrecadacaoServicoComRetencoes(\Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao $fkArrecadacaoServicoComRetencao)
    {
        $this->fkArrecadacaoServicoComRetencoes->removeElement($fkArrecadacaoServicoComRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoServicoComRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao
     */
    public function getFkArrecadacaoServicoComRetencoes()
    {
        return $this->fkArrecadacaoServicoComRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota
     * @return SwMunicipio
     */
    public function addFkArrecadacaoRetencaoNotas(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota)
    {
        if (false === $this->fkArrecadacaoRetencaoNotas->contains($fkArrecadacaoRetencaoNota)) {
            $fkArrecadacaoRetencaoNota->setFkSwMunicipio($this);
            $this->fkArrecadacaoRetencaoNotas->add($fkArrecadacaoRetencaoNota);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota
     */
    public function removeFkArrecadacaoRetencaoNotas(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota)
    {
        $this->fkArrecadacaoRetencaoNotas->removeElement($fkArrecadacaoRetencaoNota);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoRetencaoNotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota
     */
    public function getFkArrecadacaoRetencaoNotas()
    {
        return $this->fkArrecadacaoRetencaoNotas;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioItinerario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario
     * @return SwMunicipio
     */
    public function addFkBeneficioItinerarios(\Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario)
    {
        if (false === $this->fkBeneficioItinerarios->contains($fkBeneficioItinerario)) {
            $fkBeneficioItinerario->setFkSwMunicipio($this);
            $this->fkBeneficioItinerarios->add($fkBeneficioItinerario);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioItinerario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario
     */
    public function removeFkBeneficioItinerarios(\Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario)
    {
        $this->fkBeneficioItinerarios->removeElement($fkBeneficioItinerario);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioItinerarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Itinerario
     */
    public function getFkBeneficioItinerarios()
    {
        return $this->fkBeneficioItinerarios;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioItinerario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario
     * @return SwMunicipio
     */
    public function addFkBeneficioItinerarios1(\Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario)
    {
        if (false === $this->fkBeneficioItinerarios1->contains($fkBeneficioItinerario)) {
            $fkBeneficioItinerario->setFkSwMunicipio1($this);
            $this->fkBeneficioItinerarios1->add($fkBeneficioItinerario);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioItinerario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario
     */
    public function removeFkBeneficioItinerarios1(\Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario)
    {
        $this->fkBeneficioItinerarios1->removeElement($fkBeneficioItinerario);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioItinerarios1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Itinerario
     */
    public function getFkBeneficioItinerarios1()
    {
        return $this->fkBeneficioItinerarios1;
    }

    /**
     * OneToMany (owning side)
     * Add CseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return SwMunicipio
     */
    public function addFkCseCidadoes(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        if (false === $this->fkCseCidadoes->contains($fkCseCidadao)) {
            $fkCseCidadao->setFkSwMunicipio($this);
            $this->fkCseCidadoes->add($fkCseCidadao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     */
    public function removeFkCseCidadoes(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        $this->fkCseCidadoes->removeElement($fkCseCidadao);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseCidadoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    public function getFkCseCidadoes()
    {
        return $this->fkCseCidadoes;
    }

    /**
     * OneToMany (owning side)
     * Add CseDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio
     * @return SwMunicipio
     */
    public function addFkCseDomicilios(\Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio)
    {
        if (false === $this->fkCseDomicilios->contains($fkCseDomicilio)) {
            $fkCseDomicilio->setFkSwMunicipio($this);
            $this->fkCseDomicilios->add($fkCseDomicilio);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio
     */
    public function removeFkCseDomicilios(\Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio)
    {
        $this->fkCseDomicilios->removeElement($fkCseDomicilio);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseDomicilios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Domicilio
     */
    public function getFkCseDomicilios()
    {
        return $this->fkCseDomicilios;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota
     * @return SwMunicipio
     */
    public function addFkFiscalizacaoRetencaoNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota)
    {
        if (false === $this->fkFiscalizacaoRetencaoNotas->contains($fkFiscalizacaoRetencaoNota)) {
            $fkFiscalizacaoRetencaoNota->setFkSwMunicipio($this);
            $this->fkFiscalizacaoRetencaoNotas->add($fkFiscalizacaoRetencaoNota);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota
     */
    public function removeFkFiscalizacaoRetencaoNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota)
    {
        $this->fkFiscalizacaoRetencaoNotas->removeElement($fkFiscalizacaoRetencaoNota);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoRetencaoNotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota
     */
    public function getFkFiscalizacaoRetencaoNotas()
    {
        return $this->fkFiscalizacaoRetencaoNotas;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoServicoComRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao $fkFiscalizacaoServicoComRetencao
     * @return SwMunicipio
     */
    public function addFkFiscalizacaoServicoComRetencoes(\Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao $fkFiscalizacaoServicoComRetencao)
    {
        if (false === $this->fkFiscalizacaoServicoComRetencoes->contains($fkFiscalizacaoServicoComRetencao)) {
            $fkFiscalizacaoServicoComRetencao->setFkSwMunicipio($this);
            $this->fkFiscalizacaoServicoComRetencoes->add($fkFiscalizacaoServicoComRetencao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoServicoComRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao $fkFiscalizacaoServicoComRetencao
     */
    public function removeFkFiscalizacaoServicoComRetencoes(\Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao $fkFiscalizacaoServicoComRetencao)
    {
        $this->fkFiscalizacaoServicoComRetencoes->removeElement($fkFiscalizacaoServicoComRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoServicoComRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao
     */
    public function getFkFiscalizacaoServicoComRetencoes()
    {
        return $this->fkFiscalizacaoServicoComRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor
     * @return SwMunicipio
     */
    public function addFkPessoalServidores(\Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor)
    {
        if (false === $this->fkPessoalServidores->contains($fkPessoalServidor)) {
            $fkPessoalServidor->setFkSwMunicipio($this);
            $this->fkPessoalServidores->add($fkPessoalServidor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor
     */
    public function removeFkPessoalServidores(\Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor)
    {
        $this->fkPessoalServidores->removeElement($fkPessoalServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    public function getFkPessoalServidores()
    {
        return $this->fkPessoalServidores;
    }

    /**
     * OneToMany (owning side)
     * Add SwBairro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairro $fkSwBairro
     * @return SwMunicipio
     */
    public function addFkSwBairros(\Urbem\CoreBundle\Entity\SwBairro $fkSwBairro)
    {
        if (false === $this->fkSwBairros->contains($fkSwBairro)) {
            $fkSwBairro->setFkSwMunicipio($this);
            $this->fkSwBairros->add($fkSwBairro);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwBairro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairro $fkSwBairro
     */
    public function removeFkSwBairros(\Urbem\CoreBundle\Entity\SwBairro $fkSwBairro)
    {
        $this->fkSwBairros->removeElement($fkSwBairro);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwBairros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwBairro
     */
    public function getFkSwBairros()
    {
        return $this->fkSwBairros;
    }

    /**
     * OneToMany (owning side)
     * Add SwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     * @return SwMunicipio
     */
    public function addFkSwCgas(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        if (false === $this->fkSwCgas->contains($fkSwCga)) {
            $fkSwCga->setFkSwMunicipio($this);
            $this->fkSwCgas->add($fkSwCga);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     */
    public function removeFkSwCgas(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        $this->fkSwCgas->removeElement($fkSwCga);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCga
     */
    public function getFkSwCgas()
    {
        return $this->fkSwCgas;
    }

    /**
     * OneToMany (owning side)
     * Add SwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     * @return SwMunicipio
     */
    public function addFkSwCgas1(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        if (false === $this->fkSwCgas1->contains($fkSwCga)) {
            $fkSwCga->setFkSwMunicipio1($this);
            $this->fkSwCgas1->add($fkSwCga);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     */
    public function removeFkSwCgas1(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        $this->fkSwCgas1->removeElement($fkSwCga);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgas1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCga
     */
    public function getFkSwCgas1()
    {
        return $this->fkSwCgas1;
    }

    /**
     * OneToMany (owning side)
     * Add SwLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro
     * @return SwMunicipio
     */
    public function addFkSwLogradouros(\Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro)
    {
        if (false === $this->fkSwLogradouros->contains($fkSwLogradouro)) {
            $fkSwLogradouro->setFkSwMunicipio($this);
            $this->fkSwLogradouros->add($fkSwLogradouro);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro
     */
    public function removeFkSwLogradouros(\Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro)
    {
        $this->fkSwLogradouros->removeElement($fkSwLogradouro);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwLogradouros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwLogradouro
     */
    public function getFkSwLogradouros()
    {
        return $this->fkSwLogradouros;
    }

    /**
     * OneToMany (owning side)
     * Add DiariasDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria
     * @return SwMunicipio
     */
    public function addFkDiariasDiarias(\Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria)
    {
        if (false === $this->fkDiariasDiarias->contains($fkDiariasDiaria)) {
            $fkDiariasDiaria->setFkSwMunicipio($this);
            $this->fkDiariasDiarias->add($fkDiariasDiaria);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DiariasDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria
     */
    public function removeFkDiariasDiarias(\Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria)
    {
        $this->fkDiariasDiarias->removeElement($fkDiariasDiaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkDiariasDiarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\Diaria
     */
    public function getFkDiariasDiarias()
    {
        return $this->fkDiariasDiarias;
    }

    /**
     * OneToMany (owning side)
     * Add SefazrsMunicipiosIptu
     *
     * @param \Urbem\CoreBundle\Entity\Sefazrs\MunicipiosIptu $fkSefazrsMunicipiosIptu
     * @return SwMunicipio
     */
    public function addFkSefazrsMunicipiosIptus(\Urbem\CoreBundle\Entity\Sefazrs\MunicipiosIptu $fkSefazrsMunicipiosIptu)
    {
        if (false === $this->fkSefazrsMunicipiosIptus->contains($fkSefazrsMunicipiosIptu)) {
            $fkSefazrsMunicipiosIptu->setFkSwMunicipio($this);
            $this->fkSefazrsMunicipiosIptus->add($fkSefazrsMunicipiosIptu);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SefazrsMunicipiosIptu
     *
     * @param \Urbem\CoreBundle\Entity\Sefazrs\MunicipiosIptu $fkSefazrsMunicipiosIptu
     */
    public function removeFkSefazrsMunicipiosIptus(\Urbem\CoreBundle\Entity\Sefazrs\MunicipiosIptu $fkSefazrsMunicipiosIptu)
    {
        $this->fkSefazrsMunicipiosIptus->removeElement($fkSefazrsMunicipiosIptu);
    }

    /**
     * OneToMany (owning side)
     * Get fkSefazrsMunicipiosIptus
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Sefazrs\MunicipiosIptu
     */
    public function getFkSefazrsMunicipiosIptus()
    {
        return $this->fkSefazrsMunicipiosIptus;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return SwMunicipio
     */
    public function addFkSwCgns(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        if (false === $this->fkSwCgns->contains($fkSwCgm)) {
            $fkSwCgm->setFkSwMunicipio($this);
            $this->fkSwCgns->add($fkSwCgm);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     */
    public function removeFkSwCgns(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->fkSwCgns->removeElement($fkSwCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgns()
    {
        return $this->fkSwCgns;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return SwMunicipio
     */
    public function addFkSwCgns1(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        if (false === $this->fkSwCgns1->contains($fkSwCgm)) {
            $fkSwCgm->setFkSwMunicipio1($this);
            $this->fkSwCgns1->add($fkSwCgm);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     */
    public function removeFkSwCgns1(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->fkSwCgns1->removeElement($fkSwCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgns1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgns1()
    {
        return $this->fkSwCgns1;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwUf
     *
     * @param \Urbem\CoreBundle\Entity\SwUf $fkSwUf
     * @return SwMunicipio
     */
    public function setFkSwUf(\Urbem\CoreBundle\Entity\SwUf $fkSwUf)
    {
        $this->codUf = $fkSwUf->getCodUf();
        $this->fkSwUf = $fkSwUf;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwUf
     *
     * @return \Urbem\CoreBundle\Entity\SwUf
     */
    public function getFkSwUf()
    {
        return $this->fkSwUf;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s / %s', $this->nomMunicipio, $this->fkSwUf->getSiglaUf());
    }
}
