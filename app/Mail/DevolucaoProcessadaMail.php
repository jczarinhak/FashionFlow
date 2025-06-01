<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DevolucaoProcessadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $venda;
    public $valor;
    public $produtos;

    /**
     * Create a new message instance.
     */
    public function __construct($venda, $valor, $produtos)
    {
        $this->venda = $venda;
        $this->valor = $valor;
        $this->produtos = $produtos;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.devolucao-processada')
                    ->subject('Devolução Processada com Sucesso')
                    ->with([
                        'venda' => $this->venda,
                        'valor' => $this->valor,
                        'produtos' => $this->produtos,
                    ]);
    }
}
