<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Veiculo
 */
class Veiculo
{
    /**
     * PK
     * @var integer
     */
    private $codVeiculo;

    /**
     * @var integer
     */
    private $codMarca;

    /**
     * @var integer
     */
    private $codModelo;

    /**
     * @var integer
     */
    private $codTipoVeiculo;

    /**
     * @var integer
     */
    private $codCategoria;

    /**
     * @var string
     */
    private $prefixo;

    /**
     * @var string
     */
    private $chassi;

    /**
     * @var \DateTime
     */
    private $dtAquisicao;

    /**
     * @var integer
     */
    private $kmInicial;

    /**
     * @var string
     */
    private $numCertificado;

    /**
     * @var string
     */
    private $placa;

    /**
     * @var string
     */
    private $anoFabricacao;

    /**
     * @var string
     */
    private $anoModelo;

    /**
     * @var string
     */
    private $categoria;

    /**
     * @var string
     */
    private $cor;

    /**
     * @var string
     */
    private $capacidade;

    /**
     * @var string
     */
    private $potencia;

    /**
     * @var string
     */
    private $cilindrada;

    /**
     * @var string
     */
    private $notaFiscal;

    /**
     * @var integer
     */
    private $numPassageiro;

    /**
     * @var integer
     */
    private $capacidadeTanque;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Frota\VeiculoBaixado
     */
    private $fkFrotaVeiculoBaixado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam
     */
    private $fkPatrimonioVeiculoUniorcam;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcern\VeiculoCategoriaVinculo
     */
    private $fkTcernVeiculoCategoriaVinculo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Manutencao
     */
    private $fkFrotaManutencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Infracao
     */
    private $fkFrotaInfracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Utilizacao
     */
    private $fkFrotaUtilizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoCombustivel
     */
    private $fkFrotaVeiculoCombustiveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoDocumento
     */
    private $fkFrotaVeiculoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao
     */
    private $fkFrotaVeiculoLocacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoPropriedade
     */
    private $fkFrotaVeiculoPropriedades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\TransporteEscolar
     */
    private $fkFrotaTransporteEscolares;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoCvc
     */
    private $fkTcemgArquivoCvcs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    private $fkFrotaAutorizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Abastecimento
     */
    private $fkFrotaAbastecimentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\MotoristaVeiculo
     */
    private $fkFrotaMotoristaVeiculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\ControleInterno
     */
    private $fkFrotaControleInternos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoCessao
     */
    private $fkFrotaVeiculoCessoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoTerceirosResponsavel
     */
    private $fkFrotaVeiculoTerceirosResponsaveis;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Modelo
     */
    private $fkFrotaModelo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\TipoVeiculo
     */
    private $fkFrotaTipoVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao
     */
    private $fkSwCategoriaHabilitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Marca
     */
    private $fkFrotaMarca;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFrotaManutencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaInfracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaUtilizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculoCombustiveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculoLocacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculoPropriedades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaTransporteEscolares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgArquivoCvcs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaAbastecimentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaMotoristaVeiculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaControleInternos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculoCessoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculoTerceirosResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return Veiculo
     */
    public function setCodVeiculo($codVeiculo)
    {
        $this->codVeiculo = $codVeiculo;
        return $this;
    }

    /**
     * Get codVeiculo
     *
     * @return integer
     */
    public function getCodVeiculo()
    {
        return $this->codVeiculo;
    }

    /**
     * Set codMarca
     *
     * @param integer $codMarca
     * @return Veiculo
     */
    public function setCodMarca($codMarca)
    {
        $this->codMarca = $codMarca;
        return $this;
    }

    /**
     * Get codMarca
     *
     * @return integer
     */
    public function getCodMarca()
    {
        return $this->codMarca;
    }

    /**
     * Set codModelo
     *
     * @param integer $codModelo
     * @return Veiculo
     */
    public function setCodModelo($codModelo)
    {
        $this->codModelo = $codModelo;
        return $this;
    }

    /**
     * Get codModelo
     *
     * @return integer
     */
    public function getCodModelo()
    {
        return $this->codModelo;
    }

    /**
     * Set codTipoVeiculo
     *
     * @param integer $codTipoVeiculo
     * @return Veiculo
     */
    public function setCodTipoVeiculo($codTipoVeiculo)
    {
        $this->codTipoVeiculo = $codTipoVeiculo;
        return $this;
    }

    /**
     * Get codTipoVeiculo
     *
     * @return integer
     */
    public function getCodTipoVeiculo()
    {
        return $this->codTipoVeiculo;
    }

    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return Veiculo
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
     * Set prefixo
     *
     * @param string $prefixo
     * @return Veiculo
     */
    public function setPrefixo($prefixo)
    {
        $this->prefixo = $prefixo;
        return $this;
    }

    /**
     * Get prefixo
     *
     * @return string
     */
    public function getPrefixo()
    {
        return $this->prefixo;
    }

    /**
     * Set chassi
     *
     * @param string $chassi
     * @return Veiculo
     */
    public function setChassi($chassi)
    {
        $this->chassi = $chassi;
        return $this;
    }

    /**
     * Get chassi
     *
     * @return string
     */
    public function getChassi()
    {
        return $this->chassi;
    }

    /**
     * Set dtAquisicao
     *
     * @param \DateTime $dtAquisicao
     * @return Veiculo
     */
    public function setDtAquisicao(\DateTime $dtAquisicao)
    {
        $this->dtAquisicao = $dtAquisicao;
        return $this;
    }

    /**
     * Get dtAquisicao
     *
     * @return \DateTime
     */
    public function getDtAquisicao()
    {
        return $this->dtAquisicao;
    }

    /**
     * Set kmInicial
     *
     * @param integer $kmInicial
     * @return Veiculo
     */
    public function setKmInicial($kmInicial = null)
    {
        $this->kmInicial = $kmInicial;
        return $this;
    }

    /**
     * Get kmInicial
     *
     * @return integer
     */
    public function getKmInicial()
    {
        return $this->kmInicial;
    }

    /**
     * Set numCertificado
     *
     * @param string $numCertificado
     * @return Veiculo
     */
    public function setNumCertificado($numCertificado = null)
    {
        $this->numCertificado = $numCertificado;
        return $this;
    }

    /**
     * Get numCertificado
     *
     * @return string
     */
    public function getNumCertificado()
    {
        return $this->numCertificado;
    }

    /**
     * Set placa
     *
     * @param string $placa
     * @return Veiculo
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;
        return $this;
    }

    /**
     * Get placa
     *
     * @return string
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * Set anoFabricacao
     *
     * @param string $anoFabricacao
     * @return Veiculo
     */
    public function setAnoFabricacao($anoFabricacao)
    {
        $this->anoFabricacao = $anoFabricacao;
        return $this;
    }

    /**
     * Get anoFabricacao
     *
     * @return string
     */
    public function getAnoFabricacao()
    {
        return $this->anoFabricacao;
    }

    /**
     * Set anoModelo
     *
     * @param string $anoModelo
     * @return Veiculo
     */
    public function setAnoModelo($anoModelo)
    {
        $this->anoModelo = $anoModelo;
        return $this;
    }

    /**
     * Get anoModelo
     *
     * @return string
     */
    public function getAnoModelo()
    {
        return $this->anoModelo;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     * @return Veiculo
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set cor
     *
     * @param string $cor
     * @return Veiculo
     */
    public function setCor($cor)
    {
        $this->cor = $cor;
        return $this;
    }

    /**
     * Get cor
     *
     * @return string
     */
    public function getCor()
    {
        return $this->cor;
    }

    /**
     * Set capacidade
     *
     * @param string $capacidade
     * @return Veiculo
     */
    public function setCapacidade($capacidade)
    {
        $this->capacidade = $capacidade;
        return $this;
    }

    /**
     * Get capacidade
     *
     * @return string
     */
    public function getCapacidade()
    {
        return $this->capacidade;
    }

    /**
     * Set potencia
     *
     * @param string $potencia
     * @return Veiculo
     */
    public function setPotencia($potencia)
    {
        $this->potencia = $potencia;
        return $this;
    }

    /**
     * Get potencia
     *
     * @return string
     */
    public function getPotencia()
    {
        return $this->potencia;
    }

    /**
     * Set cilindrada
     *
     * @param string $cilindrada
     * @return Veiculo
     */
    public function setCilindrada($cilindrada)
    {
        $this->cilindrada = $cilindrada;
        return $this;
    }

    /**
     * Get cilindrada
     *
     * @return string
     */
    public function getCilindrada()
    {
        return $this->cilindrada;
    }

    /**
     * Set notaFiscal
     *
     * @param string $notaFiscal
     * @return Veiculo
     */
    public function setNotaFiscal($notaFiscal = null)
    {
        $this->notaFiscal = $notaFiscal;
        return $this;
    }

    /**
     * Get notaFiscal
     *
     * @return string
     */
    public function getNotaFiscal()
    {
        return $this->notaFiscal;
    }

    /**
     * Set numPassageiro
     *
     * @param integer $numPassageiro
     * @return Veiculo
     */
    public function setNumPassageiro($numPassageiro = null)
    {
        $this->numPassageiro = $numPassageiro;
        return $this;
    }

    /**
     * Get numPassageiro
     *
     * @return integer
     */
    public function getNumPassageiro()
    {
        return $this->numPassageiro;
    }

    /**
     * Set capacidadeTanque
     *
     * @param integer $capacidadeTanque
     * @return Veiculo
     */
    public function setCapacidadeTanque($capacidadeTanque = null)
    {
        $this->capacidadeTanque = $capacidadeTanque;
        return $this;
    }

    /**
     * Get capacidadeTanque
     *
     * @return integer
     */
    public function getCapacidadeTanque()
    {
        return $this->capacidadeTanque;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaManutencao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Manutencao $fkFrotaManutencao
     * @return Veiculo
     */
    public function addFkFrotaManutencoes(\Urbem\CoreBundle\Entity\Frota\Manutencao $fkFrotaManutencao)
    {
        if (false === $this->fkFrotaManutencoes->contains($fkFrotaManutencao)) {
            $fkFrotaManutencao->setFkFrotaVeiculo($this);
            $this->fkFrotaManutencoes->add($fkFrotaManutencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaManutencao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Manutencao $fkFrotaManutencao
     */
    public function removeFkFrotaManutencoes(\Urbem\CoreBundle\Entity\Frota\Manutencao $fkFrotaManutencao)
    {
        $this->fkFrotaManutencoes->removeElement($fkFrotaManutencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaManutencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Manutencao
     */
    public function getFkFrotaManutencoes()
    {
        return $this->fkFrotaManutencoes;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Infracao $fkFrotaInfracao
     * @return Veiculo
     */
    public function addFkFrotaInfracoes(\Urbem\CoreBundle\Entity\Frota\Infracao $fkFrotaInfracao)
    {
        if (false === $this->fkFrotaInfracoes->contains($fkFrotaInfracao)) {
            $fkFrotaInfracao->setFkFrotaVeiculo($this);
            $this->fkFrotaInfracoes->add($fkFrotaInfracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Infracao $fkFrotaInfracao
     */
    public function removeFkFrotaInfracoes(\Urbem\CoreBundle\Entity\Frota\Infracao $fkFrotaInfracao)
    {
        $this->fkFrotaInfracoes->removeElement($fkFrotaInfracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaInfracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Infracao
     */
    public function getFkFrotaInfracoes()
    {
        return $this->fkFrotaInfracoes;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaUtilizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Utilizacao $fkFrotaUtilizacao
     * @return Veiculo
     */
    public function addFkFrotaUtilizacoes(\Urbem\CoreBundle\Entity\Frota\Utilizacao $fkFrotaUtilizacao)
    {
        if (false === $this->fkFrotaUtilizacoes->contains($fkFrotaUtilizacao)) {
            $fkFrotaUtilizacao->setFkFrotaVeiculo($this);
            $this->fkFrotaUtilizacoes->add($fkFrotaUtilizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaUtilizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Utilizacao $fkFrotaUtilizacao
     */
    public function removeFkFrotaUtilizacoes(\Urbem\CoreBundle\Entity\Frota\Utilizacao $fkFrotaUtilizacao)
    {
        $this->fkFrotaUtilizacoes->removeElement($fkFrotaUtilizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaUtilizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Utilizacao
     */
    public function getFkFrotaUtilizacoes()
    {
        return $this->fkFrotaUtilizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoCombustivel
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoCombustivel $fkFrotaVeiculoCombustivel
     * @return Veiculo
     */
    public function addFkFrotaVeiculoCombustiveis(\Urbem\CoreBundle\Entity\Frota\VeiculoCombustivel $fkFrotaVeiculoCombustivel)
    {
        if (false === $this->fkFrotaVeiculoCombustiveis->contains($fkFrotaVeiculoCombustivel)) {
            $fkFrotaVeiculoCombustivel->setFkFrotaVeiculo($this);
            $this->fkFrotaVeiculoCombustiveis->add($fkFrotaVeiculoCombustivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoCombustivel
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoCombustivel $fkFrotaVeiculoCombustivel
     */
    public function removeFkFrotaVeiculoCombustiveis(\Urbem\CoreBundle\Entity\Frota\VeiculoCombustivel $fkFrotaVeiculoCombustivel)
    {
        $this->fkFrotaVeiculoCombustiveis->removeElement($fkFrotaVeiculoCombustivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoCombustiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoCombustivel
     */
    public function getFkFrotaVeiculoCombustiveis()
    {
        return $this->fkFrotaVeiculoCombustiveis;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoDocumento $fkFrotaVeiculoDocumento
     * @return Veiculo
     */
    public function addFkFrotaVeiculoDocumentos(\Urbem\CoreBundle\Entity\Frota\VeiculoDocumento $fkFrotaVeiculoDocumento)
    {
        if (false === $this->fkFrotaVeiculoDocumentos->contains($fkFrotaVeiculoDocumento)) {
            $fkFrotaVeiculoDocumento->setFkFrotaVeiculo($this);
            $this->fkFrotaVeiculoDocumentos->add($fkFrotaVeiculoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoDocumento $fkFrotaVeiculoDocumento
     */
    public function removeFkFrotaVeiculoDocumentos(\Urbem\CoreBundle\Entity\Frota\VeiculoDocumento $fkFrotaVeiculoDocumento)
    {
        $this->fkFrotaVeiculoDocumentos->removeElement($fkFrotaVeiculoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoDocumento
     */
    public function getFkFrotaVeiculoDocumentos()
    {
        return $this->fkFrotaVeiculoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoLocacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao
     * @return Veiculo
     */
    public function addFkFrotaVeiculoLocacoes(\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao)
    {
        if (false === $this->fkFrotaVeiculoLocacoes->contains($fkFrotaVeiculoLocacao)) {
            $fkFrotaVeiculoLocacao->setFkFrotaVeiculo($this);
            $this->fkFrotaVeiculoLocacoes->add($fkFrotaVeiculoLocacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoLocacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao
     */
    public function removeFkFrotaVeiculoLocacoes(\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao)
    {
        $this->fkFrotaVeiculoLocacoes->removeElement($fkFrotaVeiculoLocacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoLocacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao
     */
    public function getFkFrotaVeiculoLocacoes()
    {
        return $this->fkFrotaVeiculoLocacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoPropriedade
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoPropriedade $fkFrotaVeiculoPropriedade
     * @return Veiculo
     */
    public function addFkFrotaVeiculoPropriedades(\Urbem\CoreBundle\Entity\Frota\VeiculoPropriedade $fkFrotaVeiculoPropriedade)
    {
        if (false === $this->fkFrotaVeiculoPropriedades->contains($fkFrotaVeiculoPropriedade)) {
            $fkFrotaVeiculoPropriedade->setFkFrotaVeiculo($this);
            $this->fkFrotaVeiculoPropriedades->add($fkFrotaVeiculoPropriedade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoPropriedade
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoPropriedade $fkFrotaVeiculoPropriedade
     */
    public function removeFkFrotaVeiculoPropriedades(\Urbem\CoreBundle\Entity\Frota\VeiculoPropriedade $fkFrotaVeiculoPropriedade)
    {
        $this->fkFrotaVeiculoPropriedades->removeElement($fkFrotaVeiculoPropriedade);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoPropriedades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoPropriedade
     */
    public function getFkFrotaVeiculoPropriedades()
    {
        return $this->fkFrotaVeiculoPropriedades;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaTransporteEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar
     * @return Veiculo
     */
    public function addFkFrotaTransporteEscolares(\Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar)
    {
        if (false === $this->fkFrotaTransporteEscolares->contains($fkFrotaTransporteEscolar)) {
            $fkFrotaTransporteEscolar->setFkFrotaVeiculo($this);
            $this->fkFrotaTransporteEscolares->add($fkFrotaTransporteEscolar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaTransporteEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar
     */
    public function removeFkFrotaTransporteEscolares(\Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar)
    {
        $this->fkFrotaTransporteEscolares->removeElement($fkFrotaTransporteEscolar);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaTransporteEscolares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\TransporteEscolar
     */
    public function getFkFrotaTransporteEscolares()
    {
        return $this->fkFrotaTransporteEscolares;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgArquivoCvc
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoCvc $fkTcemgArquivoCvc
     * @return Veiculo
     */
    public function addFkTcemgArquivoCvcs(\Urbem\CoreBundle\Entity\Tcemg\ArquivoCvc $fkTcemgArquivoCvc)
    {
        if (false === $this->fkTcemgArquivoCvcs->contains($fkTcemgArquivoCvc)) {
            $fkTcemgArquivoCvc->setFkFrotaVeiculo($this);
            $this->fkTcemgArquivoCvcs->add($fkTcemgArquivoCvc);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgArquivoCvc
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoCvc $fkTcemgArquivoCvc
     */
    public function removeFkTcemgArquivoCvcs(\Urbem\CoreBundle\Entity\Tcemg\ArquivoCvc $fkTcemgArquivoCvc)
    {
        $this->fkTcemgArquivoCvcs->removeElement($fkTcemgArquivoCvc);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgArquivoCvcs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoCvc
     */
    public function getFkTcemgArquivoCvcs()
    {
        return $this->fkTcemgArquivoCvcs;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao
     * @return Veiculo
     */
    public function addFkFrotaAutorizacoes(\Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao)
    {
        if (false === $this->fkFrotaAutorizacoes->contains($fkFrotaAutorizacao)) {
            $fkFrotaAutorizacao->setFkFrotaVeiculo($this);
            $this->fkFrotaAutorizacoes->add($fkFrotaAutorizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao
     */
    public function removeFkFrotaAutorizacoes(\Urbem\CoreBundle\Entity\Frota\Autorizacao $fkFrotaAutorizacao)
    {
        $this->fkFrotaAutorizacoes->removeElement($fkFrotaAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaAutorizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Autorizacao
     */
    public function getFkFrotaAutorizacoes()
    {
        return $this->fkFrotaAutorizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaAbastecimento
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Abastecimento $fkFrotaAbastecimento
     * @return Veiculo
     */
    public function addFkFrotaAbastecimentos(\Urbem\CoreBundle\Entity\Frota\Abastecimento $fkFrotaAbastecimento)
    {
        if (false === $this->fkFrotaAbastecimentos->contains($fkFrotaAbastecimento)) {
            $fkFrotaAbastecimento->setFkFrotaVeiculo($this);
            $this->fkFrotaAbastecimentos->add($fkFrotaAbastecimento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaAbastecimento
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Abastecimento $fkFrotaAbastecimento
     */
    public function removeFkFrotaAbastecimentos(\Urbem\CoreBundle\Entity\Frota\Abastecimento $fkFrotaAbastecimento)
    {
        $this->fkFrotaAbastecimentos->removeElement($fkFrotaAbastecimento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaAbastecimentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Abastecimento
     */
    public function getFkFrotaAbastecimentos()
    {
        return $this->fkFrotaAbastecimentos;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaMotoristaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\MotoristaVeiculo $fkFrotaMotoristaVeiculo
     * @return Veiculo
     */
    public function addFkFrotaMotoristaVeiculos(\Urbem\CoreBundle\Entity\Frota\MotoristaVeiculo $fkFrotaMotoristaVeiculo)
    {
        if (false === $this->fkFrotaMotoristaVeiculos->contains($fkFrotaMotoristaVeiculo)) {
            $fkFrotaMotoristaVeiculo->setFkFrotaVeiculo($this);
            $this->fkFrotaMotoristaVeiculos->add($fkFrotaMotoristaVeiculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaMotoristaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\MotoristaVeiculo $fkFrotaMotoristaVeiculo
     */
    public function removeFkFrotaMotoristaVeiculos(\Urbem\CoreBundle\Entity\Frota\MotoristaVeiculo $fkFrotaMotoristaVeiculo)
    {
        $this->fkFrotaMotoristaVeiculos->removeElement($fkFrotaMotoristaVeiculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaMotoristaVeiculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\MotoristaVeiculo
     */
    public function getFkFrotaMotoristaVeiculos()
    {
        return $this->fkFrotaMotoristaVeiculos;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaControleInterno
     *
     * @param \Urbem\CoreBundle\Entity\Frota\ControleInterno $fkFrotaControleInterno
     * @return Veiculo
     */
    public function addFkFrotaControleInternos(\Urbem\CoreBundle\Entity\Frota\ControleInterno $fkFrotaControleInterno)
    {
        if (false === $this->fkFrotaControleInternos->contains($fkFrotaControleInterno)) {
            $fkFrotaControleInterno->setFkFrotaVeiculo($this);
            $this->fkFrotaControleInternos->add($fkFrotaControleInterno);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaControleInterno
     *
     * @param \Urbem\CoreBundle\Entity\Frota\ControleInterno $fkFrotaControleInterno
     */
    public function removeFkFrotaControleInternos(\Urbem\CoreBundle\Entity\Frota\ControleInterno $fkFrotaControleInterno)
    {
        $this->fkFrotaControleInternos->removeElement($fkFrotaControleInterno);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaControleInternos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\ControleInterno
     */
    public function getFkFrotaControleInternos()
    {
        return $this->fkFrotaControleInternos;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoCessao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoCessao $fkFrotaVeiculoCessao
     * @return Veiculo
     */
    public function addFkFrotaVeiculoCessoes(\Urbem\CoreBundle\Entity\Frota\VeiculoCessao $fkFrotaVeiculoCessao)
    {
        if (false === $this->fkFrotaVeiculoCessoes->contains($fkFrotaVeiculoCessao)) {
            $fkFrotaVeiculoCessao->setFkFrotaVeiculo($this);
            $this->fkFrotaVeiculoCessoes->add($fkFrotaVeiculoCessao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoCessao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoCessao $fkFrotaVeiculoCessao
     */
    public function removeFkFrotaVeiculoCessoes(\Urbem\CoreBundle\Entity\Frota\VeiculoCessao $fkFrotaVeiculoCessao)
    {
        $this->fkFrotaVeiculoCessoes->removeElement($fkFrotaVeiculoCessao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoCessoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoCessao
     */
    public function getFkFrotaVeiculoCessoes()
    {
        return $this->fkFrotaVeiculoCessoes;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoTerceirosResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoTerceirosResponsavel $fkFrotaVeiculoTerceirosResponsavel
     * @return Veiculo
     */
    public function addFkFrotaVeiculoTerceirosResponsaveis(\Urbem\CoreBundle\Entity\Frota\VeiculoTerceirosResponsavel $fkFrotaVeiculoTerceirosResponsavel)
    {
        if (false === $this->fkFrotaVeiculoTerceirosResponsaveis->contains($fkFrotaVeiculoTerceirosResponsavel)) {
            $fkFrotaVeiculoTerceirosResponsavel->setFkFrotaVeiculo($this);
            $this->fkFrotaVeiculoTerceirosResponsaveis->add($fkFrotaVeiculoTerceirosResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoTerceirosResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoTerceirosResponsavel $fkFrotaVeiculoTerceirosResponsavel
     */
    public function removeFkFrotaVeiculoTerceirosResponsaveis(\Urbem\CoreBundle\Entity\Frota\VeiculoTerceirosResponsavel $fkFrotaVeiculoTerceirosResponsavel)
    {
        $this->fkFrotaVeiculoTerceirosResponsaveis->removeElement($fkFrotaVeiculoTerceirosResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoTerceirosResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoTerceirosResponsavel
     */
    public function getFkFrotaVeiculoTerceirosResponsaveis()
    {
        return $this->fkFrotaVeiculoTerceirosResponsaveis;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaModelo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Modelo $fkFrotaModelo
     * @return Veiculo
     */
    public function setFkFrotaModelo(\Urbem\CoreBundle\Entity\Frota\Modelo $fkFrotaModelo)
    {
        $this->codModelo = $fkFrotaModelo->getCodModelo();
        $this->codMarca = $fkFrotaModelo->getCodMarca();
        $this->fkFrotaModelo = $fkFrotaModelo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaModelo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Modelo
     */
    public function getFkFrotaModelo()
    {
        return $this->fkFrotaModelo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaTipoVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TipoVeiculo $fkFrotaTipoVeiculo
     * @return Veiculo
     */
    public function setFkFrotaTipoVeiculo(\Urbem\CoreBundle\Entity\Frota\TipoVeiculo $fkFrotaTipoVeiculo)
    {
        $this->codTipoVeiculo = $fkFrotaTipoVeiculo->getCodTipo();
        $this->fkFrotaTipoVeiculo = $fkFrotaTipoVeiculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaTipoVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\TipoVeiculo
     */
    public function getFkFrotaTipoVeiculo()
    {
        return $this->fkFrotaTipoVeiculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCategoriaHabilitacao
     *
     * @param \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao $fkSwCategoriaHabilitacao
     * @return Veiculo
     */
    public function setFkSwCategoriaHabilitacao(\Urbem\CoreBundle\Entity\SwCategoriaHabilitacao $fkSwCategoriaHabilitacao)
    {
        $this->codCategoria = $fkSwCategoriaHabilitacao->getCodCategoria();
        $this->fkSwCategoriaHabilitacao = $fkSwCategoriaHabilitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCategoriaHabilitacao
     *
     * @return \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao
     */
    public function getFkSwCategoriaHabilitacao()
    {
        return $this->fkSwCategoriaHabilitacao;
    }

    /**
     * OneToOne (inverse side)
     * Set FrotaVeiculoBaixado
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoBaixado $fkFrotaVeiculoBaixado
     * @return Veiculo
     */
    public function setFkFrotaVeiculoBaixado(\Urbem\CoreBundle\Entity\Frota\VeiculoBaixado $fkFrotaVeiculoBaixado)
    {
        $fkFrotaVeiculoBaixado->setFkFrotaVeiculo($this);
        $this->fkFrotaVeiculoBaixado = $fkFrotaVeiculoBaixado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFrotaVeiculoBaixado
     *
     * @return \Urbem\CoreBundle\Entity\Frota\VeiculoBaixado
     */
    public function getFkFrotaVeiculoBaixado()
    {
        return $this->fkFrotaVeiculoBaixado;
    }

    /**
     * OneToOne (inverse side)
     * Set PatrimonioVeiculoUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam $fkPatrimonioVeiculoUniorcam
     * @return Veiculo
     */
    public function setFkPatrimonioVeiculoUniorcam(\Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam $fkPatrimonioVeiculoUniorcam)
    {
        $fkPatrimonioVeiculoUniorcam->setFkFrotaVeiculo($this);
        $this->fkPatrimonioVeiculoUniorcam = $fkPatrimonioVeiculoUniorcam;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPatrimonioVeiculoUniorcam
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam
     */
    public function getFkPatrimonioVeiculoUniorcam()
    {
        return $this->fkPatrimonioVeiculoUniorcam;
    }

    /**
     * OneToOne (inverse side)
     * Set TcernVeiculoCategoriaVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\VeiculoCategoriaVinculo $fkTcernVeiculoCategoriaVinculo
     * @return Veiculo
     */
    public function setFkTcernVeiculoCategoriaVinculo(\Urbem\CoreBundle\Entity\Tcern\VeiculoCategoriaVinculo $fkTcernVeiculoCategoriaVinculo)
    {
        $fkTcernVeiculoCategoriaVinculo->setFkFrotaVeiculo($this);
        $this->fkTcernVeiculoCategoriaVinculo = $fkTcernVeiculoCategoriaVinculo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcernVeiculoCategoriaVinculo
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\VeiculoCategoriaVinculo
     */
    public function getFkTcernVeiculoCategoriaVinculo()
    {
        return $this->fkTcernVeiculoCategoriaVinculo;
    }
     
    /**
     * ManyToOne (inverse side)
     * Set fkFrotaMarca
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Marca $fkFrotaMarca
     * @return Veiculo
     */
    public function setFkFrotaMarca(\Urbem\CoreBundle\Entity\Frota\Marca $fkFrotaMarca)
    {
        $this->codMarca = $fkFrotaMarca->getCodMarca();

        $this->fkFrotaMarca = $fkFrotaMarca;
    }
     
    /**
     * ManyToOne (inverse side)
     * Get fkFrotaMarca
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Marca
     */
    public function getFkFrotaMarca()
    {
        return $this->fkFrotaMarca;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->codVeiculo) {
            $veiculo = sprintf(
                "%s - %s / %s / %s",
                $this->codVeiculo,
                substr_replace($this->placa, '-', 3, -4),
                $this->getFkFrotaMarca()->getNomMarca(),
                $this->getFkFrotaModelo()->getNomModelo()
            );
        } else {
            $veiculo = 'Veiculo';
        }
        return $veiculo;
    }
}
