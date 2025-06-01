<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Validador para formato de CPF (com máscara)
        Validator::extend('formato_cpf', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $value);
        });

        // Mensagem de erro para o formato
        Validator::replacer('formato_cpf', function ($message, $attribute, $rule, $parameters) {
            return "O campo $attribute deve estar no formato 000.000.000-00";
        });

        // Validador para CPF válido (dígitos verificadores)
        Validator::extend('cpf_valido', function ($attribute, $value, $parameters, $validator) {
            $cpf = preg_replace('/[^0-9]/', '', $value);
            
            // Verifica se todos os dígitos são iguais
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                return false;
            }
            
            // Cálculo dos dígitos verificadores
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }
            return true;
        });

        // Mensagem de erro para CPF inválido
        Validator::replacer('cpf_valido', function ($message, $attribute, $rule, $parameters) {
            return "O $attribute informado não é válido";
        });
    }
}