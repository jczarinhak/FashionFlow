<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Produto;
use Carbon\Carbon;

class CleanupTrashedProducts extends Command
{
    protected $signature = 'products:cleanup';
    protected $description = 'Remove permanentemente produtos na lixeira há mais de 30 dias';

    public function handle()
    {
        // Definir o limite de 30 dias
        $threshold = Carbon::now()->subDays(30);

        // Contar os produtos que estão na lixeira há mais de 30 dias
        $count = Produto::onlyTrashed()
                       ->where('deleted_at', '<', $threshold)
                       ->count();

        // Excluir os produtos permanentemente
        Produto::onlyTrashed()
               ->where('deleted_at', '<', $threshold)
               ->forceDelete();

        // Exibir a quantidade de produtos removidos
        $this->info("{$count} produtos removidos permanentemente da lixeira.");
        return 0;
    }
}
