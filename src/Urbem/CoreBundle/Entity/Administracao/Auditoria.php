<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Auditoria
 */
class Auditoria
{
    /**
     * PK
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codAcao;

    /**
     * @var string
     */
    private $nomcgm;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $rota;

    /**
     * @var string
     */
    private $modulo;

    /**
     * @var string
     */
    private $submodulo;

    /**
     * @var string
     */
    private $entidade;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $transacao;

    /**
     * @var string
     */
    private $conteudo;

    /**
     * @var string
     */
    private $objeto;

    /**
     * @var string
     */
    private $tipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Acao
     */
    private $fkAdministracaoAcao;

    /**
     * Set id
     *
     * @param integer $id
     * @return Auditoria
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Auditoria
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
     * Set nomcgm
     *
     * @param string $nomcgm
     * @return Auditoria
     */
    public function setNomcgm($nomcgm)
    {
        $this->nomcgm = $nomcgm;
        return $this;
    }

    /**
     * Get nomcgm
     *
     * @return string
     */
    public function getNomcgm()
    {
        return $this->nomcgm;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Auditoria
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set rota
     *
     * @param string $rota
     * @return Auditoria
     */
    public function setRota($rota = null)
    {
        $this->rota = $rota;
        return $this;
    }

    /**
     * Get rota
     *
     * @return string
     */
    public function getRota()
    {
        return $this->rota;
    }

    /**
     * Set modulo
     *
     * @param string $modulo
     * @return Auditoria
     */
    public function setModulo($modulo)
    {
        $this->modulo = $modulo;
        return $this;
    }

    /**
     * Get modulo
     *
     * @return string
     */
    public function getModulo()
    {
        return $this->modulo;
    }

    /**
     * Set submodulo
     *
     * @param string $submodulo
     * @return Auditoria
     */
    public function setSubmodulo($submodulo)
    {
        $this->submodulo = $submodulo;
        return $this;
    }

    /**
     * Get submodulo
     *
     * @return string
     */
    public function getSubmodulo()
    {
        return $this->submodulo;
    }

    /**
     * Set entidade
     *
     * @param string $entidade
     * @return Auditoria
     */
    public function setEntidade($entidade)
    {
        $this->entidade = $entidade;
        return $this;
    }

    /**
     * Get entidade
     *
     * @return string
     */
    public function getEntidade()
    {
        return $this->entidade;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Auditoria
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set conteudo
     *
     * @param string $conteudo
     * @return Auditoria
     */
    public function setConteudo($conteudo)
    {
        $this->conteudo = $conteudo;
        return $this;
    }

    /**
     * Get conteudo
     *
     * @return string
     */
    public function getConteudo()
    {
        return $this->conteudo;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Auditoria
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @return int
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * @param int $codAcao
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return Auditoria
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getTransacao()
    {
        return $this->transacao;
    }

    /**
     * @param string $transacao
     */
    public function setTransacao($transacao)
    {
        $this->transacao = $transacao;
    }

    /**
     * @return string
     */
    public function getObjeto()
    {
        return $this->objeto;
    }

    /**
     * @param string $objeto
     */
    public function setObjeto($objeto)
    {
        $this->objeto = $objeto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Auditoria
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAcao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao
     * @return Auditoria
     */
    public function setFkAdministracaoAcao(\Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao)
    {
        $this->codAcao = $fkAdministracaoAcao->getCodAcao();
        $this->fkAdministracaoAcao = $fkAdministracaoAcao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAcao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Acao
     */
    public function getFkAdministracaoAcao()
    {
        return $this->fkAdministracaoAcao;
    }
}
