<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ImovelVVenal
 */
class ImovelVVenal
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $venalTerritorialInformado;

    /**
     * @var integer
     */
    private $venalPredialInformado;

    /**
     * @var integer
     */
    private $venalTotalInformado;

    /**
     * @var integer
     */
    private $venalTerritorialCalculado;

    /**
     * @var integer
     */
    private $venalPredialCalculado;

    /**
     * @var integer
     */
    private $venalTotalCalculado;

    /**
     * @var integer
     */
    private $venalTerritorialDeclarado;

    /**
     * @var integer
     */
    private $venalPredialDeclarado;

    /**
     * @var integer
     */
    private $venalTotalDeclarado;

    /**
     * @var integer
     */
    private $venalTerritorialAvaliado;

    /**
     * @var integer
     */
    private $venalPredialAvaliado;

    /**
     * @var integer
     */
    private $venalTotalAvaliado;

    /**
     * @var integer
     */
    private $valorFinanciado;

    /**
     * @var integer
     */
    private $aliquotaValorAvaliado;

    /**
     * @var integer
     */
    private $aliquotaValorFinanciado;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoItbiValor
     */
    private $fkArrecadacaoAtributoItbiValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoImovelVVenalValor
     */
    private $fkArrecadacaoAtributoImovelVVenalValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo
     */
    private $fkArrecadacaoImovelCalculos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoAtributoItbiValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoAtributoImovelVVenalValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoImovelCalculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return ImovelVVenal
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ImovelVVenal
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ImovelVVenal
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set venalTerritorialInformado
     *
     * @param integer $venalTerritorialInformado
     * @return ImovelVVenal
     */
    public function setVenalTerritorialInformado($venalTerritorialInformado = null)
    {
        $this->venalTerritorialInformado = $venalTerritorialInformado;
        return $this;
    }

    /**
     * Get venalTerritorialInformado
     *
     * @return integer
     */
    public function getVenalTerritorialInformado()
    {
        return $this->venalTerritorialInformado;
    }

    /**
     * Set venalPredialInformado
     *
     * @param integer $venalPredialInformado
     * @return ImovelVVenal
     */
    public function setVenalPredialInformado($venalPredialInformado = null)
    {
        $this->venalPredialInformado = $venalPredialInformado;
        return $this;
    }

    /**
     * Get venalPredialInformado
     *
     * @return integer
     */
    public function getVenalPredialInformado()
    {
        return $this->venalPredialInformado;
    }

    /**
     * Set venalTotalInformado
     *
     * @param integer $venalTotalInformado
     * @return ImovelVVenal
     */
    public function setVenalTotalInformado($venalTotalInformado = null)
    {
        $this->venalTotalInformado = $venalTotalInformado;
        return $this;
    }

    /**
     * Get venalTotalInformado
     *
     * @return integer
     */
    public function getVenalTotalInformado()
    {
        return $this->venalTotalInformado;
    }

    /**
     * Set venalTerritorialCalculado
     *
     * @param integer $venalTerritorialCalculado
     * @return ImovelVVenal
     */
    public function setVenalTerritorialCalculado($venalTerritorialCalculado = null)
    {
        $this->venalTerritorialCalculado = $venalTerritorialCalculado;
        return $this;
    }

    /**
     * Get venalTerritorialCalculado
     *
     * @return integer
     */
    public function getVenalTerritorialCalculado()
    {
        return $this->venalTerritorialCalculado;
    }

    /**
     * Set venalPredialCalculado
     *
     * @param integer $venalPredialCalculado
     * @return ImovelVVenal
     */
    public function setVenalPredialCalculado($venalPredialCalculado = null)
    {
        $this->venalPredialCalculado = $venalPredialCalculado;
        return $this;
    }

    /**
     * Get venalPredialCalculado
     *
     * @return integer
     */
    public function getVenalPredialCalculado()
    {
        return $this->venalPredialCalculado;
    }

    /**
     * Set venalTotalCalculado
     *
     * @param integer $venalTotalCalculado
     * @return ImovelVVenal
     */
    public function setVenalTotalCalculado($venalTotalCalculado = null)
    {
        $this->venalTotalCalculado = $venalTotalCalculado;
        return $this;
    }

    /**
     * Get venalTotalCalculado
     *
     * @return integer
     */
    public function getVenalTotalCalculado()
    {
        return $this->venalTotalCalculado;
    }

    /**
     * Set venalTerritorialDeclarado
     *
     * @param integer $venalTerritorialDeclarado
     * @return ImovelVVenal
     */
    public function setVenalTerritorialDeclarado($venalTerritorialDeclarado = null)
    {
        $this->venalTerritorialDeclarado = $venalTerritorialDeclarado;
        return $this;
    }

    /**
     * Get venalTerritorialDeclarado
     *
     * @return integer
     */
    public function getVenalTerritorialDeclarado()
    {
        return $this->venalTerritorialDeclarado;
    }

    /**
     * Set venalPredialDeclarado
     *
     * @param integer $venalPredialDeclarado
     * @return ImovelVVenal
     */
    public function setVenalPredialDeclarado($venalPredialDeclarado = null)
    {
        $this->venalPredialDeclarado = $venalPredialDeclarado;
        return $this;
    }

    /**
     * Get venalPredialDeclarado
     *
     * @return integer
     */
    public function getVenalPredialDeclarado()
    {
        return $this->venalPredialDeclarado;
    }

    /**
     * Set venalTotalDeclarado
     *
     * @param integer $venalTotalDeclarado
     * @return ImovelVVenal
     */
    public function setVenalTotalDeclarado($venalTotalDeclarado = null)
    {
        $this->venalTotalDeclarado = $venalTotalDeclarado;
        return $this;
    }

    /**
     * Get venalTotalDeclarado
     *
     * @return integer
     */
    public function getVenalTotalDeclarado()
    {
        return $this->venalTotalDeclarado;
    }

    /**
     * Set venalTerritorialAvaliado
     *
     * @param integer $venalTerritorialAvaliado
     * @return ImovelVVenal
     */
    public function setVenalTerritorialAvaliado($venalTerritorialAvaliado = null)
    {
        $this->venalTerritorialAvaliado = $venalTerritorialAvaliado;
        return $this;
    }

    /**
     * Get venalTerritorialAvaliado
     *
     * @return integer
     */
    public function getVenalTerritorialAvaliado()
    {
        return $this->venalTerritorialAvaliado;
    }

    /**
     * Set venalPredialAvaliado
     *
     * @param integer $venalPredialAvaliado
     * @return ImovelVVenal
     */
    public function setVenalPredialAvaliado($venalPredialAvaliado = null)
    {
        $this->venalPredialAvaliado = $venalPredialAvaliado;
        return $this;
    }

    /**
     * Get venalPredialAvaliado
     *
     * @return integer
     */
    public function getVenalPredialAvaliado()
    {
        return $this->venalPredialAvaliado;
    }

    /**
     * Set venalTotalAvaliado
     *
     * @param integer $venalTotalAvaliado
     * @return ImovelVVenal
     */
    public function setVenalTotalAvaliado($venalTotalAvaliado = null)
    {
        $this->venalTotalAvaliado = $venalTotalAvaliado;
        return $this;
    }

    /**
     * Get venalTotalAvaliado
     *
     * @return integer
     */
    public function getVenalTotalAvaliado()
    {
        return $this->venalTotalAvaliado;
    }

    /**
     * Set valorFinanciado
     *
     * @param integer $valorFinanciado
     * @return ImovelVVenal
     */
    public function setValorFinanciado($valorFinanciado = null)
    {
        $this->valorFinanciado = $valorFinanciado;
        return $this;
    }

    /**
     * Get valorFinanciado
     *
     * @return integer
     */
    public function getValorFinanciado()
    {
        return $this->valorFinanciado;
    }

    /**
     * Set aliquotaValorAvaliado
     *
     * @param integer $aliquotaValorAvaliado
     * @return ImovelVVenal
     */
    public function setAliquotaValorAvaliado($aliquotaValorAvaliado = null)
    {
        $this->aliquotaValorAvaliado = $aliquotaValorAvaliado;
        return $this;
    }

    /**
     * Get aliquotaValorAvaliado
     *
     * @return integer
     */
    public function getAliquotaValorAvaliado()
    {
        return $this->aliquotaValorAvaliado;
    }

    /**
     * Set aliquotaValorFinanciado
     *
     * @param integer $aliquotaValorFinanciado
     * @return ImovelVVenal
     */
    public function setAliquotaValorFinanciado($aliquotaValorFinanciado = null)
    {
        $this->aliquotaValorFinanciado = $aliquotaValorFinanciado;
        return $this;
    }

    /**
     * Get aliquotaValorFinanciado
     *
     * @return integer
     */
    public function getAliquotaValorFinanciado()
    {
        return $this->aliquotaValorFinanciado;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoItbiValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoItbiValor $fkArrecadacaoAtributoItbiValor
     * @return ImovelVVenal
     */
    public function addFkArrecadacaoAtributoItbiValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoItbiValor $fkArrecadacaoAtributoItbiValor)
    {
        if (false === $this->fkArrecadacaoAtributoItbiValores->contains($fkArrecadacaoAtributoItbiValor)) {
            $fkArrecadacaoAtributoItbiValor->setFkArrecadacaoImovelVVenal($this);
            $this->fkArrecadacaoAtributoItbiValores->add($fkArrecadacaoAtributoItbiValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoItbiValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoItbiValor $fkArrecadacaoAtributoItbiValor
     */
    public function removeFkArrecadacaoAtributoItbiValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoItbiValor $fkArrecadacaoAtributoItbiValor)
    {
        $this->fkArrecadacaoAtributoItbiValores->removeElement($fkArrecadacaoAtributoItbiValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoItbiValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoItbiValor
     */
    public function getFkArrecadacaoAtributoItbiValores()
    {
        return $this->fkArrecadacaoAtributoItbiValores;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoImovelVVenalValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoImovelVVenalValor $fkArrecadacaoAtributoImovelVVenalValor
     * @return ImovelVVenal
     */
    public function addFkArrecadacaoAtributoImovelVVenalValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoImovelVVenalValor $fkArrecadacaoAtributoImovelVVenalValor)
    {
        if (false === $this->fkArrecadacaoAtributoImovelVVenalValores->contains($fkArrecadacaoAtributoImovelVVenalValor)) {
            $fkArrecadacaoAtributoImovelVVenalValor->setFkArrecadacaoImovelVVenal($this);
            $this->fkArrecadacaoAtributoImovelVVenalValores->add($fkArrecadacaoAtributoImovelVVenalValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoImovelVVenalValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoImovelVVenalValor $fkArrecadacaoAtributoImovelVVenalValor
     */
    public function removeFkArrecadacaoAtributoImovelVVenalValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoImovelVVenalValor $fkArrecadacaoAtributoImovelVVenalValor)
    {
        $this->fkArrecadacaoAtributoImovelVVenalValores->removeElement($fkArrecadacaoAtributoImovelVVenalValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoImovelVVenalValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoImovelVVenalValor
     */
    public function getFkArrecadacaoAtributoImovelVVenalValores()
    {
        return $this->fkArrecadacaoAtributoImovelVVenalValores;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoImovelCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo $fkArrecadacaoImovelCalculo
     * @return ImovelVVenal
     */
    public function addFkArrecadacaoImovelCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo $fkArrecadacaoImovelCalculo)
    {
        if (false === $this->fkArrecadacaoImovelCalculos->contains($fkArrecadacaoImovelCalculo)) {
            $fkArrecadacaoImovelCalculo->setFkArrecadacaoImovelVVenal($this);
            $this->fkArrecadacaoImovelCalculos->add($fkArrecadacaoImovelCalculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoImovelCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo $fkArrecadacaoImovelCalculo
     */
    public function removeFkArrecadacaoImovelCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo $fkArrecadacaoImovelCalculo)
    {
        $this->fkArrecadacaoImovelCalculos->removeElement($fkArrecadacaoImovelCalculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoImovelCalculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo
     */
    public function getFkArrecadacaoImovelCalculos()
    {
        return $this->fkArrecadacaoImovelCalculos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return ImovelVVenal
     */
    public function setFkImobiliarioImovel(\Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel)
    {
        $this->inscricaoMunicipal = $fkImobiliarioImovel->getInscricaoMunicipal();
        $this->fkImobiliarioImovel = $fkImobiliarioImovel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    public function getFkImobiliarioImovel()
    {
        return $this->fkImobiliarioImovel;
    }
}
