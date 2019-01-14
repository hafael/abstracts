<?php

namespace Hafael\Abstracts\Http\Requests;


class EditarPessoaFisicaRequest extends BaseFormRequest
{
    protected $requestRules = [

        'id' => 'sometimes|string|max:20|exists:application.CAD_PES_PESSOAS,pes_pessoas_id',

        'nome' => 'string|min:3|max:255',
        'apelido' => 'string',
        'cpf' => 'numeric|min:11',
        'registroGeral' => 'string',
        'orgaoEmissorRG' => 'string',
        'sexo' => 'in:M,F',
        'estadoCivil' => 'string',
        'dataDeNascimento' => 'date',
        'imagemDoPerfil' => 'file',
        'naturalidade' => 'string',
        'escolaridade' => 'string',
        'pronomeDeTratamento' => 'string',

    ];

    protected $requestMessages = [
        //
    ];

    protected $attributeMap = [

        'nome' => 'pes_nome_razao',
        'apelido' => 'pes_apelido_fantasia',
        'cpf' => 'pes_cpfcnpj',
        'registroGeral' => 'pes_inscricao_rg_est',
        'orgaoEmissorRG' => 'pes_orgaorg',
        'dataDeNascimento' => 'pes_data_nasc_fund',
        'imagemDoPerfil' => 'pes_foto_logo',
        'estadoCivil' => 'pes_estado_civil',
        'sexo' => 'pes_sexo',
        'naturalidade' => 'pes_naturalidade',
        'escolaridade' => 'pes_escolaridade',
        'pronomeDeTratamento' => 'pes_tratamento',

    ];

    protected $availableAttributes = [

        'nome',
        'apelido',
        'cpf',
        'registroGeral',
        'orgaoEmissorRG',
        'dataDeNascimento',
        'imagemDoPerfil',
        'estadoCivil',
        'sexo',
        'naturalidade',
        'escolaridade',
        'pronomeDeTratamento',
    ];

    protected $attributeValues = [
        //
    ];

    protected $attributeClearValues = [
        'cpf' => '/[^0-9]/',
        'registroGeral' => '/[^0-9]/',
    ];

    protected $attributeParseDates = [
        'dataDeNascimento',
    ];
}