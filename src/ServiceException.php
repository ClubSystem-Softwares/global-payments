<?php

namespace CSWeb\GlobalPayments;

use RuntimeException;

/**
 * Class ServiceException
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments
 */
class ServiceException extends RuntimeException
{
    const GLOBAL_ERRORS = [
        'SIS0001' => 'Erro genérico',
        'SIS0002' => 'Erro genérico',
        'SIS0007' => 'Erro ao desmontar o XML de entrada',
        'SIS0008' => 'MerchantCode inválido',
        'SIS0009' => 'Erro no formato de MerchantCode',
        'SIS0010' => 'MerchantTerminal inválido',
        'SIS0011' => 'Erro no formato de MerchantTerminal',
        'SIS0014' => 'Erro no formato no código do pedido',
        'SIS0015' => 'Moeda inválida',
        'SIS0016' => 'Erro no formato da moeda',
        'SIS0018' => 'Valor inválido',
        'SIS0019' => 'Erro no formato do valor',
        'SIS0020' => 'Erro na MerchantSignature',
        'SIS0021' => 'MerchantSignature vazia',
        'SIS0022' => 'Tipo de transação inválida',
        'SIS0023' => 'Tipo de transação desconhecida',
        'SIS0025' => 'Erro no formato de idioma do consumidor',
        'SIS0026' => 'Loja/terminal inexistente',
        'SIS0027' => 'Tipo de moeda não habilitada para este terminal',
        'SIS0028' => 'Loja / terminal está desativado',
        'SIS0030' => 'Operação não é válida',
        'SIS0031' => 'Método de pagamento não reconhecido',
        'SIS0034' => 'Erro ao acessar a base de dados',
        'SIS0035' => 'Erro interno de sistema. Não foi possível recuperar dados da sessão',
        'SIS0038' => 'Erro interno Java',
        'SIS0040' => 'A loja não possui nenhum método de pagamento habilitado',
        'SIS0041' => 'Erro no cálculo da HASH dos dados da loja',
        'SIS0042' => 'A assinatura enviada não está correta',
        'SIS0046' => 'O BIN do cartão não está ativado',
        'SIS0051' => 'Erro número de pedido repetido',
        'SIS0054' => 'Transação não localizada. Não foi possível realizar o cancelamento',
        'SIS0055' => 'Existe mais de um pagamento com o mesmo número de pedido',
        'SIS0056' => 'Cancelamento não autorizado para esta operação',
        'SIS0057' => 'O valor a ser cancelado supera o permitido',
        'SIS0058' => 'Inconsistência de dados na validação da confirmação da transação',
        'SIS0059' => 'Operação não é válida para realizar a confirmação da transação',
        'SIS0060' => 'Já existe uma confirmação associada à esta pré-autorização',
        'SIS0061' => 'Operação não autorizada para confirmar a pré-autorização',
        'SIS0062' => 'O valor a capturar supera o permitido',
        'SIS0063' => 'Número do cartão não disponível',
        'SIS0064' => 'O número do cartão não pode ter mais de 19 posições',
        'SIS0065' => 'O número do cartão não é numérico',
        'SIS0066' => 'Mês de expiração não disponível',
        'SIS0067' => 'O mês de expiração não é numérico',
        'SIS0068' => 'O mês da expiração não é válido',
        'SIS0069' => 'Ano de expiração não disponível',
        'SIS0070' => 'O ano de expiração não é numérico',
        'SIS0071' => 'Cartão expirado',
        'SIS0072' => 'Operação não é possível de ser anulada',
        'SIS0073' => 'Erro no cancelamento',
        'SIS0074' => 'Código do pedido inválido',
        'SIS0075' => 'Código do pedido tem menos de 4 posições ou mais de 12',
        'SIS0076' => 'Código do pedido não possui as 4 primeiras posições preenchidas com números',
        'SIS0077' => 'Código do pedido não está formatado corretamente',
        'SIS0078' => 'Método de pagamento não disponível',
        'SIS0079' => 'Erro ao realizar o pagamento com cartão',
        'SIS0081' => 'Nova sessão',
        'SIS0089' => 'Vencimento do cartão não ocupa 4 posições',
        'SIS0092' => 'Vencimento do cartão é nulo',
        'SIS0093' => 'Cartão não reconhecido',
        'SIS0112' => 'Tipo de transação não é permitido',
        'SIS0114' => 'Está realizando a chamada por GET',
        'SIS0132' => 'A data da captura não pode superar mais de 7 dias a partir da pré-autorização',
        'SIS0142' => 'Tempo excedido para o pagamento',
        'SIS0181' => 'Erro interno da Redsys - Erro ao montar o XML com os dados recebidos',
        'SIS0184' => 'Erro interno da Redsys - Erro ao tratar o XML do recibo',
        'SIS0216' => 'O campo CVV tem mais de 3 ou 4 posições',
        'SIS0217' => 'Erro de formato do CVV',
        'SIS0221' => 'CVV é obrigatório',
        'SIS0222' => 'Já existe um cancelamento associado à pré-autorização',
        'SIS0223' => 'Cancelamento da Pré-autorização não autorizada',
        'SIS0225' => 'Não existe transação para realizar o cancelamento',
        'SIS0226' => 'Inconsistência de dados na validação de cancelamento da transação',
        'SIS0227' => 'Data de Transação inválida',
        'SIS0252' => 'A loja não permite o envio do cartão',
        'SIS0253' => 'Verifique se o seu cartão é válido',
        'SIS0261' => 'Operação cancelada, pois, infringe o controle de restrições na entrada ao sistema',
        'SIS0274' => 'Operação desconhecida ou não permitida na entrada ao sistema',
        'SIS0414' => 'O plano de venda não está correto',
        'SIS0415' => 'O tipo de produto não está correto',
        'SIS0416' => 'Valor não permitido para cancelamento',
        'SIS0417' => 'Cancelamento não permitido por exceder o prazo limite',
        'SIS0418' => 'Não existe plano de vendas vigente para esta operação',
        'SIS0419' => 'Tipo de transação (cre/deb) é incompatível com a configuraçnao do cartão',
        'SIS0420' => 'A loja não possui este tipo de pagamento habilitado para este tipo de operação',
        'SIS0423' => 'CNPJ do estabelecimento está incorreto',
        'SIS0428' => 'Transação de débito não autenticada. Verifique se o seu sistema está corretamente configurado pois este tipo de transação não é permitida',
        'SIS0466' => 'A referência utilizada para este pagamento não existe. Verifique os dados da transação',
        'SIS0467' => 'A referência utilizada para este pagamento já está processada',
        'SIS0468' => 'A referência da transação utilizada não é válida para o adquirente',
        'SIS0481' => 'O estabelecimento não pertence a um Facilitador de Pagamentos',
        'SIS0489' => 'Erro nos dados de solicitação de venda autenticada. Operação com MPI Externo não é permitida. Verifique se os campos adequados estão presentes',
        'SIS0490' => 'Erro nos dados na mensagem do comércio eletrônico. Existem parâmetros de autenticação 3DSecure Interno em uma operação com MPI Externo. Em uma operação com dados de MPI externo no se permitem os parâmetros DS_MERCHANT_ACCEPTHEADER e DS_MERCHANT_USERAGENT',
        'SIS0491' => 'Erro nos dados na mensagem do comércio eletrônico. SecLevel não permitido em uma operação de MPI Externo. Revise os possíveis valores deste campo',
        'SIS0492' => 'Erro nos dados na mensagem do comércio eletrônico. Existem parâmetros de MPI Externo em uma operação de autenticação 3DS Interna. Em uma operação 3DSecure Interna não são permitidos os parâmetros DS_MERCHANT_SECLEVEL',
        'SIS0493' => 'Parâmetros de transação segura recebidos em uma solicitação de pagamento não seguro. O campo DS_MERCHANT_TRANSACTIONTYPE=A não é compatível com os parâmetros DS_MERCHANT_ACCEPTHEADER e DS_MERCHANT_USERAGENT',
        'SIS0524' => 'Não é possível realizar a autenticação 3DSecure MasterCard SecureCode Externo porque não está presente o campo CAVV do emissor na mensagem de solicitação autorização',
    ];

    public static function throwInternalError(string $errorCode)
    {
        $message = array_key_exists($errorCode, self::GLOBAL_ERRORS)
            ? self::GLOBAL_ERRORS[$errorCode]
            : 'An error ocurred while getting error message. Please try again';

        throw new ServiceException($message);
    }
}