<?php

namespace Urbem\CoreBundle\Exception;

class Error
{
    const INVALID_TEXT_EMPTY = 'Text can not be empty';
    const INVALID_VALUE = 'Valor inválido';
    const INVALID_REFERENCE_CLASS = 'Class referenced not declared';
    const INVALID_CLASS = 'Objeto enviado não faz referencia ao dado esperado';
    const INVALID_REFERENCE_CLASS_NOT_FOUND = 'Class referenced not found';
    const INVALID_PARAMETER_ZERO = 'The parameter is not equals zero number';
    const INVALID_PARAMETER_UF_MUNICIPIO = 'The parameter UF or Municipio can not be empty';
    const INVALID_CONFIGURATION_MIGRATION_ORGANOGRAMA = 'Para processar um organograma o usuário deverá realizar a configuração e migração do mesmo.';
    const INVALID_CONFIGURATION = 'Não encontratos este conjunto de configurações para o exercício correte, procure o administrador dos sistema';
    const ERROR_PERSIST_DATA = 'Erro ao inserir registro, por favor, tente novamente.';
    const ERROR_EDIT_DATA = 'Erro ao editar registro, por favor, tente novamente.';
    const ERROR_MIGRATION_NOT_FOUND = 'Organograma já foi migrado ou um novo não foi configurado';
    const ERROR_MIGRATION_ORGANOGRAMA = 'Erro ao processar migração do organograma, procure o administrador do sistema';
    const ERROR_REMOVE_DATA = 'Erro ao remover registro, por favor, tente novamente.';
    const ERROR_COMMUNICATION_SERVER_REPORT = 'Erro na comunicação com o servidor de relatórios';
    const ERROR_WITHOUT_ID_SERVER_REPORT = 'Erro na resposta do servidor de relatório, ID não identificado';
    const PROCESS_ALREADY_EXISTS = 'Já consta um recebimento para este processo';
    const ORGAO_NIVEL_NOT_FOUND = 'Não existe o orgao nivel relacionado a este orgão';
    const CLASS_NOT_FOUND = 'Classe não encontrada';
    const VALUE_NOT_FOUND = 'Valor não encontrado';

    public static function getConstants()
    {
        $errorClass = new \ReflectionClass(__CLASS__);
        return new \ArrayIterator($errorClass->getConstants());
    }
}
