<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * ModalidadeVigencia
 */
class ModalidadeVigencia
{
    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $vigenciaInicial;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $vigenciaFinal;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var integer
     */
    private $codBiblioteca;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $codTipoModalidade;

    /**
     * @var integer
     */
    private $codFormaInscricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeCredito
     */
    private $fkDividaModalidadeCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo
     */
    private $fkDividaModalidadeAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeReducao
     */
    private $fkDividaModalidadeReducoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeDocumento
     */
    private $fkDividaModalidadeDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeParcela
     */
    private $fkDividaModalidadeParcelas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Parcelamento
     */
    private $fkDividaParcelamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\Modalidade
     */
    private $fkDividaModalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\TipoModalidade
     */
    private $fkDividaTipoModalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\FormaInscricao
     */
    private $fkDividaFormaInscricao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkDividaModalidadeCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaModalidadeAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaModalidadeReducoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaModalidadeDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaModalidadeParcelas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaParcelamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ModalidadeVigencia
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ModalidadeVigencia
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
     * Set vigenciaInicial
     *
     * @param \DateTime $vigenciaInicial
     * @return ModalidadeVigencia
     */
    public function setVigenciaInicial(\DateTime $vigenciaInicial)
    {
        $this->vigenciaInicial = $vigenciaInicial;
        return $this;
    }

    /**
     * Get vigenciaInicial
     *
     * @return \DateTime
     */
    public function getVigenciaInicial()
    {
        return $this->vigenciaInicial;
    }

    /**
     * Set vigenciaFinal
     *
     * @param \DateTime $vigenciaFinal
     * @return ModalidadeVigencia
     */
    public function setVigenciaFinal(\DateTime $vigenciaFinal)
    {
        $this->vigenciaFinal = $vigenciaFinal;
        return $this;
    }

    /**
     * Get vigenciaFinal
     *
     * @return \DateTime
     */
    public function getVigenciaFinal()
    {
        return $this->vigenciaFinal;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return ModalidadeVigencia
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set codBiblioteca
     *
     * @param integer $codBiblioteca
     * @return ModalidadeVigencia
     */
    public function setCodBiblioteca($codBiblioteca)
    {
        $this->codBiblioteca = $codBiblioteca;
        return $this;
    }

    /**
     * Get codBiblioteca
     *
     * @return integer
     */
    public function getCodBiblioteca()
    {
        return $this->codBiblioteca;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return ModalidadeVigencia
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return ModalidadeVigencia
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set codTipoModalidade
     *
     * @param integer $codTipoModalidade
     * @return ModalidadeVigencia
     */
    public function setCodTipoModalidade($codTipoModalidade)
    {
        $this->codTipoModalidade = $codTipoModalidade;
        return $this;
    }

    /**
     * Get codTipoModalidade
     *
     * @return integer
     */
    public function getCodTipoModalidade()
    {
        return $this->codTipoModalidade;
    }

    /**
     * Set codFormaInscricao
     *
     * @param integer $codFormaInscricao
     * @return ModalidadeVigencia
     */
    public function setCodFormaInscricao($codFormaInscricao)
    {
        $this->codFormaInscricao = $codFormaInscricao;
        return $this;
    }

    /**
     * Get codFormaInscricao
     *
     * @return integer
     */
    public function getCodFormaInscricao()
    {
        return $this->codFormaInscricao;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeCredito
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeCredito $fkDividaModalidadeCredito
     * @return ModalidadeVigencia
     */
    public function addFkDividaModalidadeCreditos(\Urbem\CoreBundle\Entity\Divida\ModalidadeCredito $fkDividaModalidadeCredito)
    {
        if (false === $this->fkDividaModalidadeCreditos->contains($fkDividaModalidadeCredito)) {
            $fkDividaModalidadeCredito->setFkDividaModalidadeVigencia($this);
            $this->fkDividaModalidadeCreditos->add($fkDividaModalidadeCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeCredito
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeCredito $fkDividaModalidadeCredito
     */
    public function removeFkDividaModalidadeCreditos(\Urbem\CoreBundle\Entity\Divida\ModalidadeCredito $fkDividaModalidadeCredito)
    {
        $this->fkDividaModalidadeCreditos->removeElement($fkDividaModalidadeCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeCredito
     */
    public function getFkDividaModalidadeCreditos()
    {
        return $this->fkDividaModalidadeCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo $fkDividaModalidadeAcrescimo
     * @return ModalidadeVigencia
     */
    public function addFkDividaModalidadeAcrescimos(\Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo $fkDividaModalidadeAcrescimo)
    {
        if (false === $this->fkDividaModalidadeAcrescimos->contains($fkDividaModalidadeAcrescimo)) {
            $fkDividaModalidadeAcrescimo->setFkDividaModalidadeVigencia($this);
            $this->fkDividaModalidadeAcrescimos->add($fkDividaModalidadeAcrescimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo $fkDividaModalidadeAcrescimo
     */
    public function removeFkDividaModalidadeAcrescimos(\Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo $fkDividaModalidadeAcrescimo)
    {
        $this->fkDividaModalidadeAcrescimos->removeElement($fkDividaModalidadeAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo
     */
    public function getFkDividaModalidadeAcrescimos()
    {
        return $this->fkDividaModalidadeAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeReducao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeReducao $fkDividaModalidadeReducao
     * @return ModalidadeVigencia
     */
    public function addFkDividaModalidadeReducoes(\Urbem\CoreBundle\Entity\Divida\ModalidadeReducao $fkDividaModalidadeReducao)
    {
        if (false === $this->fkDividaModalidadeReducoes->contains($fkDividaModalidadeReducao)) {
            $fkDividaModalidadeReducao->setFkDividaModalidadeVigencia($this);
            $this->fkDividaModalidadeReducoes->add($fkDividaModalidadeReducao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeReducao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeReducao $fkDividaModalidadeReducao
     */
    public function removeFkDividaModalidadeReducoes(\Urbem\CoreBundle\Entity\Divida\ModalidadeReducao $fkDividaModalidadeReducao)
    {
        $this->fkDividaModalidadeReducoes->removeElement($fkDividaModalidadeReducao);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeReducoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeReducao
     */
    public function getFkDividaModalidadeReducoes()
    {
        return $this->fkDividaModalidadeReducoes;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeDocumento $fkDividaModalidadeDocumento
     * @return ModalidadeVigencia
     */
    public function addFkDividaModalidadeDocumentos(\Urbem\CoreBundle\Entity\Divida\ModalidadeDocumento $fkDividaModalidadeDocumento)
    {
        if (false === $this->fkDividaModalidadeDocumentos->contains($fkDividaModalidadeDocumento)) {
            $fkDividaModalidadeDocumento->setFkDividaModalidadeVigencia($this);
            $this->fkDividaModalidadeDocumentos->add($fkDividaModalidadeDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeDocumento $fkDividaModalidadeDocumento
     */
    public function removeFkDividaModalidadeDocumentos(\Urbem\CoreBundle\Entity\Divida\ModalidadeDocumento $fkDividaModalidadeDocumento)
    {
        $this->fkDividaModalidadeDocumentos->removeElement($fkDividaModalidadeDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeDocumento
     */
    public function getFkDividaModalidadeDocumentos()
    {
        return $this->fkDividaModalidadeDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeParcela
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeParcela $fkDividaModalidadeParcela
     * @return ModalidadeVigencia
     */
    public function addFkDividaModalidadeParcelas(\Urbem\CoreBundle\Entity\Divida\ModalidadeParcela $fkDividaModalidadeParcela)
    {
        if (false === $this->fkDividaModalidadeParcelas->contains($fkDividaModalidadeParcela)) {
            $fkDividaModalidadeParcela->setFkDividaModalidadeVigencia($this);
            $this->fkDividaModalidadeParcelas->add($fkDividaModalidadeParcela);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeParcela
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeParcela $fkDividaModalidadeParcela
     */
    public function removeFkDividaModalidadeParcelas(\Urbem\CoreBundle\Entity\Divida\ModalidadeParcela $fkDividaModalidadeParcela)
    {
        $this->fkDividaModalidadeParcelas->removeElement($fkDividaModalidadeParcela);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeParcelas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeParcela
     */
    public function getFkDividaModalidadeParcelas()
    {
        return $this->fkDividaModalidadeParcelas;
    }

    /**
     * OneToMany (owning side)
     * Add DividaParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento
     * @return ModalidadeVigencia
     */
    public function addFkDividaParcelamentos(\Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento)
    {
        if (false === $this->fkDividaParcelamentos->contains($fkDividaParcelamento)) {
            $fkDividaParcelamento->setFkDividaModalidadeVigencia($this);
            $this->fkDividaParcelamentos->add($fkDividaParcelamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento
     */
    public function removeFkDividaParcelamentos(\Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento)
    {
        $this->fkDividaParcelamentos->removeElement($fkDividaParcelamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaParcelamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Parcelamento
     */
    public function getFkDividaParcelamentos()
    {
        return $this->fkDividaParcelamentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Modalidade $fkDividaModalidade
     * @return ModalidadeVigencia
     */
    public function setFkDividaModalidade(\Urbem\CoreBundle\Entity\Divida\Modalidade $fkDividaModalidade)
    {
        $this->codModalidade = $fkDividaModalidade->getCodModalidade();
        $this->fkDividaModalidade = $fkDividaModalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaModalidade
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Modalidade
     */
    public function getFkDividaModalidade()
    {
        return $this->fkDividaModalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return ModalidadeVigencia
     */
    public function setFkAdministracaoFuncao(\Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao)
    {
        $this->codModulo = $fkAdministracaoFuncao->getCodModulo();
        $this->codBiblioteca = $fkAdministracaoFuncao->getCodBiblioteca();
        $this->codFuncao = $fkAdministracaoFuncao->getCodFuncao();
        $this->fkAdministracaoFuncao = $fkAdministracaoFuncao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoFuncao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    public function getFkAdministracaoFuncao()
    {
        return $this->fkAdministracaoFuncao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return ModalidadeVigencia
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaTipoModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Divida\TipoModalidade $fkDividaTipoModalidade
     * @return ModalidadeVigencia
     */
    public function setFkDividaTipoModalidade(\Urbem\CoreBundle\Entity\Divida\TipoModalidade $fkDividaTipoModalidade)
    {
        $this->codTipoModalidade = $fkDividaTipoModalidade->getCodTipoModalidade();
        $this->fkDividaTipoModalidade = $fkDividaTipoModalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaTipoModalidade
     *
     * @return \Urbem\CoreBundle\Entity\Divida\TipoModalidade
     */
    public function getFkDividaTipoModalidade()
    {
        return $this->fkDividaTipoModalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaFormaInscricao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\FormaInscricao $fkDividaFormaInscricao
     * @return ModalidadeVigencia
     */
    public function setFkDividaFormaInscricao(\Urbem\CoreBundle\Entity\Divida\FormaInscricao $fkDividaFormaInscricao)
    {
        $this->codFormaInscricao = $fkDividaFormaInscricao->getCodFormaInscricao();
        $this->fkDividaFormaInscricao = $fkDividaFormaInscricao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaFormaInscricao
     *
     * @return \Urbem\CoreBundle\Entity\Divida\FormaInscricao
     */
    public function getFkDividaFormaInscricao()
    {
        return $this->fkDividaFormaInscricao;
    }
}
